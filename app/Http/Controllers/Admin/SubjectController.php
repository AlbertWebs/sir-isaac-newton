<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can manage subjects.');
        }

        $query = Subject::query();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        $subjects = $query->latest()->paginate(20)->withQueryString();
        $searchTerm = $request->get('search', '');
        $statusFilter = $request->get('status', '');
        $typeFilter = $request->get('type', '');

        return view('admin.subjects.index', compact('subjects', 'searchTerm', 'statusFilter', 'typeFilter'));
    }

    public function create()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can create subjects.');
        }

        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can create subjects.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code'],
            'type' => ['required', 'in:core,language,special_program,extracurricular'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Subject::create($validated);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully!');
    }

    public function show(Subject $subject)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can view subject details.');
        }

        $subject->load('classes');
        return view('admin.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can edit subjects.');
        }

        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can update subjects.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code,' . $subject->id],
            'type' => ['required', 'in:core,language,special_program,extracurricular'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $subject->update($validated);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully!');
    }

    public function destroy(Subject $subject)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only Super Administrators can delete subjects.');
        }

        // Check if subject is assigned to any classes
        if ($subject->classes()->count() > 0) {
            return redirect()->route('admin.subjects.index')
                ->with('error', 'Cannot delete subject that is assigned to classes. Please remove assignments first.');
        }

        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully!');
    }
}

