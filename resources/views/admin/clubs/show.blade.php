@extends('layouts.app')

@section('title', 'Club Details')
@section('page-title', 'Club Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Club Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $club->name }}</h2>
                <p class="text-gray-600 mt-1">{{ $club->code }}</p>
                <div class="flex items-center gap-3 mt-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $club->type === 'sports' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $club->type === 'academic' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $club->type === 'arts' ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $club->type === 'cultural' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $club->type === 'other' ? 'bg-gray-100 text-gray-800' : '' }}
                    ">
                        {{ ucfirst($club->type) }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $club->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $club->status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $club->status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}
                    ">
                        {{ ucfirst($club->status) }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->hasPermission('clubs.edit'))
                <a href="{{ route('admin.clubs.edit', $club->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Club
                </a>
                @endif
                <a href="{{ route('admin.clubs.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Clubs
                </a>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Club Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Club Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $club->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Code</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $club->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ ucfirst($club->type) }}</dd>
                </div>
                @if($club->coordinator)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Coordinator</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $club->coordinator->first_name }} {{ $club->coordinator->last_name }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Members</dt>
                    <dd class="text-sm text-gray-900 mt-1">
                        {{ $currentMembers }}
                        @if($club->max_members)
                            / {{ $club->max_members }}
                        @else
                            (unlimited)
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ ucfirst($club->status) }}</dd>
                </div>
                @if($club->description)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $club->description }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Members List -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Active Members</h3>
            @if($club->students->where('pivot.status', 'active')->count() > 0)
                <div class="space-y-2">
                    @foreach($club->students->where('pivot.status', 'active') as $student)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $student->full_name }}</p>
                                <p class="text-xs text-gray-500">{{ $student->admission_number }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                {{ ucfirst(str_replace('_', ' ', $student->pivot->role)) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No active members</p>
            @endif
        </div>
    </div>
</div>
@endsection

