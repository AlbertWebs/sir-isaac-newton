@extends('layouts.app')

@section('title', 'Add Subject')
@section('page-title', 'Add New Subject')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Create New Subject</h2>
            <p class="text-purple-100 text-sm mt-1">Add a new subject to the curriculum</p>
        </div>

        <form method="POST" action="{{ route('admin.subjects.store') }}" class="p-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-purple-500 to-indigo-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Basic Information</h3>
                    </div>
                </div>

                <div class="group">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-purple-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Subject Name *
                        </span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., Mathematics">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-purple-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            Subject Code *
                        </span>
                    </label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., MATH">
                    @error('code')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-purple-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Subject Type *
                        </span>
                    </label>
                    <select id="type" name="type" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer">
                        <option value="">Select Type</option>
                        <option value="core" {{ old('type') === 'core' ? 'selected' : '' }}>Core</option>
                        <option value="language" {{ old('type') === 'language' ? 'selected' : '' }}>Language</option>
                        <option value="special_program" {{ old('type') === 'special_program' ? 'selected' : '' }}>Special Program (Coding & Robotics)</option>
                        <option value="extracurricular" {{ old('type') === 'extracurricular' ? 'selected' : '' }}>Extracurricular</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-purple-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status *
                        </span>
                    </label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2 group">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-purple-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Description
                        </span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white resize-none"
                        placeholder="Optional description about the subject...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href="{{ route('admin.subjects.index') }}" 
                    class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Subject
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

