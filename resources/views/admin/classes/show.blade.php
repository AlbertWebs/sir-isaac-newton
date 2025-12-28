@extends('layouts.app')

@section('title', 'Class Details')
@section('page-title', 'Class Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Class Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $class->name }}</h2>
                <p class="text-gray-600">{{ $class->code }} - {{ $class->level }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $class->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($class->status) }}
                </span>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.classes.edit', $class->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Class
                </a>
                @endif
                <a href="{{ route('admin.classes.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Class Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Class Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Class Name</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $class->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Class Code</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $class->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Level</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $class->level }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Academic Year</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $class->academic_year }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Term</dt>
                    <dd class="text-sm text-gray-900 mt-1">Term {{ $class->term }}</dd>
                </div>
                @if($class->classTeacher)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Class Teacher</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $class->classTeacher->first_name }} {{ $class->classTeacher->last_name }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Enrollment</dt>
                    <dd class="text-sm text-gray-900 mt-1">
                        {{ $class->students()->count() }} / {{ $class->capacity ?? 'N/A' }}
                        @if($class->capacity && $class->students()->count() >= $class->capacity)
                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Full</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Term Fee</dt>
                    <dd class="text-sm text-gray-900 mt-1 font-semibold">
                        KES {{ number_format($class->price ?? 0, 2) }}
                    </dd>
                </div>
                @if($class->description)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $class->description }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Students -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Enrolled Students</h3>
            @if($class->students->count() > 0)
                <div class="space-y-2">
                    @foreach($class->students->take(10) as $student)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $student->first_name }} {{ $student->last_name }}</p>
                            <p class="text-xs text-gray-500">{{ $student->admission_number ?? $student->student_number }}</p>
                        </div>
                    </div>
                    @endforeach
                    @if($class->students->count() > 10)
                        <p class="text-sm text-gray-500 mt-2">And {{ $class->students->count() - 10 }} more students...</p>
                    @endif
                </div>
            @else
                <p class="text-gray-500 text-sm">No students enrolled yet.</p>
            @endif
        </div>

        <!-- Subjects -->
        @if($class->subjects->count() > 0)
        <div class="md:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Subjects</h3>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach($class->subjects as $subject)
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h4 class="font-medium text-gray-900">{{ $subject->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $subject->code }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

