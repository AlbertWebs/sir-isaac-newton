<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\AboutPageContent;
use App\Models\TeamMember;
use App\Models\HistoryTimeline;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display about page management dashboard
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $aboutContent = AboutPageContent::where('section_type', 'about_school')->first();
        $teamMembers = TeamMember::orderBy('order')->get();
        $timeline = HistoryTimeline::orderBy('order')->get();
        $clubs = AboutPageContent::where('section_type', 'clubs')->orderBy('order')->get();

        return view('admin.website.about.index', compact('aboutContent', 'teamMembers', 'timeline', 'clubs'));
    }

    // ==================== ABOUT SCHOOL ====================

    public function aboutSchoolEdit()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $aboutContent = AboutPageContent::where('section_type', 'about_school')->first();
        return view('admin.website.about.about-school.edit', compact('aboutContent'));
    }

    public function aboutSchoolUpdate(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:5120'],
            'title' => ['nullable', 'string', 'max:255'],
            'paragraph' => ['nullable', 'string'],
        ]);

        $aboutContent = AboutPageContent::where('section_type', 'about_school')->first();

        if ($request->hasFile('image')) {
            if ($aboutContent && $aboutContent->image) {
                Storage::disk('public')->delete($aboutContent->image);
            }
            $validated['image'] = $request->file('image')->store('website/about', 'public');
        }

        if ($aboutContent) {
            $aboutContent->update($validated);
        } else {
            $validated['section_type'] = 'about_school';
            AboutPageContent::create($validated);
        }

        return redirect()->route('admin.website.about.index')
            ->with('success', 'About school content updated successfully!');
    }

    // ==================== TEAM MEMBERS ====================

    public function teamIndex()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $teamMembers = TeamMember::orderBy('order')->get();
        return view('admin.website.about.team.index', compact('teamMembers'));
    }

    public function teamCreate()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.about.team.create');
    }

    public function teamStore(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'image' => ['required', 'image', 'max:5120'],
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('website/team', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');
        $validated['order'] = $validated['order'] ?? TeamMember::max('order') + 1;

        TeamMember::create($validated);

        return redirect()->route('admin.website.about.team.index')
            ->with('success', 'Team member created successfully!');
    }

    public function teamEdit(TeamMember $teamMember)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.about.team.edit', compact('teamMember'));
    }

    public function teamUpdate(Request $request, TeamMember $teamMember)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:5120'],
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($teamMember->image) {
                Storage::disk('public')->delete($teamMember->image);
            }
            $validated['image'] = $request->file('image')->store('website/team', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');

        $teamMember->update($validated);

        return redirect()->route('admin.website.about.team.index')
            ->with('success', 'Team member updated successfully!');
    }

    public function teamDestroy(TeamMember $teamMember)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($teamMember->image) {
            Storage::disk('public')->delete($teamMember->image);
        }

        $teamMember->delete();

        return redirect()->route('admin.website.about.team.index')
            ->with('success', 'Team member deleted successfully!');
    }

    // ==================== HISTORY TIMELINE ====================

    public function timelineIndex()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $timeline = HistoryTimeline::orderBy('order')->get();
        return view('admin.website.about.timeline.index', compact('timeline'));
    }

    public function timelineCreate()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.about.timeline.create');
    }

    public function timelineStore(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'title' => ['required', 'string', 'max:255'],
            'feature_label' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $validated['is_visible'] = $request->has('is_visible');
        $validated['order'] = $validated['order'] ?? HistoryTimeline::max('order') + 1;

        HistoryTimeline::create($validated);

        return redirect()->route('admin.website.about.timeline.index')
            ->with('success', 'Timeline entry created successfully!');
    }

    public function timelineEdit(HistoryTimeline $timeline)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.about.timeline.edit', compact('timeline'));
    }

    public function timelineUpdate(Request $request, HistoryTimeline $timeline)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'title' => ['required', 'string', 'max:255'],
            'feature_label' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $validated['is_visible'] = $request->has('is_visible');

        $timeline->update($validated);

        return redirect()->route('admin.website.about.timeline.index')
            ->with('success', 'Timeline entry updated successfully!');
    }

    public function timelineDestroy(HistoryTimeline $timeline)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $timeline->delete();

        return redirect()->route('admin.website.about.timeline.index')
            ->with('success', 'Timeline entry deleted successfully!');
    }

    // ==================== CLUBS ====================

    public function clubsIndex()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $clubs = AboutPageContent::where('section_type', 'clubs')->orderBy('order')->get();
        return view('admin.website.about.clubs.index', compact('clubs'));
    }

    public function clubsCreate()
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.website.about.clubs.create');
    }

    public function clubsStore(Request $request)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:5120'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('website/clubs', 'public');
        }

        $validated['section_type'] = 'clubs';
        $validated['is_visible'] = $request->has('is_visible');
        $validated['order'] = $validated['order'] ?? AboutPageContent::where('section_type', 'clubs')->max('order') + 1 ?? 0;

        AboutPageContent::create($validated);

        return redirect()->route('admin.website.about.clubs.index')
            ->with('success', 'Club created successfully!');
    }

    public function clubsEdit(AboutPageContent $club)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($club->section_type !== 'clubs') {
            abort(404);
        }

        return view('admin.website.about.clubs.edit', compact('club'));
    }

    public function clubsUpdate(Request $request, AboutPageContent $club)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($club->section_type !== 'clubs') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($club->image) {
                Storage::disk('public')->delete($club->image);
            }
            $validated['image'] = $request->file('image')->store('website/clubs', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');

        $club->update($validated);

        return redirect()->route('admin.website.about.clubs.index')
            ->with('success', 'Club updated successfully!');
    }

    public function clubsDestroy(AboutPageContent $club)
    {
        if (!auth()->user()->hasPermission('website.manage')) {
            abort(403, 'Unauthorized access');
        }

        if ($club->section_type !== 'clubs') {
            abort(404);
        }

        if ($club->image) {
            Storage::disk('public')->delete($club->image);
        }

        $club->delete();

        return redirect()->route('admin.website.about.clubs.index')
            ->with('success', 'Club deleted successfully!');
    }
}
