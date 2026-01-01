<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineApplication;
use Illuminate\Http\Request;

class OnlineApplicationController extends Controller
{
    public function index()
    {
        $applications = OnlineApplication::with('schoolClass')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.online-applications.index', compact('applications'));
    }

    public function show(OnlineApplication $onlineApplication)
    {
        return view('admin.online-applications.show', compact('onlineApplication'));
    }

    public function updateStatus(Request $request, OnlineApplication $onlineApplication)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);

        // Store old status to check for changes
        $oldStatus = $onlineApplication->status;

        $onlineApplication->update($validated);

        // If status changed to 'accepted' and it wasn't accepted before, create a new student
        if ($onlineApplication->status == 'accepted' && $oldStatus !== 'accepted') {
            // Use a try-catch block for robust error handling during student creation
            try {
                // Generate a simple student number and admission number
                $latestStudent = \App\Models\Student::latest('id')->first();
                $studentNumber = 'SN' . str_pad(($latestStudent ? $latestStudent->id + 1 : 1), 5, '0', STR_PAD_LEFT);
                $admissionNumber = 'ADM' . str_pad(($latestStudent ? $latestStudent->id + 1 : 1), 5, '0', STR_PAD_LEFT);

                // Create the student record
                $student = \App\Models\Student::create([
                    'student_number' => $studentNumber,
                    'admission_number' => $admissionNumber,
                    'first_name' => $onlineApplication->child_name, // Assuming child_name is full name for simplicity
                    'last_name' => '.', // Placeholder, can be improved with parsing child_name
                    'email' => $onlineApplication->parent_email, // Using parent email for student login (can be adjusted)
                    'phone' => $onlineApplication->phone,
                    'date_of_birth' => $onlineApplication->child_dob,
                    'gender' => 'unknown', // Default value, can be expanded in form
                    'level_of_education' => $onlineApplication->schoolClass->level ?? 'unknown',
                    'next_of_kin_name' => $onlineApplication->parent_name,
                    'next_of_kin_mobile' => $onlineApplication->phone,
                    'address' => 'N/A', // Default value, can be expanded in form
                    'status' => 'active',
                    'password' => bcrypt('password'), // Default password, force reset on first login
                ]);

                // Enroll student into the applied class
                if ($onlineApplication->schoolClass) {
                    $student->classes()->attach($onlineApplication->schoolClass->id, [
                        'academic_year' => date('Y') . '/' . (date('Y') + 1),
                        'enrollment_date' => now(),
                        'status' => 'active',
                    ]);
                }

                return redirect()->route('admin.website.online-applications.show', $onlineApplication)->with('success', 'Application status updated and new student enrolled successfully!');

            } catch (\Exception $e) {
                // Log the error for debugging purposes
                \Log::error('Error enrolling student from online application: ' . $e->getMessage(), [
                    'application_id' => $onlineApplication->id,
                    'error' => $e->getTraceAsString(),
                ]);
                return redirect()->route('admin.website.online-applications.show', $onlineApplication)->with('error', 'Application status updated, but student enrollment failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.website.online-applications.show', $onlineApplication)->with('success', 'Application status updated successfully.');
    }
}

