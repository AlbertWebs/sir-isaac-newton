<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can manage classes.');
        }

        $query = SchoolClass::with('classTeacher');
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('level', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('level')) {
            $query->where('level', $request->get('level'));
        }

        $classes = $query->latest()->paginate(20)->withQueryString();
        $searchTerm = $request->get('search', '');
        $statusFilter = $request->get('status', '');
        $levelFilter = $request->get('level', '');

        return view('admin.classes.index', compact('classes', 'searchTerm', 'statusFilter', 'levelFilter'));
    }

    public function create()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can create classes.');
        }

        $teachers = Teacher::where('status', 'active')->get();
        return view('admin.classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can create classes.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:classes,code'],
            'level' => ['required', 'string', 'max:50'],
            'academic_year' => ['required', 'string', 'max:20'],
            'term' => ['required', 'in:1,2,3'],
            'class_teacher_id' => ['nullable', 'exists:teachers,id'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string'],
        ]);

        // Convert level to lowercase to match database constraint
        $validated['level'] = strtolower($validated['level']);

        // Set current_enrollment to 0 initially (will be calculated dynamically)
        $validated['current_enrollment'] = 0;

        SchoolClass::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class created successfully!');
    }

    public function show(SchoolClass $class)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can view class details.');
        }

        $class->load('classTeacher', 'students', 'subjects');
        return view('admin.classes.show', compact('class'));
    }

    public function edit(SchoolClass $class)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can edit classes.');
        }

        $teachers = Teacher::where('status', 'active')->get();
        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can update classes.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:classes,code,' . $class->id],
            'level' => ['required', 'string', 'max:50'],
            'academic_year' => ['required', 'string', 'max:20'],
            'term' => ['required', 'in:1,2,3'],
            'class_teacher_id' => ['nullable', 'exists:teachers,id'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string'],
        ]);

        // Calculate current_enrollment dynamically from actual student enrollments
        $validated['current_enrollment'] = $class->students()->count();

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class updated successfully!');
    }

    public function destroy(SchoolClass $class)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can delete classes.');
        }

        // Check if class has students
        if ($class->students()->count() > 0) {
            return redirect()->route('admin.classes.index')
                ->with('error', 'Cannot delete class with enrolled students. Please remove students first.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class deleted successfully!');
    }
}

