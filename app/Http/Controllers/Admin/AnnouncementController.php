<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('announcements.view')) {
            abort(403, 'Unauthorized access');
        }

        $query = Announcement::with('postedBy');

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('message', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by target audience
        if ($request->filled('target_audience')) {
            $query->where('target_audience', $request->get('target_audience'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        $announcements = $query->latest('published_at')->latest()->paginate(20)->withQueryString();
        $searchTerm = $request->get('search', '');
        $audienceFilter = $request->get('target_audience', '');
        $statusFilter = $request->get('status', '');
        $priorityFilter = $request->get('priority', '');

        return view('admin.announcements.index', compact('announcements', 'searchTerm', 'audienceFilter', 'statusFilter', 'priorityFilter'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('announcements.create')) {
            abort(403, 'Unauthorized access');
        }

        $classes = SchoolClass::where('status', 'active')->orderBy('level')->orderBy('name')->get();
        $targetAudiences = ['all', 'students', 'parents', 'teachers', 'admin'];
        $priorities = ['low', 'medium', 'high'];

        return view('admin.announcements.create', compact('classes', 'targetAudiences', 'priorities'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('announcements.create')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'target_audience' => ['required', 'in:all,students,parents,teachers,admin'],
            'target_classes' => ['nullable', 'array'],
            'target_classes.*' => ['exists:classes,id'],
            'target_students' => ['nullable', 'array'],
            'target_students.*' => ['exists:students,id'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:draft,active,archived'],
            'published_at' => ['nullable', 'date'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,jpg,jpeg,png'],
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('announcements', 'public');
            $validated['attachment_path'] = $path;
            $validated['attachment_name'] = $file->getClientOriginalName();
            $validated['attachment_type'] = $file->getClientMimeType();
        }

        // Set posted_by
        $validated['posted_by'] = auth()->id();

        // Set published_at if not provided and status is active
        if (empty($validated['published_at']) && $validated['status'] === 'active') {
            $validated['published_at'] = now();
        }

        // Convert arrays to JSON
        if (isset($validated['target_classes'])) {
            $validated['target_classes'] = json_encode($validated['target_classes']);
        }
        if (isset($validated['target_students'])) {
            $validated['target_students'] = json_encode($validated['target_students']);
        }

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully!');
    }

    public function show(Announcement $announcement)
    {
        if (!auth()->user()->hasPermission('announcements.view')) {
            abort(403, 'Unauthorized access');
        }

        $announcement->load('postedBy');
        
        // Load targeted classes if any
        $targetClassIds = $announcement->target_classes ? json_decode($announcement->target_classes, true) : [];
        $targetClasses = !empty($targetClassIds) ? SchoolClass::whereIn('id', $targetClassIds)->get() : collect();

        return view('admin.announcements.show', compact('announcement', 'targetClasses'));
    }

    public function edit(Announcement $announcement)
    {
        if (!auth()->user()->hasPermission('announcements.edit')) {
            abort(403, 'Unauthorized access');
        }

        $classes = SchoolClass::where('status', 'active')->orderBy('level')->orderBy('name')->get();
        $targetAudiences = ['all', 'students', 'parents', 'teachers', 'admin'];
        $priorities = ['low', 'medium', 'high'];

        // Decode JSON fields
        $targetClassIds = $announcement->target_classes ? json_decode($announcement->target_classes, true) : [];
        $targetStudentIds = $announcement->target_students ? json_decode($announcement->target_students, true) : [];

        return view('admin.announcements.edit', compact('announcement', 'classes', 'targetAudiences', 'priorities', 'targetClassIds', 'targetStudentIds'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        if (!auth()->user()->hasPermission('announcements.edit')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'target_audience' => ['required', 'in:all,students,parents,teachers,admin'],
            'target_classes' => ['nullable', 'array'],
            'target_classes.*' => ['exists:classes,id'],
            'target_students' => ['nullable', 'array'],
            'target_students.*' => ['exists:students,id'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:draft,active,archived'],
            'published_at' => ['nullable', 'date'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,jpg,jpeg,png'],
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($announcement->attachment_path) {
                Storage::disk('public')->delete($announcement->attachment_path);
            }

            $file = $request->file('attachment');
            $path = $file->store('announcements', 'public');
            $validated['attachment_path'] = $path;
            $validated['attachment_name'] = $file->getClientOriginalName();
            $validated['attachment_type'] = $file->getClientMimeType();
        }

        // Set published_at if not provided and status is active
        if (empty($validated['published_at']) && $validated['status'] === 'active' && !$announcement->published_at) {
            $validated['published_at'] = now();
        }

        // Convert arrays to JSON
        if (isset($validated['target_classes'])) {
            $validated['target_classes'] = json_encode($validated['target_classes']);
        } else {
            $validated['target_classes'] = null;
        }
        if (isset($validated['target_students'])) {
            $validated['target_students'] = json_encode($validated['target_students']);
        } else {
            $validated['target_students'] = null;
        }

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        if (!auth()->user()->hasPermission('announcements.delete')) {
            abort(403, 'Unauthorized access');
        }

        // Delete attachment if exists
        if ($announcement->attachment_path) {
            Storage::disk('public')->delete($announcement->attachment_path);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}

