<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\ContactInformation;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact information management
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $contactInfo = ContactInformation::first();
        $submissions = ContactSubmission::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.website.contact.index', compact('contactInfo', 'submissions'));
    }

    /**
     * Show the form for editing contact information
     */
    public function edit()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $contactInfo = ContactInformation::first();
        return view('admin.website.contact.edit', compact('contactInfo'));
    }

    /**
     * Update contact information
     */
    public function update(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'google_map_embed_url' => ['nullable', 'string'],
        ]);

        $contactInfo = ContactInformation::first();

        if ($contactInfo) {
            $contactInfo->update($validated);
        } else {
            ContactInformation::create($validated);
        }

        return redirect()->route('admin.website.contact.index')
            ->with('success', 'Contact information updated successfully!');
    }

    /**
     * Display contact submissions
     */
    public function submissions()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $submissions = ContactSubmission::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.website.contact.submissions', compact('submissions'));
    }

    /**
     * Show a specific submission
     */
    public function showSubmission(ContactSubmission $submission)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        // Mark as read
        if (!$submission->is_read) {
            $submission->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return view('admin.website.contact.show', compact('submission'));
    }

    /**
     * Delete a submission
     */
    public function destroySubmission(ContactSubmission $submission)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $submission->delete();

        return redirect()->route('admin.website.contact.index')
            ->with('success', 'Submission deleted successfully!');
    }

    /**
     * Public endpoint to submit contact form
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'], // Keep for old forms or if we decide to combine
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactSubmission::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => $validated['first_name'] . ' ' . $validated['last_name'], // Concatenate for the existing 'name' field
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your message. We will get back to you soon!',
        ]);
    }
}
