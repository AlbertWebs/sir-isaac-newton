<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\StudentResult;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * List students
     */
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('class_id')) {
            $query->whereHas('classes', function ($q) use ($request) {
                $q->where('class_id', $request->class_id)
                  ->where('status', 'active');
            });
        }

        return response()->json($query->paginate($request->get('per_page', 15)));
    }

    /**
     * Get student details
     */
    public function show($id)
    {
        $student = Student::with(['parents', 'classes', 'routeAssignments.route'])
            ->findOrFail($id);

        return response()->json($student);
    }

    /**
     * Create student
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_number' => 'required|unique:students,student_number',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email|unique:students,email',
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'level_of_education' => 'required|string',
            'address' => 'nullable|string',
        ]);

        $student = Student::create($request->all());

        return response()->json($student, 201);
    }

    /**
     * Update student
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'student_number' => 'sometimes|unique:students,student_number,' . $id,
            'email' => 'sometimes|email|unique:students,email,' . $id,
        ]);

        $student->update($request->all());

        return response()->json($student);
    }

    /**
     * Get student attendance
     */
    public function attendance($id, Request $request)
    {
        $query = Attendance::where('student_id', $id)
            ->with('course');

        if ($request->has('date_from')) {
            $query->where('attendance_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('attendance_date', '<=', $request->date_to);
        }

        return response()->json($query->get());
    }

    /**
     * Get student results
     */
    public function results($id, Request $request)
    {
        $query = StudentResult::where('student_id', $id)
            ->with('course');

        if ($request->has('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        return response()->json($query->get());
    }
}

