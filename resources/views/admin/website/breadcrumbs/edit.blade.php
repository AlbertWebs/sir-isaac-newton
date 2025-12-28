@extends('layouts.app')

@section('title', 'Edit Breadcrumb')
@section('page-title', 'Edit Breadcrumb')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-cyan-600 to-teal-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Edit Breadcrumb</h2>
            <p class="text-cyan-100 text-sm mt-1">Update breadcrumb content for {{ str_replace('_', ' ', $breadcrumb->page_key) }} page</p>
        </div>

        <form method="POST" action="{{ route('admin.website.breadcrumbs.update', $breadcrumb) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            @if($breadcrumb->background_image)
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Background Image</label>
                <img src="{{ asset('storage/' . $breadcrumb->background_image) }}" alt="Current background" class="max-w-full h-48 object-cover rounded-lg shadow-sm">
            </div>
            @endif

            <div class="grid md:grid-cols-2 gap-6">
                <div class="md:col-span-2 group">
                    <label for="background_image" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-cyan-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            New Background Image (leave empty to keep current)
                        </span>
                    </label>
                    <input type="file" id="background_image" name="background_image" accept="image/*"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white">
                    <p class="text-xs text-gray-500 mt-1.5">Recommended size: 1920x400px. Max size: 5MB</p>
                    @error('background_image')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2 group">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-cyan-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Title *
                        </span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $breadcrumb->title) }}" required maxlength="255"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2 group">
                    <label for="paragraph" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-cyan-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Paragraph
                        </span>
                    </label>
                    <textarea id="paragraph" name="paragraph" rows="3"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white resize-none"
                        placeholder="Optional description...">{{ old('paragraph', $breadcrumb->paragraph) }}</textarea>
                    @error('paragraph')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href="{{ route('admin.website.breadcrumbs.index') }}" 
                    class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-cyan-600 to-teal-600 text-white rounded-lg hover:from-cyan-700 hover:to-teal-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Breadcrumb
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

