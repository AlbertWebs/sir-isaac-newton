<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * List announcements
     */
    public function index(Request $request)
    {
        $query = Announcement::with('postedBy');

        // Filter by target audience
        if ($request->has('target_audience')) {
            $query->where('target_audience', $request->target_audience);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'active');
        }

        // Filter by class if provided
        if ($request->has('class_id')) {
            $query->whereJsonContains('target_classes', (string)$request->class_id);
        }

        return response()->json($query->orderBy('published_at', 'desc')->get());
    }

    /**
     * Get announcement details
     */
    public function show($id)
    {
        $announcement = Announcement::with('postedBy')->findOrFail($id);

        return response()->json($announcement);
    }

    /**
     * Create announcement
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_audience' => 'required|in:all,students,parents,teachers',
            'target_classes' => 'nullable|array',
            'target_students' => 'nullable|array',
            'priority' => 'nullable|in:low,medium,high',
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            'target_audience' => $request->target_audience,
            'target_classes' => $request->target_classes,
            'target_students' => $request->target_students,
            'priority' => $request->get('priority', 'medium'),
            'posted_by' => $request->user()->id,
            'published_at' => now(),
            'status' => 'active',
        ]);

        return response()->json($announcement, 201);
    }

    /**
     * Update announcement
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'message' => 'sometimes|string',
            'target_audience' => 'sometimes|in:all,students,parents,teachers',
            'priority' => 'sometimes|in:low,medium,high',
            'status' => 'sometimes|in:draft,active,archived',
        ]);

        $announcement->update($request->all());

        return response()->json($announcement);
    }

    /**
     * Delete announcement
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return response()->json(['message' => 'Announcement deleted successfully']);
    }
}

