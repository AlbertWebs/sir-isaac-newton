<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\OnlineApplication;
use Illuminate\Http\Request;

class EnrollmentSubmitController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'child_name' => 'required|string|max:255',
            'child_dob' => 'required|date',
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'class_id' => 'nullable|exists:classes,id',
            'additional_info' => 'nullable|string',
            'notify_progress' => 'boolean',
        ]);

        OnlineApplication::create([
            'child_name' => $validatedData['child_name'],
            'child_dob' => $validatedData['child_dob'],
            'parent_name' => $validatedData['parent_name'],
            'parent_email' => $validatedData['parent_email'],
            'phone' => $validatedData['phone'],
            'school_class_id' => $validatedData['class_id'] ?? null,
            'additional_info' => $validatedData['additional_info'] ?? null,
            'notify_progress' => $request->has('notify_progress'),
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Your application has been submitted successfully!'], 200);
    }
}
