@extends('layouts.app')

@section('title', 'Upload Gallery Images')
@section('page-title', 'Upload Gallery Images')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Upload Gallery Images</h2>
            <p class="text-teal-100 text-sm mt-1">Drag & drop multiple images or click to browse</p>
        </div>

        <form method="POST" action="{{ route('admin.website.gallery.store-multiple') }}" enctype="multipart/form-data" class="p-6" id="galleryForm">
            @csrf

            <!-- Dropzone Area -->
            <div id="dropzone" class="border-4 border-dashed border-teal-300 rounded-xl p-12 text-center bg-teal-50 hover:bg-teal-100 transition-colors duration-200 cursor-pointer mb-6">
                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                <svg class="mx-auto h-16 w-16 text-teal-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="text-lg font-medium text-gray-700 mb-2">Drag & drop images here</p>
                <p class="text-sm text-gray-500 mb-4">or click to browse files</p>
                <p class="text-xs text-gray-400">Supports: JPG, PNG, GIF. Max size: 5MB per image</p>
                <p id="file-count-display" class="text-sm font-semibold text-teal-600 mt-2 hidden"></p>
            </div>

            <!-- Image Previews -->
            <div id="preview-container" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 hidden">
                <!-- Previews will be inserted here -->
            </div>

            <!-- Hidden input to store file data -->
            <input type="hidden" id="selected-files-count" value="0">

            <!-- Form Fields -->
            <div class="grid md:grid-cols-2 gap-6">
                <div class="group">
                    <label for="activity_event" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-teal-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Activity/Event
                        </span>
                    </label>
                    <input type="text" id="activity_event" name="activity_event" value="{{ old('activity_event') }}" maxlength="255"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., Sports Day, Graduation">
                    @error('activity_event')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Visibility
                        </span>
                    </label>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_visible" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}
                            class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                        <label for="is_visible" class="ml-2 text-sm text-gray-700">Visible on website</label>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div id="upload-progress" class="hidden mt-6">
                <div class="bg-gray-200 rounded-full h-2.5">
                    <div id="progress-bar" class="bg-teal-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <p id="progress-text" class="text-sm text-gray-600 mt-2 text-center">Uploading...</p>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href="{{ route('admin.website.gallery.index') }}" 
                    class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                    Cancel
                </a>
                <button type="submit" id="submit-btn"
                    class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg hover:from-teal-700 hover:to-cyan-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Images
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('images');
    const previewContainer = document.getElementById('preview-container');
    const form = document.getElementById('galleryForm');

    // Click to browse
    dropzone.addEventListener('click', () => fileInput.click());

    // Drag and drop
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-teal-500', 'bg-teal-100');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-teal-500', 'bg-teal-100');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-teal-500', 'bg-teal-100');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFiles(files);
        }
    });

    // File input change
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFiles(this.files);
        }
    });

    let selectedFiles = [];
    let fileIdCounter = 0;

    function handleFiles(files) {
        // Add new files to selectedFiles array
        Array.from(files).forEach((file) => {
            if (file.type.startsWith('image/')) {
                // Check if file already exists
                const exists = selectedFiles.some(f => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified);
                if (!exists) {
                    file._id = fileIdCounter++;
                    selectedFiles.push(file);
                }
            }
        });

        // Update file input
        updateFileInput();

        // Update preview
        updatePreview();
        document.getElementById('selected-files-count').value = selectedFiles.length;
        
        // Update file count display
        const fileCountDisplay = document.getElementById('file-count-display');
        if (selectedFiles.length > 0) {
            fileCountDisplay.textContent = `${selectedFiles.length} file(s) selected`;
            fileCountDisplay.classList.remove('hidden');
        } else {
            fileCountDisplay.classList.add('hidden');
        }
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    function updatePreview() {
        previewContainer.innerHTML = '';
        
        if (selectedFiles.length === 0) {
            previewContainer.classList.add('hidden');
            return;
        }

        previewContainer.classList.remove('hidden');

        selectedFiles.forEach((file) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'relative group';
                preview.setAttribute('data-file-id', file._id);
                preview.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover rounded-lg shadow-sm">
                        <button type="button" onclick="removeFileById(${file._id})" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 rounded-b-lg truncate">
                            ${file.name}
                        </div>
                        <div class="absolute top-2 left-2 bg-teal-500 text-white text-xs px-2 py-1 rounded">
                            ${(file.size / 1024 / 1024).toFixed(2)} MB
                        </div>
                    </div>
                `;
                previewContainer.appendChild(preview);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeFileById(fileId) {
        selectedFiles = selectedFiles.filter(file => file._id !== fileId);
        
        // Update file input
        updateFileInput();
        
        // Update preview
        updatePreview();
        document.getElementById('selected-files-count').value = selectedFiles.length;
        
        // Update file count display
        const fileCountDisplay = document.getElementById('file-count-display');
        if (selectedFiles.length > 0) {
            fileCountDisplay.textContent = `${selectedFiles.length} file(s) selected`;
            fileCountDisplay.classList.remove('hidden');
        } else {
            fileCountDisplay.classList.add('hidden');
        }
    }

    // Make removeFileById available globally
    window.removeFileById = removeFileById;

    // Form submission with progress
    form.addEventListener('submit', function(e) {
        const files = fileInput.files;
        if (files.length === 0) {
            e.preventDefault();
            alert('Please select at least one image.');
            return false;
        }

        // Validate file sizes
        let hasInvalidFile = false;
        Array.from(files).forEach((file, index) => {
            if (file.size > 5 * 1024 * 1024) { // 5MB
                alert(`File "${file.name}" exceeds 5MB limit.`);
                hasInvalidFile = true;
            }
        });

        if (hasInvalidFile) {
            e.preventDefault();
            return false;
        }

        // Show progress bar
        document.getElementById('upload-progress').classList.remove('hidden');
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="flex items-center"><svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Uploading...</span>';

        // Simulate progress (actual progress would be handled by server-side)
        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            if (progress <= 90) {
                document.getElementById('progress-bar').style.width = progress + '%';
                document.getElementById('progress-text').textContent = `Uploading ${files.length} image(s)... ${progress}%`;
            }
        }, 200);

        // Clear interval on form submit (will be cleared when page reloads)
        setTimeout(() => clearInterval(interval), 10000);
    });
});
</script>
@endsection


