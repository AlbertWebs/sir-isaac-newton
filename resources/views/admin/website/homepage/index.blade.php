@extends('layouts.app')

@section('title', 'Homepage Management')
@section('page-title', 'Homepage Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Homepage Management</h2>
            <p class="text-purple-100 text-sm mt-1">Manage all homepage sections and content</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sliders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $sliders->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sections</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $sections->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Features</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $features->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">FAQs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $faqs->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Session Times</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $sessionTimes->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Sliders Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Carousel Sliders</h3>
                <p class="text-purple-100 text-sm mt-1">{{ $sliders->where('is_visible', true)->count() }} visible</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage homepage carousel slider images and content.</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.website.homepage.sliders.index') }}" 
                        class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 text-center font-medium">
                        Manage
                    </a>
                    <a href="{{ route('admin.website.homepage.sliders.create') }}" 
                        class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg hover:bg-purple-50 transition-colors duration-200 font-medium">
                        Add New
                    </a>
                </div>
            </div>
        </div>

        <!-- Sections Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Page Sections</h3>
                <p class="text-blue-100 text-sm mt-1">About, Programs, Day Care</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage homepage sections content and settings.</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.website.homepage.sections.index') }}" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-center font-medium">
                        Manage
                    </a>
                    <a href="{{ route('admin.website.homepage.sections.create') }}" 
                        class="px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200 font-medium">
                        Add New
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Features</h3>
                <p class="text-green-100 text-sm mt-1">{{ $features->where('is_visible', true)->count() }} visible</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage feature cards displayed on homepage.</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.website.homepage.features.index') }}" 
                        class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-center font-medium">
                        Manage
                    </a>
                    <a href="{{ route('admin.website.homepage.features.create') }}" 
                        class="px-4 py-2 border-2 border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors duration-200 font-medium">
                        Add New
                    </a>
                </div>
            </div>
        </div>

        <!-- FAQs Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-yellow-600 to-amber-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">FAQs</h3>
                <p class="text-yellow-100 text-sm mt-1">{{ $faqs->where('is_visible', true)->count() }} visible</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage frequently asked questions section.</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.website.homepage.faqs.index') }}" 
                        class="flex-1 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200 text-center font-medium">
                        Manage
                    </a>
                    <a href="{{ route('admin.website.homepage.faqs.create') }}" 
                        class="px-4 py-2 border-2 border-yellow-600 text-yellow-600 rounded-lg hover:bg-yellow-50 transition-colors duration-200 font-medium">
                        Add New
                    </a>
                </div>
            </div>
        </div>

        <!-- Session Times Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Session Times</h3>
                <p class="text-orange-100 text-sm mt-1">{{ $sessionTimes->where('is_visible', true)->count() }} visible</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage session schedule times displayed on homepage.</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.website.homepage.session-times.index') }}" 
                        class="flex-1 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors duration-200 text-center font-medium">
                        Manage
                    </a>
                    <a href="{{ route('admin.website.homepage.session-times.create') }}" 
                        class="px-4 py-2 border-2 border-orange-600 text-orange-600 rounded-lg hover:bg-orange-50 transition-colors duration-200 font-medium">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

