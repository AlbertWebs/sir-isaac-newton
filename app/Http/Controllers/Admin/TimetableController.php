<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can manage timetables.');
        }

        $query = Timetable::with(['schoolClass', 'subject', 'teacher']);
        
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->get('class_id'));
        }
        
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->get('academic_year'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $timetables = $query->orderBy('day')
            ->orderBy('start_time')
            ->get()
            ->groupBy('class_id');

        $classes = SchoolClass::where('status', 'active')->orderBy('level')->orderBy('name')->get();
        $selectedClass = $request->get('class_id') ? SchoolClass::find($request->get('class_id')) : null;
        $academicYear = $request->get('academic_year', date('Y'));
        $statusFilter = $request->get('status', 'active');

        // Get conflicts for selected class
        $conflicts = [];
        if ($selectedClass) {
            $conflicts = $this->detectConflicts($selectedClass->id, $academicYear);
        }

        return view('admin.timetables.index', compact(
            'timetables',
            'classes',
            'selectedClass',
            'academicYear',
            'statusFilter',
            'conflicts'
        ));
    }

    public function create(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can create timetables.');
        }

        $classes = SchoolClass::where('status', 'active')->orderBy('level')->orderBy('name')->get();
        $subjects = Subject::where('status', 'active')->orderBy('name')->get();
        $teachers = Teacher::where('status', 'active')->orderBy('first_name')->get();
        
        $selectedClassId = $request->get('class_id');
        $selectedClass = $selectedClassId ? SchoolClass::find($selectedClassId) : null;
        $classSubjects = $selectedClass ? $selectedClass->subjects : collect();

        return view('admin.timetables.create', compact(
            'classes',
            'subjects',
            'teachers',
            'selectedClass',
            'classSubjects'
        ));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can create timetables.');
        }

        $validated = $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'day' => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['nullable', 'string', 'max:50'],
            'academic_year' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Check for conflicts
        $conflicts = $this->checkConflicts($validated);
        
        if (!empty($conflicts)) {
            return back()
                ->withInput()
                ->withErrors(['conflict' => 'Schedule conflicts detected: ' . implode(', ', $conflicts)])
                ->with('conflict_details', $conflicts);
        }

        Timetable::create($validated);

        return redirect()->route('admin.timetables.index', ['class_id' => $validated['class_id'], 'academic_year' => $validated['academic_year']])
            ->with('success', 'Timetable entry created successfully!');
    }

    public function show(Timetable $timetable)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can view timetable details.');
        }

        $timetable->load('schoolClass', 'subject', 'teacher');
        return view('admin.timetables.show', compact('timetable'));
    }

    public function edit(Timetable $timetable)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can edit timetables.');
        }

        $classes = SchoolClass::where('status', 'active')->orderBy('level')->orderBy('name')->get();
        $subjects = Subject::where('status', 'active')->orderBy('name')->get();
        $teachers = Teacher::where('status', 'active')->orderBy('first_name')->get();
        
        $selectedClass = $timetable->schoolClass;
        $classSubjects = $selectedClass ? $selectedClass->subjects : collect();

        return view('admin.timetables.edit', compact(
            'timetable',
            'classes',
            'subjects',
            'teachers',
            'selectedClass',
            'classSubjects'
        ));
    }

    public function update(Request $request, Timetable $timetable)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can update timetables.');
        }

        $validated = $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'day' => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['nullable', 'string', 'max:50'],
            'academic_year' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Check for conflicts (excluding current timetable)
        $conflicts = $this->checkConflicts($validated, $timetable->id);
        
        if (!empty($conflicts)) {
            return back()
                ->withInput()
                ->withErrors(['conflict' => 'Schedule conflicts detected: ' . implode(', ', $conflicts)])
                ->with('conflict_details', $conflicts);
        }

        $timetable->update($validated);

        return redirect()->route('admin.timetables.index', ['class_id' => $validated['class_id'], 'academic_year' => $validated['academic_year']])
            ->with('success', 'Timetable entry updated successfully!');
    }

    public function destroy(Timetable $timetable)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can delete timetables.');
        }

        $classId = $timetable->class_id;
        $academicYear = $timetable->academic_year;
        
        $timetable->delete();

        return redirect()->route('admin.timetables.index', ['class_id' => $classId, 'academic_year' => $academicYear])
            ->with('success', 'Timetable entry deleted successfully!');
    }

    public function downloadPdf(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can download timetables.');
        }

        $classId = $request->get('class_id');
        $academicYear = $request->get('academic_year', date('Y'));

        if ($classId) {
            // Single class PDF
            $class = SchoolClass::findOrFail($classId);
            $timetables = Timetable::where('class_id', $classId)
                ->where('academic_year', $academicYear)
                ->where('status', 'active')
                ->with(['subject', 'teacher'])
                ->orderBy('day')
                ->orderBy('start_time')
                ->get()
                ->groupBy('day');

            return $this->generateClassPdf($class, $timetables, $academicYear);
        } else {
            // All classes PDF
            $classes = SchoolClass::where('status', 'active')->orderBy('level')->orderBy('name')->get();
            return $this->generateAllClassesPdf($classes, $academicYear);
        }
    }

    /**
     * Check for scheduling conflicts
     */
    protected function checkConflicts(array $data, $excludeId = null): array
    {
        $conflicts = [];
        $newStart = $data['start_time'];
        $newEnd = $data['end_time'];

        // Check for class conflicts (same class, same day, overlapping time)
        $classConflictQuery = Timetable::where('class_id', $data['class_id'])
            ->where('day', $data['day'])
            ->where('academic_year', $data['academic_year'])
            ->where('status', 'active')
            ->where(function($query) use ($newStart, $newEnd) {
                // Overlapping conditions: periods overlap if:
                // 1. New start is between existing start and end
                // 2. New end is between existing start and end
                // 3. New period completely contains existing period
                // 4. Existing period completely contains new period
                $query->where(function($q) use ($newStart, $newEnd) {
                    $q->where('start_time', '<=', $newStart)
                      ->where('end_time', '>', $newStart);
                })->orWhere(function($q) use ($newStart, $newEnd) {
                    $q->where('start_time', '<', $newEnd)
                      ->where('end_time', '>=', $newEnd);
                })->orWhere(function($q) use ($newStart, $newEnd) {
                    $q->where('start_time', '>=', $newStart)
                      ->where('end_time', '<=', $newEnd);
                })->orWhere(function($q) use ($newStart, $newEnd) {
                    $q->where('start_time', '<=', $newStart)
                      ->where('end_time', '>=', $newEnd);
                });
            })
            ->with('subject');

        if ($excludeId) {
            $classConflictQuery->where('id', '!=', $excludeId);
        }

        $classConflicts = $classConflictQuery->get();
        foreach ($classConflicts as $conflicting) {
            $conflicts[] = "Class already has a period at this time: {$conflicting->subject->name}";
        }

        // Check for teacher conflicts (same teacher, same day, overlapping time)
        if ($data['teacher_id']) {
            $teacherConflictQuery = Timetable::where('teacher_id', $data['teacher_id'])
                ->where('day', $data['day'])
                ->where('academic_year', $data['academic_year'])
                ->where('status', 'active')
                ->where(function($query) use ($newStart, $newEnd) {
                    $query->where(function($q) use ($newStart, $newEnd) {
                        $q->where('start_time', '<=', $newStart)
                          ->where('end_time', '>', $newStart);
                    })->orWhere(function($q) use ($newStart, $newEnd) {
                        $q->where('start_time', '<', $newEnd)
                          ->where('end_time', '>=', $newEnd);
                    })->orWhere(function($q) use ($newStart, $newEnd) {
                        $q->where('start_time', '>=', $newStart)
                          ->where('end_time', '<=', $newEnd);
                    })->orWhere(function($q) use ($newStart, $newEnd) {
                        $q->where('start_time', '<=', $newStart)
                          ->where('end_time', '>=', $newEnd);
                    });
                })
                ->with(['schoolClass', 'subject']);

            if ($excludeId) {
                $teacherConflictQuery->where('id', '!=', $excludeId);
            }

            $teacherConflicts = $teacherConflictQuery->get();
            foreach ($teacherConflicts as $conflicting) {
                $conflicts[] = "Teacher already assigned at this time: {$conflicting->schoolClass->name} - {$conflicting->subject->name}";
            }
        }

        // Check for room conflicts (optional but recommended)
        if (!empty($data['room'])) {
            $roomConflictQuery = Timetable::where('room', $data['room'])
                ->where('day', $data['day'])
                ->where('academic_year', $data['academic_year'])
                ->where('status', 'active')
                ->where(function($query) use ($newStart, $newEnd) {
                    $query->where(function($q) use ($newStart, $newEnd) {
                        $q->where('start_time', '<=', $newStart)
                          ->where('end_time', '>', $newStart);
                    })->orWhere(function($q) use ($newStart, $newEnd) {
                        $q->where('start_time', '<', $newEnd)
                          ->where('end_time', '>=', $newEnd);
                    })->orWhere(function($q) use ($newStart, $newEnd) {
                        $q->where('start_time', '>=', $newStart)
                          ->where('end_time', '<=', $newEnd);
                    })->orWhere(function($q) use ($newStart, $newEnd) {
                        $q->where('start_time', '<=', $newStart)
                          ->where('end_time', '>=', $newEnd);
                    });
                })
                ->with(['schoolClass', 'subject']);

            if ($excludeId) {
                $roomConflictQuery->where('id', '!=', $excludeId);
            }

            $roomConflicts = $roomConflictQuery->get();
            foreach ($roomConflicts as $conflicting) {
                $conflicts[] = "Room already booked at this time: {$conflicting->schoolClass->name} - {$conflicting->subject->name}";
            }
        }

        return $conflicts;
    }

    /**
     * Detect all conflicts for a class
     */
    protected function detectConflicts($classId, $academicYear): array
    {
        $timetables = Timetable::where('class_id', $classId)
            ->where('academic_year', $academicYear)
            ->where('status', 'active')
            ->with(['subject', 'teacher', 'schoolClass'])
            ->get();

        $conflicts = [];
        
        foreach ($timetables as $timetable) {
            $data = [
                'class_id' => $timetable->class_id,
                'teacher_id' => $timetable->teacher_id,
                'day' => $timetable->day,
                'start_time' => $timetable->start_time->format('H:i'),
                'end_time' => $timetable->end_time->format('H:i'),
                'room' => $timetable->room,
                'academic_year' => $timetable->academic_year,
                'status' => $timetable->status,
            ];

            $timetableConflicts = $this->checkConflicts($data, $timetable->id);
            if (!empty($timetableConflicts)) {
                $conflicts[$timetable->id] = $timetableConflicts;
            }
        }

        return $conflicts;
    }

    /**
     * Generate PDF for a single class
     */
    protected function generateClassPdf($class, $timetables, $academicYear)
    {
        // Return HTML view optimized for printing/PDF generation
        // Users can use browser's "Print to PDF" or integrate a PDF library like dompdf
        return view('admin.timetables.pdf.class', compact('class', 'timetables', 'academicYear'));
    }

    /**
     * Generate PDF for all classes
     */
    protected function generateAllClassesPdf($classes, $academicYear)
    {
        $allTimetables = [];
        foreach ($classes as $class) {
            $timetables = Timetable::where('class_id', $class->id)
                ->where('academic_year', $academicYear)
                ->where('status', 'active')
                ->with(['subject', 'teacher'])
                ->orderBy('day')
                ->orderBy('start_time')
                ->get()
                ->groupBy('day');
            
            if ($timetables->isNotEmpty()) {
                $allTimetables[$class->id] = $timetables;
            }
        }

        return view('admin.timetables.pdf.all-classes', compact('classes', 'allTimetables', 'academicYear'));
    }
}

