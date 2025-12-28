<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('clubs.view')) {
            abort(403, 'Unauthorized access');
        }

        $query = Club::with('coordinator');

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('code', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $clubs = $query->latest()->paginate(20)->withQueryString();
        $searchTerm = $request->get('search', '');
        $typeFilter = $request->get('type', '');
        $statusFilter = $request->get('status', '');

        return view('admin.clubs.index', compact('clubs', 'searchTerm', 'typeFilter', 'statusFilter'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('clubs.create')) {
            abort(403, 'Unauthorized access');
        }

        $teachers = Teacher::where('status', 'active')->orderBy('first_name')->get();
        $clubTypes = ['sports', 'academic', 'arts', 'cultural', 'other'];

        return view('admin.clubs.create', compact('teachers', 'clubTypes'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('clubs.create')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:clubs,code'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:sports,academic,arts,cultural,other'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'max_members' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:active,inactive,suspended'],
        ]);

        Club::create($validated);

        return redirect()->route('admin.clubs.index')
            ->with('success', 'Club created successfully!');
    }

    public function show(Club $club)
    {
        if (!auth()->user()->hasPermission('clubs.view')) {
            abort(403, 'Unauthorized access');
        }

        $club->load(['coordinator', 'students', 'schedules']);
        $currentMembers = $club->students()->wherePivot('status', 'active')->count();

        return view('admin.clubs.show', compact('club', 'currentMembers'));
    }

    public function edit(Club $club)
    {
        if (!auth()->user()->hasPermission('clubs.edit')) {
            abort(403, 'Unauthorized access');
        }

        $teachers = Teacher::where('status', 'active')->orderBy('first_name')->get();
        $clubTypes = ['sports', 'academic', 'arts', 'cultural', 'other'];

        return view('admin.clubs.edit', compact('club', 'teachers', 'clubTypes'));
    }

    public function update(Request $request, Club $club)
    {
        if (!auth()->user()->hasPermission('clubs.edit')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:clubs,code,' . $club->id],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:sports,academic,arts,cultural,other'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'max_members' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:active,inactive,suspended'],
        ]);

        $club->update($validated);

        return redirect()->route('admin.clubs.index')
            ->with('success', 'Club updated successfully!');
    }

    public function destroy(Club $club)
    {
        if (!auth()->user()->hasPermission('clubs.delete')) {
            abort(403, 'Unauthorized access');
        }

        $club->delete();

        return redirect()->route('admin.clubs.index')
            ->with('success', 'Club deleted successfully!');
    }
}

