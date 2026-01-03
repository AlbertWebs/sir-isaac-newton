<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SchoolInformation;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Get school information
     */
    public function index()
    {
        $info = SchoolInformation::where('status', 'active')->first();

        if (!$info) {
            // Create default if doesn't exist
            $info = SchoolInformation::create([
                'name' => 'Sir Isaac Newton School',
                'motto' => 'Creating World Changers.',
                'status' => 'active',
            ]);
        }

        return response()->json($info);
    }

    /**
     * Update school information
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'motto' => 'sometimes|string|max:255',
            'vision' => 'sometimes|string',
            'mission' => 'sometimes|string',
            'about' => 'sometimes|string',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string',
            'phone_secondary' => 'sometimes|string',
            'address' => 'sometimes|string',
            'website' => 'sometimes|url',
            'logo' => 'sometimes|string',
            'facilities' => 'sometimes|array',
            'programs' => 'sometimes|array',
            'social_media' => 'sometimes|array',
        ]);

        $info = SchoolInformation::where('status', 'active')->first();

        if (!$info) {
            $info = SchoolInformation::create(array_merge($request->all(), [
                'name' => $request->input('name', 'Sir Isaac Newton School'), // Provide a default name
                'status' => 'active', // Ensure status is set
            ]));
        } else {
            $info->update($request->all());
        }

        return response()->json($info);
    }
}

