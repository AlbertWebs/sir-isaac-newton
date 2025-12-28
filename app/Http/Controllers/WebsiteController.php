<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\WebsiteController as ApiWebsiteController;
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
        
        return view('website.contact', array_merge($contactData, ['breadcrumb' => $breadcrumb]));
    }

    /**
     * Display enrollment/registration page
     */
    public function enroll()
    {
        // Get classes for enrollment form
        $classesData = $this->apiController->classes();
        $classes = json_decode($classesData->getContent(), true);
        
        // Get breadcrumb data
        $breadcrumbData = $this->apiController->breadcrumb('enroll');
        $breadcrumb = json_decode($breadcrumbData->getContent(), true);
        
        return view('website.enroll', [
            'classes' => $classes['classes'] ?? [],
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Handle enrollment form submission
     */
    public function enrollSubmit(Request $request)
    {
        // This will be handled by the student enrollment API
        // For now, redirect to contact or show success message
        return redirect()->route('website.enroll')
            ->with('success', 'Thank you for your enrollment request. We will contact you soon!');
    }
}

