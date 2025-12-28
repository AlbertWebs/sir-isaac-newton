<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\Attendance;
use App\Models\StudentResult;
use Illuminate\Http\Request;

class AcademicsController extends Controller
{
    /**
     * Get classes
     */
    public function classes(Request $request)
    {
        $query = SchoolClass::with('classTeacher');

        if ($request->has('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        return response()->json($query->get());
    }

    /**
     * Get subjects
     */
    public function subjects(Request $request)
    {
        $query = Subject::where('status', 'active');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        return response()->json($query->get());
    }

    /**
     * Get subjects for a class
     */
    public function classSubjects($classId)
    {
        $class = SchoolClass::findOrFail($classId);
        $subjects = $class->subjects()->where('status', 'active')->get();
        
        return response()->json(['subjects' => $subjects]);
    }

    /**
     * Get timetables
     */
    public function timetables(Request $request)
    {
        $query = Timetable::with(['schoolClass', 'subject', 'teacher'])
            ->where('status', 'active');

        if ($request->has('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->has('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        return response()->json($query->get());
    }

    /**
     * Get attendance
     */
    public function attendance(Request $request)
    {
        $query = Attendance::with(['student', 'course']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('date_from')) {
            $query->where('attendance_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('attendance_date', '<=', $request->date_to);
        }

        return response()->json($query->get());
    }

    /**
     * Mark attendance
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'notes' => 'nullable|string',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'attendance_date' => $request->attendance_date,
            ],
            [
                'teacher_id' => $request->user()->id ?? null,
                'status' => $request->status,
                'notes' => $request->notes,
            ]
        );

        return response()->json($attendance, 201);
    }

    /**
     * Get exams
     */
    public function exams(Request $request)
    {
        // This would require an exams table - placeholder for now
        return response()->json([]);
    }

    /**
     * Get results
     */
    public function results(Request $request)
    {
        $query = StudentResult::with(['student', 'course']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        return response()->json($query->get());
    }

    /**
     * Store result
     */
    public function storeResult(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|string',
            'term' => 'required|string',
            'exam_type' => 'required|string',
            'marks' => 'required|numeric|min:0|max:100',
            'grade' => 'nullable|string',
        ]);

        $result = StudentResult::create($request->all());

        return response()->json($result, 201);
    }
}

