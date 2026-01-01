<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\WebsiteController as ApiWebsiteController;
use App\Models\EnrollmentSubmission;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    protected $apiController;

    public function __construct()
    {
        $this->apiController = new ApiWebsiteController();
    }

    /**
     * Display homepage
     */
    public function homepage()
    {
        $data = $this->apiController->homepage();
        $homepageData = json_decode($data->getContent(), true);
        
        return view('website.homepage', $homepageData);
    }

    /**
     * Display about page
     */
    public function about()
    {
        $data = $this->apiController->about();
        $aboutData = json_decode($data->getContent(), true);
        
        // Get breadcrumb data
        $breadcrumbData = $this->apiController->breadcrumb('about');
        $breadcrumb = json_decode($breadcrumbData->getContent(), true);
        
        return view('website.about', array_merge($aboutData, ['breadcrumb' => $breadcrumb]));
    }

    /**
     * Display clubs page
     */
    public function clubs()
    {
        $data = $this->apiController->clubs();
        $clubsData = json_decode($data->getContent(), true);

        // Get breadcrumb data
        $breadcrumbData = $this->apiController->breadcrumb('clubs');
        $breadcrumb = json_decode($breadcrumbData->getContent(), true);

        return view('website.clubs', array_merge($clubsData, ['breadcrumb' => $breadcrumb]));
    }


    /**
     * Display classes page
     */
    public function classes()
    {
        $data = $this->apiController->classes();
        $classesData = json_decode($data->getContent(), true);
        
        // Get breadcrumb data
        $breadcrumbData = $this->apiController->breadcrumb('classes');
        $breadcrumb = json_decode($breadcrumbData->getContent(), true);
        
        return view('website.classes', array_merge($classesData, ['breadcrumb' => $breadcrumb]));
    }

    /**
     * Display gallery page
     */
    public function gallery()
    {
        $data = $this->apiController->gallery(request());
        $galleryData = json_decode($data->getContent(), true);
        
        // Get breadcrumb data
        $breadcrumbData = $this->apiController->breadcrumb('gallery');
        $breadcrumb = json_decode($breadcrumbData->getContent(), true);
        
        return view('website.gallery', array_merge($galleryData, ['breadcrumb' => $breadcrumb]));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        $data = $this->apiController->contact();
        $contactData = json_decode($data->getContent(), true);
        
        // Get breadcrumb data
        $breadcrumbData = $this->apiController->breadcrumb('contact');
        $breadcrumb = json_decode($breadcrumbData->getContent(), true);
        
        return view('website.contact', array_merge($contactData, [
            'breadcrumb' => $breadcrumb,
            'phone' => $contactData['phone'] ?? null, // Ensure phone is passed
            'email' => $contactData['email'] ?? null, // Ensure email is passed
        ]));
    }

    /**
     * Display enrollment/registration page
     */
    public function enroll()
    {
        // Get classes for enrollment form
        $classesData = $this->apiController->classes();
        $classes = json_decode($classesData->getContent(), true);

        // Get enrollment page images
        $enrollInfoData = $this->apiController->enrollInfo();
        $enrollInfo = json_decode($enrollInfoData->getContent(), true);
        
        // Get breadcrumb data
        $breadcrumbData = $this->apiController->breadcrumb('enroll');
        $breadcrumb = json_decode($breadcrumbData->getContent(), true);
        
        return view('website.enroll', [
            'classes' => $classes['classes'] ?? [],
            'enroll_image_1' => $enrollInfo['enroll_image_1'] ?? null,
            'enroll_image_2' => $enrollInfo['enroll_image_2'] ?? null,
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Handle enrollment form submission
     */
    public function enrollSubmit(Request $request)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'child_dob' => 'required|date',
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'class_id' => 'nullable|exists:classes,id',
            'additional_info' => 'nullable|string',
            'notify_progress' => 'boolean',
        ]);

        EnrollmentSubmission::create($validated);

        return redirect()->route('website.enroll')
            ->with('success', 'Thank you for your enrollment request. We will contact you soon!');
    }
}


