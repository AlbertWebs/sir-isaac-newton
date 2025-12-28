@extends('layouts.app')

@section('title', 'Gallery Management')
@section('page-title', 'Gallery Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Gallery Management</h2>
                    <p class="text-teal-100 text-sm mt-1">Manage gallery images with drag & drop upload</p>
                </div>
                <a href="{{ route('admin.website.gallery.create') }}" 
                    class="px-6 py-2.5 bg-white text-teal-600 rounded-lg hover:bg-teal-50 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Upload Images
                    </span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.website.gallery.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="search" name="search" value="{{ $searchTerm }}" 
                    placeholder="Search by caption or activity..."
                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div class="min-w-[150px]">
                <label for="activity_event" class="block text-sm font-medium text-gray-700 mb-1">Activity/Event</label>
                <select id="activity_event" name="activity_event" 
                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="">All Activities</option>
                    @foreach($activityEvents as $event)
                        <option value="{{ $event }}" {{ $activityFilter === $event ? 'selected' : '' }}>{{ $event }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[150px]">
                <label for="is_visible" class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
                <select id="is_visible" name="is_visible" 
                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="">All</option>
                    <option value="1" {{ $visibilityFilter === '1' ? 'selected' : '' }}>Visible</option>
                    <option value="0" {{ $visibilityFilter === '0' ? 'selected' : '' }}>Hidden</option>
                </select>
            </div>
            <button type="submit" 
                class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-200 font-medium">
                Filter
            </button>
            @if($searchTerm || $activityFilter || $visibilityFilter)
            <a href="{{ route('admin.website.gallery.index') }}" 
                class="px-6 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium">
                Clear
            </a>
            @endif
        </form>
    </div>

    <!-- Gallery Grid -->
    @if($images->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($images as $image)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-200">
            <div class="relative aspect-square bg-gray-100">
                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->caption }}" 
                    class="w-full h-full object-cover">
                @if(!$image->is_visible)
                <div class="absolute top-2 right-2 bg-gray-800 bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                    Hidden
                </div>
                @endif
            </div>
            <div class="p-4">
                <p class="text-sm font-medium text-gray-900 mb-1 truncate">{{ $image->caption ?? 'No caption' }}</p>
                @if($image->activity_event)
                <p class="text-xs text-gray-500 mb-3">{{ $image->activity_event }}</p>
                @endif
                <div class="flex items-center justify-between gap-2">
                    <a href="{{ route('admin.website.gallery.edit', $image) }}" 
                        class="flex-1 px-3 py-1.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-200 text-center text-xs font-medium">
                        Edit
                    </a>
                    <form action="{{ route('admin.website.gallery.destroy', $image) }}" method="POST" 
                        onsubmit="return confirm('Delete this image?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-xs font-medium">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $images->links() }}
    </div>
    @else
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No images</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by uploading gallery images.</p>
        <div class="mt-6">
            <a href="{{ route('admin.website.gallery.create') }}" 
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Upload Images
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

