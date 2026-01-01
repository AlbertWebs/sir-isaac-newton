<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\SchoolInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EnrollmentController extends Controller
{
    public function edit()
    {
        $schoolInformation = SchoolInformation::firstOrCreate([]);
        return view('admin.website.enrollment.edit', compact('schoolInformation'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'enroll_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'enroll_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $schoolInformation = SchoolInformation::firstOrCreate([]);

        if ($request->hasFile('enroll_image_1')) {
            if ($schoolInformation->enroll_image_1) {
                Storage::delete($schoolInformation->enroll_image_1);
            }
            $schoolInformation->enroll_image_1 = $request->file('enroll_image_1')->store('website/enrollment', 'public');
        }

        if ($request->hasFile('enroll_image_2')) {
            if ($schoolInformation->enroll_image_2) {
                Storage::delete($schoolInformation->enroll_image_2);
            }
            $schoolInformation->enroll_image_2 = $request->file('enroll_image_2')->store('website/enrollment', 'public');
        }

        $schoolInformation->save();

        return redirect()->route('admin.website.enrollment.edit')->with('success', 'Enrollment page images updated successfully.');
    }
}
