<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SchoolInformation;
use App\Models\Announcement;
use App\Models\HomepageSlider;
use App\Models\HomepageSection;
use App\Models\HomepageFeature;
use App\Models\HomepageFaq;
use App\Models\SessionTime;
use App\Models\Breadcrumb;
use App\Models\AboutPageContent;
use App\Models\TeamMember;
use App\Models\HistoryTimeline;
use App\Models\GalleryImage;
use App\Models\ContactInformation;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    /**
     * Get public school information
     */
    public function schoolInfo()
    {
        $info = SchoolInformation::where('status', 'active')->first();

        if (!$info) {
            return response()->json([
                'name' => 'Sir Isaac Newton School',
                'motto' => 'Creating World Changers.',
                'vision' => null,
                'mission' => null,
                'about' => null,
                'email' => null,
                'phone' => null,
                'address' => null,
                'website' => null,
                'logo' => null,
                'facilities' => [],
                'programs' => [],
                'social_media' => [],
            ]);
        }

        $infoArray = $info->toArray();
        $infoArray['logo'] = $info->logo ? asset('storage/' . $info->logo) : null;
        return response()->json($infoArray);
    }

    /**
     * Get enrollment page information
     */
    public function enrollInfo()
    {
        $info = SchoolInformation::firstOrCreate([]);
        return response()->json([
            'enroll_image_1' => $info->enroll_image_1 ? asset('storage/' . $info->enroll_image_1) : null,
            'enroll_image_2' => $info->enroll_image_2 ? asset('storage/' . $info->enroll_image_2) : null,
        ]);
    }

    /**
     * Get homepage data
    */
    public function homepage()
    {
        return response()->json([
            'sliders' => HomepageSlider::where('is_visible', true)
                ->orderBy('order')
                ->get()
                ->map(function($slider) {
                    return [
                        'id' => $slider->id,
                        'image' => $slider->image ? asset('storage/' . $slider->image) : null,
                        'text' => $slider->text,
                        'button_text' => $slider->button_text,
                        'button_link' => $slider->button_link,
                    ];
                }),
            'about_section' => (
                function () {
                    $section = HomepageSection::where('section_type', 'about')
                        ->where('is_visible', true)
                        ->first();

                    if ($section) {
                        $images = is_array($section->images) ? $section->images : [];
                        return [
                            'id' => $section->id,
                            'title' => $section->title,
                            'heading' => $section->heading,
                            'paragraph' => $section->paragraph,
                            'button_text' => $section->button_text,
                            'button_link' => $section->button_link,
                            'image_1' => isset($images['image_1']) ? asset('storage/' . $images['image_1']) : null,
                            'image_2' => isset($images['image_2']) ? asset('storage/' . $images['image_2']) : null,
                            'image_3' => isset($images['image_3']) ? asset('storage/' . $images['image_3']) : null,
                            'image_4' => isset($images['image_4']) ? asset('storage/' . $images['image_4']) : null,
                        ];
                    }
                    return null;
                }
            )(),
            'features' => HomepageFeature::where('is_visible', true)
                ->orderBy('order')
                ->get()
                ->map(function($feature) {
                    return [
                        'id' => $feature->id,
                        'section_title' => $feature->section_title,
                        'section_heading' => $feature->section_heading,
                        'content' => $feature->content,
                        'image' => $feature->image ? asset('storage/' . $feature->image) : null,
                        'icon' => $feature->icon,
                        'title' => $feature->title,
                        'paragraph' => $feature->paragraph,
                    ];
                }),
            'programs_section' => HomepageSection::where('section_type', 'programs')
                ->where('is_visible', true)
                ->first(),
            'session_times' => [
                'section' => SessionTime::where('is_visible', true)
                    ->whereNotNull('title')
                    ->first(),
                'schedule' => SessionTime::where('is_visible', true)
                    ->whereNull('title')
                    ->orderBy('order')
                    ->get()
                    ->map(function($time) {
                        return [
                            'label' => $time->label,
                            'time_range' => $time->time_range,
                        ];
                    }),
            ],
            'day_care_section' => HomepageSection::where('section_type', 'day_care')
                ->where('is_visible', true)
                ->first(),
            'faqs' => [
                'title' => HomepageFaq::whereNotNull('title')->first()?->title,
                'heading' => HomepageFaq::whereNotNull('heading')->first()?->heading,
                'items' => HomepageFaq::where('is_visible', true)
                    ->whereNotNull('question')
                    ->orderBy('order')
                    ->get()
                    ->map(function($faq) {
                        return [
                            'question' => $faq->question,
                            'answer' => $faq->answer,
                        ];
                    }),
            ],
        ]);
    }

    /**
     * Get about page data
     */
    public function about()
    {
        return response()->json([
            'about_school' => AboutPageContent::where('section_type', 'about_school')
                ->where('is_visible', true)
                ->first(),
            'team' => TeamMember::where('is_visible', true)
                ->orderBy('order')
                ->get()
                ->map(function($member) {
                    return [
                        'id' => $member->id,
                        'image' => $member->image ? asset('storage/' . $member->image) : null,
                        'name' => $member->name,
                        'position' => $member->position,
                        'bio' => $member->bio,
                    ];
                }),
            'timeline' => HistoryTimeline::where('is_visible', true)
                ->orderBy('order')
                ->get()
                ->map(function($item) {
                    return [
                        'year' => $item->year,
                        'title' => $item->title,
                        'feature_label' => $item->feature_label,
                        'description' => $item->description,
                        'image' => $item->image ? asset('storage/' . $item->image) : null,
                    ];
                }),
            'stats' => [
                'total_classrooms' => SchoolClass::count(),
                'total_kids_classes' => SchoolClass::whereIn('level', ['pp1', 'pp2', 'grade_1', 'grade_2', 'grade_3', 'grade_4', 'grade_5', 'grade_6'])->count(),
                'total_outdoor_activities' => 75, // Placeholder
                'total_teachers' => Teacher::count(),
            ],
        ]);
    }

    /**
     * Get classes page data
     */
    public function classes()
    {
        $classes = SchoolClass::whereIn('level', [
            'pp1', 'pp2', 'grade_1', 'grade_2', 'grade_3', 'grade_4', 'grade_5', 'grade_6'
        ])
        ->where('website_visible', true)
        ->where('status', 'active')
        ->orderByRaw("
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
        ")
        ->orderBy('name')
        ->get()
        ->map(function($class) {
            return [
                'id' => $class->id,
                'name' => $class->name,
                'code' => $class->code,
                'level' => $class->level,
                'academic_year' => $class->academic_year,
                'age_range' => $class->age_range,
                'description' => $class->website_description ?? $class->description,
                'capacity' => $class->capacity,
                'current_enrollment' => $class->students()->count(),
                'price' => $class->price,
                'image' => $class->image ? asset('storage/' . $class->image) : null,
            ];
        });

        return response()->json([
            'classes' => $classes,
        ]);
    }

    /**
     * Get gallery data
     */
    public function gallery(Request $request)
    {
        $query = GalleryImage::where('is_visible', true);

        if ($request->filled('activity_event')) {
            $query->where('activity_event', $request->get('activity_event'));
        }

        $images = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 24));

        return response()->json([
            'images' => $images->map(function($image) {
                return [
                    'id' => $image->id,
                    'image_url' => asset('storage/' . $image->image),
                    'caption' => $image->caption,
                    'activity_event' => $image->activity_event,
                ];
            }),
            'pagination' => [
                'current_page' => $images->currentPage(),
                'last_page' => $images->lastPage(),
                'per_page' => $images->perPage(),
                'total' => $images->total(),
            ],
            'activity_events' => GalleryImage::where('is_visible', true)
                ->whereNotNull('activity_event')
                ->distinct()
                ->pluck('activity_event')
                ->sort()
                ->values(),
        ]);
    }

    /**
     * Get contact page data
     */
    public function contact()
    {
        $contactInfo = ContactInformation::first();
        $schoolInfo = SchoolInformation::where('status', 'active')->first();

        return response()->json([
            'address' => $contactInfo->address ?? $schoolInfo->address ?? null,
            'phone' => $contactInfo->phone ?? $schoolInfo->phone ?? null,
            'email' => $contactInfo->email ?? $schoolInfo->email ?? null,
            'google_map_embed_url' => $contactInfo->google_map_embed_url ?? null,
        ]);
    }

    /**
     * Get breadcrumb data for a page
     */
    public function breadcrumb($pageKey)
    {
        $breadcrumb = Breadcrumb::where('page_key', $pageKey)->first();

        if (!$breadcrumb) {
            return response()->json([
                'page_key' => $pageKey,
                'background_image' => null,
                'title' => ucfirst(str_replace('_', ' ', $pageKey)),
                'paragraph' => null,
            ]);
        }

        return response()->json([
            'page_key' => $breadcrumb->page_key,
            'background_image' => $breadcrumb->background_image ? asset('storage/' . $breadcrumb->background_image) : null,
            'title' => $breadcrumb->title,
            'paragraph' => $breadcrumb->paragraph,
        ]);
    }

    /**
     * Get public programs (legacy endpoint)
     */
    public function programs()
    {
        $info = SchoolInformation::where('status', 'active')->first();

        return response()->json([
            'programs' => $info ? $info->programs : [],
            'levels' => [
                'Early Years' => ['Daycare', 'Playgroup', 'PP1', 'PP2'],
                'Primary' => ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'],
            ],
            'languages' => ['French', 'German'],
            'special_programs' => ['Coding', 'Robotics'],
        ]);
    }

    /**
     * Get public announcements
     */
    public function announcements(Request $request)
    {
        $announcements = Announcement::where('status', 'active')
            ->where(function($query) {
                $query->where('target_audience', 'all')
                    ->orWhere('target_audience', 'website');
            })
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($request->get('limit', 10))
            ->get(['id', 'title', 'message', 'published_at', 'priority']);

        return response()->json([
            'announcements' => $announcements,
        ]);
    }

    /**
     * Get clubs page data
     */
    public function clubs()
    {
        $clubs = \App\Models\Club::where('status', 'active')
            ->orderBy('name')
            ->get()
            ->map(function ($club) {
                return [
                    'id' => $club->id,
                    'name' => $club->name,
                    'code' => $club->code,
                    'description' => $club->description,
                    'image' => $club->image ? asset('storage/' . $club->image) : null,
                ];
            });

        return response()->json([
            'clubs' => $clubs,
        ]);
    }
}