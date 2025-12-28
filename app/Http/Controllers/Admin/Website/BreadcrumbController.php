<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BreadcrumbController extends Controller
{
    /**
     * Display breadcrumbs management
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $breadcrumbs = Breadcrumb::orderBy('page_key')->get();
        
        // Define available page keys
        $availablePageKeys = [
            'about' => 'About Page',
            'classes' => 'Classes Page',
            'gallery' => 'Gallery Page',
            'contact' => 'Contact Page',
            'faqs' => 'FAQs Page',
        ];

        return view('admin.website.breadcrumbs.index', compact('breadcrumbs', 'availablePageKeys'));
    }

    /**
     * Show the form for creating a new breadcrumb
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $availablePageKeys = [
            'about' => 'About Page',
            'classes' => 'Classes Page',
            'gallery' => 'Gallery Page',
            'contact' => 'Contact Page',
            'faqs' => 'FAQs Page',
        ];

        // Get existing page keys
        $existingKeys = Breadcrumb::pluck('page_key')->toArray();
        $availablePageKeys = array_diff_key($availablePageKeys, array_flip($existingKeys));

        return view('admin.website.breadcrumbs.create', compact('availablePageKeys'));
    }

    /**
     * Store a newly created breadcrumb
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'page_key' => ['required', 'string', 'max:100', 'unique:breadcrumbs,page_key'],
            'background_image' => ['nullable', 'image', 'max:5120'],
            'title' => ['required', 'string', 'max:255'],
            'paragraph' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request->file('background_image')->store('website/breadcrumbs', 'public');
        }

        Breadcrumb::create($validated);

        return redirect()->route('admin.website.breadcrumbs.index')
            ->with('success', 'Breadcrumb created successfully!');
    }

    /**
     * Show the form for editing a breadcrumb
     */
    public function edit(Breadcrumb $breadcrumb)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.breadcrumbs.edit', compact('breadcrumb'));
    }

    /**
     * Update the specified breadcrumb
     */
    public function update(Request $request, Breadcrumb $breadcrumb)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'background_image' => ['nullable', 'image', 'max:5120'],
            'title' => ['required', 'string', 'max:255'],
            'paragraph' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('background_image')) {
            if ($breadcrumb->background_image) {
                Storage::disk('public')->delete($breadcrumb->background_image);
            }
            $validated['background_image'] = $request->file('background_image')->store('website/breadcrumbs', 'public');
        }

        $breadcrumb->update($validated);

        return redirect()->route('admin.website.breadcrumbs.index')
            ->with('success', 'Breadcrumb updated successfully!');
    }

    /**
     * Remove the specified breadcrumb
     */
    public function destroy(Breadcrumb $breadcrumb)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($breadcrumb->background_image) {
            Storage::disk('public')->delete($breadcrumb->background_image);
        }

        $breadcrumb->delete();

        return redirect()->route('admin.website.breadcrumbs.index')
            ->with('success', 'Breadcrumb deleted successfully!');
    }
}

