<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\HomepageSlider;
use App\Models\HomepageSection;
use App\Models\HomepageFeature;
use App\Models\HomepageFaq;
use App\Models\SessionTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    /**
     * Display homepage management dashboard
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $sliders = HomepageSlider::orderBy('order')->get();
        $sections = HomepageSection::orderBy('section_type')->get();
        $features = HomepageFeature::orderBy('order')->get();
        $faqs = HomepageFaq::orderBy('order')->get();
        $sessionTimes = SessionTime::orderBy('order')->get();

        return view('admin.website.homepage.index', compact('sliders', 'sections', 'features', 'faqs', 'sessionTimes'));
    }

    // ==================== SLIDERS ====================

    public function slidersIndex()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $sliders = HomepageSlider::orderBy('order')->get();
        return view('admin.website.homepage.sliders.index', compact('sliders'));
    }

    public function slidersCreate()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.homepage.sliders.create');
    }

    public function slidersStore(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'image' => ['required', 'image', 'max:5120'],
            'text' => ['nullable', 'string', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('website/sliders', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');
        $validated['order'] = $validated['order'] ?? HomepageSlider::max('order') + 1;

        HomepageSlider::create($validated);

        return redirect()->route('admin.website.homepage.sliders.index')
            ->with('success', 'Slider created successfully!');
    }

    public function slidersEdit(HomepageSlider $slider)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.homepage.sliders.edit', compact('slider'));
    }

    public function slidersUpdate(Request $request, HomepageSlider $slider)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:5120'],
            'text' => ['nullable', 'string', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('website/sliders', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');

        $slider->update($validated);

        return redirect()->route('admin.website.homepage.sliders.index')
            ->with('success', 'Slider updated successfully!');
    }

    public function slidersDestroy(HomepageSlider $slider)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.website.homepage.sliders.index')
            ->with('success', 'Slider deleted successfully!');
    }

    // ==================== SECTIONS ====================

    public function sectionsIndex()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $sections = HomepageSection::orderBy('section_type')->orderBy('id')->get();
        return view('admin.website.homepage.sections.index', compact('sections'));
    }

    public function sectionsCreate()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $sectionTypes = ['about', 'programs', 'day_care'];
        return view('admin.website.homepage.sections.create', compact('sectionTypes'));
    }

    public function sectionsStore(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'section_type' => ['required', 'in:about,programs,day_care'],
            'title' => ['nullable', 'string', 'max:255'],
            'heading' => ['nullable', 'string', 'max:255'],
            'paragraph' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'background_image' => ['nullable', 'image', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:100'],
            'images' => ['nullable', 'array', 'max:4'],
            'images.*' => ['image', 'max:5120'],
            'content' => ['nullable', 'string'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request->file('background_image')->store('website/sections', 'public');
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('website/sections', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $validated['is_visible'] = $request->has('is_visible');

        HomepageSection::create($validated);

        return redirect()->route('admin.website.homepage.sections.index')
            ->with('success', 'Section created successfully!');
    }

    public function sectionsEdit(HomepageSection $section)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $sectionTypes = ['about', 'programs', 'day_care'];
        return view('admin.website.homepage.sections.edit', compact('section', 'sectionTypes'));
    }

    public function sectionsUpdate(Request $request, HomepageSection $section)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'section_type' => ['required', 'in:about,programs,day_care'],
            'title' => ['nullable', 'string', 'max:255'],
            'heading' => ['nullable', 'string', 'max:255'],
            'paragraph' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'background_image' => ['nullable', 'image', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:100'],
            'images' => ['nullable', 'array', 'max:4'],
            'images.*' => ['image', 'max:5120'],
            'content' => ['nullable', 'string'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('background_image')) {
            if ($section->background_image) {
                Storage::disk('public')->delete($section->background_image);
            }
            $validated['background_image'] = $request->file('background_image')->store('website/sections', 'public');
        }

        if ($request->hasFile('images')) {
            // Delete old images
            if ($section->images) {
                foreach ($section->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            // Store new images
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('website/sections', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $validated['is_visible'] = $request->has('is_visible');

        $section->update($validated);

        return redirect()->route('admin.website.homepage.sections.index')
            ->with('success', 'Section updated successfully!');
    }

    public function sectionsDestroy(HomepageSection $section)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($section->background_image) {
            Storage::disk('public')->delete($section->background_image);
        }

        if ($section->images) {
            foreach ($section->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $section->delete();

        return redirect()->route('admin.website.homepage.sections.index')
            ->with('success', 'Section deleted successfully!');
    }

    // ==================== FEATURES ====================

    public function featuresIndex()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $features = HomepageFeature::orderBy('order')->get();
        return view('admin.website.homepage.features.index', compact('features'));
    }

    public function featuresCreate()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.homepage.features.create');
    }

    public function featuresStore(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'section_title' => ['nullable', 'string', 'max:255'],
            'section_heading' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'paragraph' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('website/features', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');
        $validated['order'] = $validated['order'] ?? HomepageFeature::max('order') + 1;

        HomepageFeature::create($validated);

        return redirect()->route('admin.website.homepage.features.index')
            ->with('success', 'Feature created successfully!');
    }

    public function featuresEdit(HomepageFeature $feature)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.homepage.features.edit', compact('feature'));
    }

    public function featuresUpdate(Request $request, HomepageFeature $feature)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'section_title' => ['nullable', 'string', 'max:255'],
            'section_heading' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'paragraph' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($feature->image) {
                Storage::disk('public')->delete($feature->image);
            }
            $validated['image'] = $request->file('image')->store('website/features', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');

        $feature->update($validated);

        return redirect()->route('admin.website.homepage.features.index')
            ->with('success', 'Feature updated successfully!');
    }

    public function featuresDestroy(HomepageFeature $feature)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($feature->image) {
            Storage::disk('public')->delete($feature->image);
        }

        $feature->delete();

        return redirect()->route('admin.website.homepage.features.index')
            ->with('success', 'Feature deleted successfully!');
    }

    // ==================== FAQs ====================

    public function faqsIndex()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $faqs = HomepageFaq::orderBy('order')->get();
        return view('admin.website.homepage.faqs.index', compact('faqs'));
    }

    public function faqsCreate()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.homepage.faqs.create');
    }

    public function faqsStore(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'heading' => ['nullable', 'string', 'max:255'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $validated['is_visible'] = $request->has('is_visible');
        $validated['order'] = $validated['order'] ?? HomepageFaq::max('order') + 1;

        HomepageFaq::create($validated);

        return redirect()->route('admin.website.homepage.faqs.index')
            ->with('success', 'FAQ created successfully!');
    }

    public function faqsEdit(HomepageFaq $faq)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.homepage.faqs.edit', compact('faq'));
    }

    public function faqsUpdate(Request $request, HomepageFaq $faq)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'heading' => ['nullable', 'string', 'max:255'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $validated['is_visible'] = $request->has('is_visible');

        $faq->update($validated);

        return redirect()->route('admin.website.homepage.faqs.index')
            ->with('success', 'FAQ updated successfully!');
    }

    public function faqsDestroy(HomepageFaq $faq)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $faq->delete();

        return redirect()->route('admin.website.homepage.faqs.index')
            ->with('success', 'FAQ deleted successfully!');
    }

    // ==================== SESSION TIMES ====================

    public function sessionTimesIndex()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $sessionTimes = SessionTime::orderBy('order')->get();
        return view('admin.website.homepage.session-times.index', compact('sessionTimes'));
    }

    public function sessionTimesCreate()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.homepage.session-times.create');
    }

    public function sessionTimesStore(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'background_image' => ['nullable', 'image', 'max:5120'],
            'title' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'paragraph' => ['nullable', 'string'],
            'label' => ['required', 'string', 'max:255'],
            'time_range' => ['required', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request->file('background_image')->store('website/session-times', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');
        $validated['order'] = $validated['order'] ?? SessionTime::max('order') + 1;

        SessionTime::create($validated);

        return redirect()->route('admin.website.homepage.session-times.index')
            ->with('success', 'Session time created successfully!');
    }

    public function sessionTimesEdit(SessionTime $sessionTime)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.homepage.session-times.edit', compact('sessionTime'));
    }

    public function sessionTimesUpdate(Request $request, SessionTime $sessionTime)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'background_image' => ['nullable', 'image', 'max:5120'],
            'title' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'paragraph' => ['nullable', 'string'],
            'label' => ['required', 'string', 'max:255'],
            'time_range' => ['required', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('background_image')) {
            if ($sessionTime->background_image) {
                Storage::disk('public')->delete($sessionTime->background_image);
            }
            $validated['background_image'] = $request->file('background_image')->store('website/session-times', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');

        $sessionTime->update($validated);

        return redirect()->route('admin.website.homepage.session-times.index')
            ->with('success', 'Session time updated successfully!');
    }

    public function sessionTimesDestroy(SessionTime $sessionTime)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($sessionTime->background_image) {
            Storage::disk('public')->delete($sessionTime->background_image);
        }

        $sessionTime->delete();

        return redirect()->route('admin.website.homepage.session-times.index')
            ->with('success', 'Session time deleted successfully!');
    }
}
