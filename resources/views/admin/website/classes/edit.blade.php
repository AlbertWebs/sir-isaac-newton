@extends('layouts.app')

@section('title', 'Edit Class')
@section('page-title', 'Edit Class for Website')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Edit Class: {{ $class->name }}</h2>
            <p class="text-indigo-100 text-sm mt-1">Update website visibility and description</p>
        </div>

        <form method="POST" action="{{ route('admin.website.classes.update', $class) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <div class="md:col-span-2 group">
                    <label for="website_description" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-indigo-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Website Description
                        </span>
                    </label>
                    <textarea id="website_description" name="website_description" rows="3"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white resize-none"
                        placeholder="Brief description for website display...">{{ old('website_description', $class->website_description) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1.5">This description will be shown on the website classes page</p>
                    @error('short_description')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2 group">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-indigo-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Class Image
                        </span>
                    </label>
                    @if($class->image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                            <img src="{{ asset($class->image) }}" alt="Current Image" class="w-48 h-32 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                            <p class="text-xs text-gray-500 mt-2">This image will be displayed on the website classes page.</p>
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-500 mt-1.5">Upload a new image for the class (optional). Supported formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB.</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="website_visible" name="website_visible" value="1" {{ old('website_visible', $class->website_visible) ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="website_visible" class="ml-2 text-sm text-gray-700">Show this class on the website</label>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href="{{ route('admin.website.classes.index') }}" 
                    class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Class
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

