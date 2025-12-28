<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $query = GalleryImage::query();

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('caption', 'like', "%{$searchTerm}%")
                  ->orWhere('activity_event', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by activity/event
        if ($request->filled('activity_event')) {
            $query->where('activity_event', $request->get('activity_event'));
        }

        // Filter by visibility
        if ($request->filled('is_visible')) {
            $query->where('is_visible', $request->get('is_visible') === '1');
        }

        $images = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(24)->withQueryString();
        $searchTerm = $request->get('search', '');
        $activityFilter = $request->get('activity_event', '');
        $visibilityFilter = $request->get('is_visible', '');

        // Get unique activity/event names for filter dropdown
        $activityEvents = GalleryImage::whereNotNull('activity_event')
            ->distinct()
            ->pluck('activity_event')
            ->sort()
            ->values();

        return view('admin.website.gallery.index', compact('images', 'searchTerm', 'activityFilter', 'visibilityFilter', 'activityEvents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'image' => ['required', 'image', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:500'],
            'activity_event' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('website/gallery', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');
        $validated['order'] = $validated['order'] ?? GalleryImage::max('order') + 1 ?? 0;

        GalleryImage::create($validated);

        return redirect()->route('admin.website.gallery.index')
            ->with('success', 'Gallery image uploaded successfully!');
    }

    /**
     * Store multiple images (for dropzone)
     */
    public function storeMultiple(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'max:5120'],
            'activity_event' => ['nullable', 'string', 'max:255'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $uploaded = [];
        $maxOrder = GalleryImage::max('order') ?? 0;
        $isVisible = $request->has('is_visible');

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('website/gallery', 'public');
            $galleryImage = GalleryImage::create([
                'image' => $path,
                'caption' => null, // Can be added later via edit
                'activity_event' => $validated['activity_event'] ?? null,
                'order' => $maxOrder + $index + 1,
                'is_visible' => $isVisible,
            ]);
            $uploaded[] = $galleryImage;
        }

        $count = count($uploaded);
        return redirect()->route('admin.website.gallery.index')
            ->with('success', $count . ' image(s) uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryImage $galleryImage)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.gallery.show', compact('galleryImage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryImage $galleryImage)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.gallery.edit', compact('galleryImage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryImage $galleryImage)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:500'],
            'activity_event' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($galleryImage->image) {
                Storage::disk('public')->delete($galleryImage->image);
            }
            $validated['image'] = $request->file('image')->store('website/gallery', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');

        $galleryImage->update($validated);

        return redirect()->route('admin.website.gallery.index')
            ->with('success', 'Gallery image updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryImage $galleryImage)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($galleryImage->image) {
            Storage::disk('public')->delete($galleryImage->image);
        }

        $galleryImage->delete();

        return redirect()->route('admin.website.gallery.index')
            ->with('success', 'Gallery image deleted successfully!');
    }

    /**
     * Toggle visibility
     */
    public function toggleVisibility(GalleryImage $galleryImage)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $galleryImage->update(['is_visible' => !$galleryImage->is_visible]);

        return redirect()->back()
            ->with('success', 'Visibility updated successfully!');
    }
}
