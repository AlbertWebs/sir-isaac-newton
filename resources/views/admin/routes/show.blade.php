@extends('layouts.app')

@section('title', 'Route Details')
@section('page-title', 'Route Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Route Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $route->name }}</h2>
                <p class="text-gray-600 mt-1">{{ $route->code }}</p>
                <div class="flex items-center gap-3 mt-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $route->type === 'morning' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $route->type === 'afternoon' ? 'bg-orange-100 text-orange-800' : '' }}
                        {{ $route->type === 'both' ? 'bg-green-100 text-green-800' : '' }}
                    ">
                        {{ ucfirst($route->type) }} Service
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $route->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}
                    ">
                        {{ ucfirst($route->status) }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->hasPermission('transport.edit'))
                <a href="{{ route('admin.routes.edit', $route->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Route
                </a>
                @endif
                <a href="{{ route('admin.routes.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Routes
                </a>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Route Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Route Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $route->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Code</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $route->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Service Type</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ ucfirst($route->type) }}</dd>
                </div>
                @if($route->vehicle)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Vehicle</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $route->vehicle->registration_number }} - {{ $route->vehicle->make }} {{ $route->vehicle->model }}</dd>
                </div>
                @endif
                @if($route->driver)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Driver</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $route->driver->first_name }} {{ $route->driver->last_name }} ({{ $route->driver->driver_number }})</dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Assigned Students</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $studentCount }}</dd>
                </div>
                @if($route->estimated_distance_km)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Estimated Distance</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $route->estimated_distance_km }} km</dd>
                </div>
                @endif
                @if($route->estimated_duration_minutes)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Estimated Duration</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $route->estimated_duration_minutes }} minutes</dd>
                </div>
                @endif
                @if($route->notes)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $route->notes }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Schedule Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Schedule</h3>
            @if($route->type === 'morning' || $route->type === 'both')
            <div class="mb-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Morning</h4>
                <dl class="space-y-2">
                    @if($route->morning_pickup_time)
                    <div>
                        <dt class="text-xs text-gray-500">Pickup Time</dt>
                        <dd class="text-sm text-gray-900">{{ $route->morning_pickup_time->format('H:i') }}</dd>
                    </div>
                    @endif
                    @if($route->morning_dropoff_time)
                    <div>
                        <dt class="text-xs text-gray-500">Dropoff Time</dt>
                        <dd class="text-sm text-gray-900">{{ $route->morning_dropoff_time->format('H:i') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            @endif
            @if($route->type === 'afternoon' || $route->type === 'both')
            <div>
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Afternoon</h4>
                <dl class="space-y-2">
                    @if($route->afternoon_pickup_time)
                    <div>
                        <dt class="text-xs text-gray-500">Pickup Time</dt>
                        <dd class="text-sm text-gray-900">{{ $route->afternoon_pickup_time->format('H:i') }}</dd>
                    </div>
                    @endif
                    @if($route->afternoon_dropoff_time)
                    <div>
                        <dt class="text-xs text-gray-500">Dropoff Time</dt>
                        <dd class="text-sm text-gray-900">{{ $route->afternoon_dropoff_time->format('H:i') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

