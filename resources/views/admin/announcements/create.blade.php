@extends('layouts.app')

@section('title', 'Create Announcement')
@section('page-title', 'Create New Announcement')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Create New Announcement</h2>
            <p class="text-pink-100 text-sm mt-1">Share important information with specific portals</p>
        </div>

        <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Announcement Details</h3>
                    </div>
                </div>

                <div class="group">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-pink-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                            Title *
                        </span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="Enter announcement title">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-pink-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Message *
                        </span>
                    </label>
                    <textarea id="message" name="message" rows="6" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white resize-none"
                        placeholder="Enter announcement message">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Targeting Section -->
                <div class="border-t pt-6 mt-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Targeting & Visibility</h3>
                    </div>
                </div>

                <div class="group">
                    <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-pink-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Target Portal *
                        </span>
                    </label>
                    <select id="target_audience" name="target_audience" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer">
                        <option value="">Select Target Portal</option>
                        @foreach($targetAudiences as $audience)
                            <option value="{{ $audience }}" {{ old('target_audience') === $audience ? 'selected' : '' }}>
                                {{ ucfirst($audience) }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Select which portal(s) should see this announcement
                    </p>
                    @error('target_audience')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div id="class-targeting" style="display: none;" class="group">
                    <label for="target_classes" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-pink-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Target Specific Classes (Optional)
                        </span>
                    </label>
                    <select id="target_classes" name="target_classes[]" multiple
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        size="5">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ in_array($class->id, old('target_classes', [])) ? 'selected' : '' }}>
                                {{ $class->name }} ({{ $class->level }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Hold Ctrl/Cmd to select multiple classes. Leave empty to target all.
                    </p>
                    @error('target_classes')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Priority & Status -->
                <div class="border-t pt-6 mt-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Priority & Status</h3>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="group">
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-pink-600 transition-colors">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Priority *
                            </span>
                        </label>
                        <select id="priority" name="priority" required
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer">
                            @foreach($priorities as $priority)
                                <option value="{{ $priority }}" {{ old('priority', 'medium') === $priority ? 'selected' : '' }}>
                                    {{ ucfirst($priority) }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-pink-600 transition-colors">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status *
                            </span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer">
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active (Publish Now)</option>
                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
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
                </div>

                <div class="group">
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-pink-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Schedule Publication (Optional)
                        </span>
                    </label>
                    <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at') }}"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white">
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Leave empty to publish immediately when status is set to Active
                    </p>
                    @error('published_at')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Attachment Section -->
                <div class="border-t pt-6 mt-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Attachment (Optional)</h3>
                    </div>
                </div>

                <div class="group">
                    <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-pink-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            Upload File
                        </span>
                    </label>
                    <input type="file" id="attachment" name="attachment"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 10MB)
                    </p>
                    @error('attachment')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.announcements.index') }}" 
                        class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-pink-600 to-rose-600 text-white rounded-lg hover:from-pink-700 hover:to-rose-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Announcement
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Show/hide class targeting based on target audience
    document.getElementById('target_audience').addEventListener('change', function() {
        const classTargeting = document.getElementById('class-targeting');
        const targetAudience = this.value;
        
        // Show class targeting for students and parents portals
        if (targetAudience === 'students' || targetAudience === 'parents') {
            classTargeting.style.display = 'block';
        } else {
            classTargeting.style.display = 'none';
            // Clear selection when hidden
            document.getElementById('target_classes').selectedIndex = -1;
        }
    });

    // Trigger on page load if value is already set
    document.addEventListener('DOMContentLoaded', function() {
        const targetAudience = document.getElementById('target_audience').value;
        if (targetAudience === 'students' || targetAudience === 'parents') {
            document.getElementById('class-targeting').style.display = 'block';
        }
    });
</script>
@endsection
