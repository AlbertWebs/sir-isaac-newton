@extends('layouts.app')

@section('title', 'Timetable Period Details')
@section('page-title', 'Timetable Period Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $timetable->subject->name }}</h2>
                <p class="text-gray-600">{{ $timetable->schoolClass->name }} - {{ ucfirst($timetable->day) }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $timetable->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($timetable->status) }}
                </span>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.timetables.edit', $timetable->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Period
                </a>
                @endif
                <a href="{{ route('admin.timetables.index', ['class_id' => $timetable->class_id, 'academic_year' => $timetable->academic_year]) }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Timetable
                </a>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Period Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Period Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Class</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $timetable->schoolClass->name }} ({{ $timetable->schoolClass->code }})</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Subject</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $timetable->subject->name }} ({{ $timetable->subject->code }})</dd>
                </div>
                @if($timetable->teacher)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Teacher</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $timetable->teacher->first_name }} {{ $timetable->teacher->last_name }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Day</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ ucfirst($timetable->day) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Time</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $timetable->start_time->format('H:i') }} - {{ $timetable->end_time->format('H:i') }}</dd>
                </div>
                @if($timetable->room)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Room</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $timetable->room }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Academic Year</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $timetable->academic_year }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection

