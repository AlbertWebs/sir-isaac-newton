@extends('layouts.app')

@section('title', 'Timetables Management')
@section('page-title', 'Timetables Management')

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Timetables</h2>
        <p class="text-sm text-gray-600 mt-1">Manage class schedules and detect conflicts</p>
    </div>
    <div class="flex gap-2">
        @if($selectedClass)
        <a href="{{ route('timetables.download-pdf', ['class_id' => $selectedClass->id, 'academic_year' => $academicYear]) }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download PDF
        </a>
        @endif
        <a href="{{ route('timetables.download-pdf', ['academic_year' => $academicYear]) }}" target="_blank" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            All Classes PDF
        </a>
        @if(auth()->user()->isSuperAdmin())
        <a href="{{ route('timetables.create', ['class_id' => $selectedClass?->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Period
        </a>
        @endif
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('timetables.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
        <div class="md:w-64">
            <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">Select Class</label>
            <select 
                id="class_id" 
                name="class_id" 
                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                onchange="this.form.submit()"
            >
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }} ({{ $class->code }}) - {{ $class->level }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="md:w-48">
            <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
            <input 
                type="text" 
                id="academic_year" 
                name="academic_year" 
                value="{{ $academicYear }}"
                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="e.g., 2024"
            >
        </div>
        
        <div class="md:w-48">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select 
                id="status" 
                name="status" 
                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                onchange="this.form.submit()"
            >
                <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <div class="md:w-auto">
            <label class="block text-sm font-medium text-gray-700 mb-2 invisible">Actions</label>
            <button 
                type="submit" 
                class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                Filter
            </button>
        </div>
    </form>
</div>

<!-- Conflicts Warning -->
@if($selectedClass && !empty($conflicts))
<div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 rounded-lg">
    <div class="flex items-start">
        <svg class="w-6 h-6 text-yellow-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <div>
            <h3 class="text-lg font-bold text-yellow-900">Schedule Conflicts Detected</h3>
            <ul class="mt-2 text-yellow-800 text-sm list-disc list-inside">
                @foreach($conflicts as $timetableId => $timetableConflicts)
                    @foreach($timetableConflicts as $conflict)
                        <li>{{ $conflict }}</li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

@if($selectedClass)
    <!-- Weekly Timetable Grid for Selected Class -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">{{ $selectedClass->name }} - {{ $selectedClass->code }} ({{ $selectedClass->level }})</h3>
            <p class="text-blue-100 text-sm mt-1">Academic Year: {{ $academicYear }}</p>
        </div>
        
        @php
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            $classTimetables = $timetables->get($selectedClass->id, collect());
            $timeSlots = [];
            
            // Get all unique time slots
            foreach ($classTimetables as $timetable) {
                $timeKey = $timetable->start_time->format('H:i') . '-' . $timetable->end_time->format('H:i');
                if (!isset($timeSlots[$timeKey])) {
                    $timeSlots[$timeKey] = [
                        'start' => $timetable->start_time->format('H:i'),
                        'end' => $timetable->end_time->format('H:i'),
                    ];
                }
            }
            ksort($timeSlots);
            
            // Group by day
            $timetableByDay = [];
            foreach ($days as $day) {
                $timetableByDay[$day] = $classTimetables->where('day', $day)->sortBy('start_time');
            }
        @endphp
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Time</th>
                        @foreach($days as $day)
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                {{ ucfirst($day) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @if(!empty($timeSlots))
                        @foreach($timeSlots as $timeSlot)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 bg-gray-50">
                                    {{ $timeSlot['start'] }} - {{ $timeSlot['end'] }}
                                </td>
                                @foreach($days as $day)
                                    <td class="px-4 py-4 text-sm">
                                        @php
                                            $period = $timetableByDay[$day]->first(function($t) use ($timeSlot) {
                                                return $t->start_time->format('H:i') === $timeSlot['start'] 
                                                    && $t->end_time->format('H:i') === $timeSlot['end'];
                                            });
                                        @endphp
                                        @if($period)
                                            <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-lg shadow-sm hover:shadow-md transition-shadow {{ isset($conflicts[$period->id]) ? 'bg-red-50 border-red-500' : '' }}">
                                                <div class="font-semibold text-gray-900">{{ $period->subject->name }}</div>
                                                <div class="text-xs text-gray-600 mt-1 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    @if($period->teacher)
                                                        {{ $period->teacher->first_name }} {{ $period->teacher->last_name }}
                                                    @else
                                                        <span class="text-gray-400">No teacher</span>
                                                    @endif
                                                </div>
                                                @if($period->room)
                                                    <div class="text-xs text-gray-500 mt-1 flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                        </svg>
                                                        Room: {{ $period->room }}
                                                    </div>
                                                @endif
                                                @if(auth()->user()->isSuperAdmin())
                                                <div class="flex gap-2 mt-2 pt-2 border-t border-blue-200">
                                                    <a href="{{ route('admin.timetables.edit', $period->id) }}" class="text-xs text-blue-600 hover:text-blue-700 hover:bg-blue-100 px-2 py-1 rounded transition-all">Edit</a>
                                                    <form action="{{ route('admin.timetables.destroy', $period->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this period?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-600 hover:text-red-700 hover:bg-red-100 px-2 py-1 rounded transition-all">Delete</button>
                                                    </form>
                                                </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="p-3 bg-gray-50 rounded-lg text-center text-gray-400 text-xs border border-gray-200">
                                                Free
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-lg font-medium mb-2">No timetable entries found</p>
                                <p class="text-gray-500 text-sm mb-6">Start by adding periods for this class</p>
                                <a href="{{ route('admin.timetables.create', ['class_id' => $selectedClass->id]) }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Periods
                                </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@else
    <!-- Classes List -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($classes as $class)
            @php
                $classTimetables = $timetables->get($class->id, collect());
                $periodCount = $classTimetables->count();
            @endphp
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $class->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $class->code }} - {{ $class->level }}</p>
                    </div>
                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                        {{ $periodCount }} periods
                    </span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('timetables.index', ['class_id' => $class->id, 'academic_year' => $academicYear]) }}" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 text-center text-sm font-semibold shadow-md hover:shadow-lg">
                        View Timetable
                    </a>
                    <a href="{{ route('timetables.download-pdf', ['class_id' => $class->id, 'academic_year' => $academicYear]) }}" target="_blank" class="px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

