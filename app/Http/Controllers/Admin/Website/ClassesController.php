<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display classes for website management
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $classes = SchoolClass::whereIn('level', [
            'pp1', 'pp2', 'grade_1', 'grade_2', 'grade_3', 'grade_4', 'grade_5', 'grade_6'
        ])->orderByRaw("
            CASE level
                WHEN 'pp1' THEN 1
                WHEN 'pp2' THEN 2
                WHEN 'grade_1' THEN 3
                WHEN 'grade_2' THEN 4
                WHEN 'grade_3' THEN 5
                WHEN 'grade_4' THEN 6
                WHEN 'grade_5' THEN 7
                WHEN 'grade_6' THEN 8
            END
        ")->orderBy('name')->get();

        return view('admin.website.classes.index', compact('classes'));
    }

    /**
     * Show the form for editing class website settings
     */
    public function edit(SchoolClass $class)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.classes.edit', compact('class'));
    }

    /**
     * Update class visibility and description for website
     */
    public function update(Request $request, SchoolClass $class)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'website_description' => ['nullable', 'string', 'max:1000'],
            'website_visible' => ['nullable', 'boolean'],
        ]);

        $validated['website_visible'] = $request->has('website_visible');

        $class->update($validated);

        return redirect()->route('admin.website.classes.index')
            ->with('success', 'Class updated successfully!');
    }
}
