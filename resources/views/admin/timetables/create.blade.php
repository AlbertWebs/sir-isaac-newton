@extends('layouts.app')

@section('title', 'Add Timetable Period')
@section('page-title', 'Add Timetable Period')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Add Timetable Period</h2>
            <p class="text-blue-100 text-sm mt-1">Schedule a new class period</p>
        </div>

        <form method="POST" action="{{ route('admin.timetables.store') }}" id="timetableForm" class="p-6">
            @csrf

            <!-- Conflict Warning -->
            @if(session('conflict_details'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-bold text-red-900">Schedule Conflicts Detected</h3>
                        <ul class="mt-2 text-red-800 text-sm list-disc list-inside">
                            @foreach(session('conflict_details') as $conflict)
                                <li>{{ $conflict }}</li>
                            @endforeach
                        </ul>
                        <p class="mt-2 text-sm text-red-700 font-semibold">Please adjust the schedule to avoid conflicts.</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Period Information</h3>
                    </div>
                </div>

                <div class="group">
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Class *
                        </span>
                    </label>
                    <select id="class_id" name="class_id" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
                        onchange="loadClassSubjects(this.value)"
                    >
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $selectedClass?->id) == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} ({{ $class->code }}) - {{ $class->level }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Subject *
                        </span>
                    </label>
                    <select id="subject_id" name="subject_id" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
                    >
                        <option value="">Select Subject</option>
                        @if($selectedClass)
                            @foreach($classSubjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('subject_id')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Teacher
                        </span>
                    </label>
                    <select id="teacher_id" name="teacher_id"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
                    >
                        <option value="">Select Teacher (Optional)</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->first_name }} {{ $teacher->last_name }} ({{ $teacher->employee_number }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="day" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Day *
                        </span>
                    </label>
                    <select id="day" name="day" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
                    >
                        <option value="">Select Day</option>
                        <option value="monday" {{ old('day') === 'monday' ? 'selected' : '' }}>Monday</option>
                        <option value="tuesday" {{ old('day') === 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="wednesday" {{ old('day') === 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="thursday" {{ old('day') === 'thursday' ? 'selected' : '' }}>Thursday</option>
                        <option value="friday" {{ old('day') === 'friday' ? 'selected' : '' }}>Friday</option>
                        <option value="saturday" {{ old('day') === 'saturday' ? 'selected' : '' }}>Saturday</option>
                    </select>
                    @error('day')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Start Time *
                        </span>
                    </label>
                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        onchange="checkEndTime()"
                    >
                    @error('start_time')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            End Time *
                        </span>
                    </label>
                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                    >
                    @error('end_time')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="room" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Room
                        </span>
                    </label>
                    <input type="text" id="room" name="room" value="{{ old('room') }}"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., Lab 1, Room 101"
                    >
                    @error('room')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Academic Year *
                        </span>
                    </label>
                    <input type="text" id="academic_year" name="academic_year" value="{{ old('academic_year', date('Y')) }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., 2024"
                    >
                    @error('academic_year')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status *
                        </span>
                    </label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
                    >
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
            </div>

            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href="{{ route('admin.timetables.index') }}" 
                    class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Period
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function checkEndTime() {
    const startTime = document.getElementById('start_time').value;
    const endTimeInput = document.getElementById('end_time');
    
    if (startTime && endTimeInput.value && endTimeInput.value <= startTime) {
        // Set end time to 1 hour after start time
        const start = new Date('2000-01-01T' + startTime + ':00');
        start.setHours(start.getHours() + 1);
        const endTime = start.toTimeString().slice(0, 5);
        endTimeInput.value = endTime;
    }
}

function loadClassSubjects(classId) {
    if (!classId) {
        document.getElementById('subject_id').innerHTML = '<option value="">Select Subject</option>';
        return;
    }
    
    // Fetch subjects for the selected class via AJAX
    fetch(`/api/v1/academics/classes/${classId}/subjects`)
        .then(response => response.json())
        .then(data => {
            const subjectSelect = document.getElementById('subject_id');
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
            
            if (data.subjects) {
                data.subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = `${subject.name} (${subject.code})`;
                    subjectSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading subjects:', error);
        });
}
</script>
@endsection

