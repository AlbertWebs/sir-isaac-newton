@extends('layouts.app')

@section('title', 'About Page Management')
@section('page-title', 'About Page Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">About Page Management</h2>
            <p class="text-indigo-100 text-sm mt-1">Manage about page content, team, timeline, and clubs</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">About School</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $aboutContent ? '✓' : '—' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Team Members</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $teamMembers->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Timeline Events</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $timeline->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Clubs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $clubs->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- About School Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">About School</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage main about school content.</p>
                <a href="{{ route('admin.website.about.about-school.edit') }}" 
                    class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 text-center font-medium block">
                    Manage
                </a>
            </div>
        </div>

        <!-- Team Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Team Members</h3>
                <p class="text-blue-100 text-sm mt-1">{{ $teamMembers->where('is_visible', true)->count() }} visible</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage team member profiles.</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.website.about.team.index') }}" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-center font-medium">
                        Manage
                    </a>
                    <a href="{{ route('admin.website.about.team.create') }}" 
                        class="px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200 font-medium">
                        Add
                    </a>
                </div>
            </div>
        </div>

        <!-- Timeline Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-yellow-600 to-amber-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">History Timeline</h3>
                <p class="text-yellow-100 text-sm mt-1">{{ $timeline->where('is_visible', true)->count() }} visible</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage school history timeline.</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.website.about.timeline.index') }}" 
                        class="flex-1 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200 text-center font-medium">
                        Manage
                    </a>
                    <a href="{{ route('admin.website.about.timeline.create') }}" 
                        class="px-4 py-2 border-2 border-yellow-600 text-yellow-600 rounded-lg hover:bg-yellow-50 transition-colors duration-200 font-medium">
                        Add
                    </a>
                </div>
            </div>
        </div>

        <!-- Clubs Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Clubs</h3>
                <p class="text-green-100 text-sm mt-1">{{ $clubs->where('is_visible', true)->count() }} visible</p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Manage school clubs information.</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.website.about.clubs.index') }}" 
                        class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-center font-medium">
                        Manage
                    </a>
                    <a href="{{ route('admin.website.about.clubs.create') }}" 
                        class="px-4 py-2 border-2 border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors duration-200 font-medium">
                        Add
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

