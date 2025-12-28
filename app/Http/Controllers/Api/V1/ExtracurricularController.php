<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\ClubSchedule;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    /**
     * Get all clubs
     */
    public function clubs(Request $request)
    {
        $query = Club::with('coordinator');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        return response()->json($query->get());
    }

    /**
     * Get club details
     */
    public function showClub($id)
    {
        $club = Club::with(['coordinator', 'students', 'schedules'])
            ->findOrFail($id);

        return response()->json($club);
    }

    /**
     * Create club
     */
    public function createClub(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:clubs,code',
            'type' => 'required|in:sports,academic,arts,cultural,other',
            'teacher_id' => 'nullable|exists:teachers,id',
            'max_members' => 'nullable|integer|min:1',
        ]);

        $club = Club::create($request->all());

        return response()->json($club, 201);
    }

    /**
     * Get club members
     */
    public function clubMembers($id, Request $request)
    {
        $club = Club::findOrFail($id);

        $query = $club->students();

        if ($request->has('academic_year')) {
            $query->wherePivot('academic_year', $request->academic_year);
        }

        if ($request->has('status')) {
            $query->wherePivot('status', $request->status);
        }

        return response()->json($query->get());
    }

    /**
     * Add member to club
     */
    public function addMember(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year' => 'required|string',
            'role' => 'nullable|in:member,leader,assistant_leader',
        ]);

        $club = Club::findOrFail($id);

        $club->students()->attach($request->student_id, [
            'academic_year' => $request->academic_year,
            'role' => $request->get('role', 'member'),
            'status' => 'active',
        ]);

        return response()->json(['message' => 'Member added successfully'], 201);
    }
}

