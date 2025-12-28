<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\LedgerEntry;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::where('status', 'active')->orderBy('first_name')->get();
        $classes = SchoolClass::where('status', 'active')->orderBy('level')->orderBy('name')->get();
        
        // Get current academic year and term for term-based billing
        $currentAcademicYear = $this->getCurrentAcademicYear();
        $currentTerm = $this->getCurrentTerm();
        
        // Pre-select student if provided in query string
        $selectedStudentId = $request->get('student_id');
        
        return view('billing.index', compact('students', 'classes', 'currentAcademicYear', 'currentTerm', 'selectedStudentId'));
    }
    
    private function getCurrentTerm(): string
    {
        $month = now()->month;
        
        // Term 1: January - April (months 1-4)
        // Term 2: May - August (months 5-8)
        // Term 3: September - December (months 9-12)
        if ($month >= 1 && $month <= 4) {
            return 'Term 1';
        } elseif ($month >= 5 && $month <= 8) {
            return 'Term 2';
        } else {
            return 'Term 3';
        }
    }

    private function getCurrentAcademicYear(): string
    {
        $year = now()->year;
        $month = now()->month;
        
        if ($month >= 9) {
            return $year . '/' . ($year + 1);
        } else {
            return ($year - 1) . '/' . $year;
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'class_id' => ['required', 'exists:classes,id'],
            'academic_year' => ['required', 'string'],
            'term' => ['required', 'string', 'in:Term 1,Term 2,Term 3'],
            'agreed_amount' => ['required', 'numeric', 'min:0'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);
        
        // Ensure no discounts - agreed amount must equal amount paid
        if (abs($validated['agreed_amount'] - $validated['amount_paid']) > 0.01) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['amount_paid' => 'Amount paid must equal the agreed amount. No discounts are allowed.']);
        }

        $class = SchoolClass::findOrFail($validated['class_id']);
        
        // Find or create a course record for backward compatibility (using class name)
        $course = Course::firstOrCreate(
            ['code' => $class->code],
            [
                'name' => $class->name,
                'base_price' => $class->price ?? 0,
                'status' => 'active',
            ]
        );
        
        $payment = Payment::create([
            'student_id' => $validated['student_id'],
            'course_id' => $course->id, // Keep for backward compatibility
            'academic_year' => $validated['academic_year'],
            'term' => $validated['term'],
            'agreed_amount' => $validated['agreed_amount'],
            'amount_paid' => $validated['amount_paid'],
            'base_price' => $class->price ?? 0,
            'discount_amount' => 0, // No discounts allowed
            'cashier_id' => auth()->id(),
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'],
        ]);

        // Generate receipt with serialized receipt number
        $receipt = Receipt::create([
            'payment_id' => $payment->id,
            'receipt_number' => Receipt::generateReceiptNumber(),
            'receipt_date' => now(),
        ]);

        // Refresh payment to load receipt relationship
        $payment->refresh();

        // Automatically register student for the course if not already registered
        // Check if registration already exists for this student, course, academic year, and term
        $existingRegistration = CourseRegistration::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->where('academic_year', $validated['academic_year'])
            ->where('term', $validated['term'])
            ->first();

        if (!$existingRegistration) {
            CourseRegistration::create([
                'student_id' => $validated['student_id'],
                'course_id' => $validated['course_id'],
                'academic_year' => $validated['academic_year'],
                'term' => $validated['term'],
                'registration_date' => now(),
                'status' => 'registered',
                'notes' => 'Auto-registered upon payment',
            ]);
        }

        // Create ledger entry for money trace
        LedgerEntry::createFromPayment($payment);

        // Send payment confirmation SMS
        try {
            $smsService = app(\App\Services\SmsService::class);
            $smsService->sendPaymentSMS(
                $payment->student,
                $payment->amount_paid,
                $class->name,
                $receipt->receipt_number
            );
        } catch (\Exception $e) {
            // Log error but don't fail the payment
            \Log::error("Failed to send payment SMS", [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Send payment confirmation email
        try {
            $emailService = app(\App\Services\EmailService::class);
            $emailService->sendPaymentEmail(
                $payment->student,
                $payment->amount_paid,
                $class->name,
                $receipt->receipt_number
            );
        } catch (\Exception $e) {
            // Log error but don't fail the payment
            \Log::error("Failed to send payment email", [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Log the activity
        ActivityLog::log(
            'payment.created',
            "Processed payment of KES " . number_format($payment->amount_paid, 2) . " from {$payment->student->full_name} for {$class->name} (Receipt: {$receipt->receipt_number})",
            $payment
        );

        return redirect()->route('receipts.show', $receipt->id)
            ->with('success', 'Payment processed successfully!');
    }

    public function getClassInfo($classId)
    {
        $class = SchoolClass::findOrFail($classId);
        $user = auth()->user();

        // Only Super Admin can see price
        if ($user->isSuperAdmin()) {
            return response()->json([
                'id' => $class->id,
                'name' => $class->name,
                'code' => $class->code,
                'price' => $class->price,
            ]);
        }

        // Cashier sees no price information
        return response()->json([
            'id' => $class->id,
            'name' => $class->name,
            'code' => $class->code,
        ]);
    }

    public function getStudentClasses($studentId, Request $request)
    {
        $student = Student::findOrFail($studentId);
        
        // Get selected term from request (if provided)
        $selectedTerm = $request->get('term');
        
        // Get current academic year
        $currentAcademicYear = $this->getCurrentAcademicYear();
        
        // Get all active classes (not just enrolled ones)
        // This allows students to pay for classes in different terms
        $allClasses = SchoolClass::where('status', 'active')
            ->orderBy('level')
            ->orderBy('name')
            ->get();
        
        // If a specific term is selected, prioritize classes the student is enrolled in
        // But still show all classes to allow payment for any class in any term
        $classes = $allClasses->map(function ($class) use ($studentId, $currentAcademicYear, $selectedTerm) {
            // Check if student is enrolled in this class
            $isEnrolled = false;
            if ($selectedTerm) {
                $isEnrolled = $class->students()
                    ->where('student_id', $studentId)
                    ->wherePivot('academic_year', $currentAcademicYear)
                    ->exists();
            }
            
            return [
                'id' => $class->id,
                'name' => $class->name,
                'code' => $class->code,
                'level' => $class->level,
                'enrolled' => $isEnrolled,
            ];
        });
        
        return response()->json($classes);
    }
}
