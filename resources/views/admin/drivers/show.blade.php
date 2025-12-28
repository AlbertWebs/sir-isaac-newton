@extends('layouts.app')

@section('title', 'Driver Details')
@section('page-title', 'Driver Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Driver Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-4">
                @if($driver->photo)
                    <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->full_name }}" class="w-20 h-20 rounded-full object-cover">
                @else
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                        {{ strtoupper(substr($driver->first_name, 0, 1) . substr($driver->last_name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $driver->full_name }}</h2>
                    <p class="text-gray-600">{{ $driver->driver_number }}</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $driver->status === 'active' ? 'bg-green-100 text-green-800' : ($driver->status === 'suspended' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($driver->status) }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->hasPermission('drivers.edit'))
                <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Driver
                </a>
                @endif
                <a href="{{ route('admin.drivers.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $driver->full_name }}</dd>
                </div>
                @if($driver->email)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="text-sm text-gray-900 mt-1">
                        <a href="mailto:{{ $driver->email }}" class="text-blue-600 hover:text-blue-800">{{ $driver->email }}</a>
                    </dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $driver->phone }}</dd>
                </div>
                @if($driver->date_of_birth)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $driver->date_of_birth->format('F d, Y') }}</dd>
                </div>
                @endif
                @if($driver->gender)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Gender</dt>
                    <dd class="text-sm text-gray-900 mt-1 capitalize">{{ $driver->gender }}</dd>
                </div>
                @endif
                @if($driver->address)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $driver->address }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- License Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">License Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">License Number</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $driver->license_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">License Class</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $driver->license_class }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">License Expiry</dt>
                    <dd class="text-sm text-gray-900 mt-1">
                        {{ $driver->license_expiry->format('F d, Y') }}
                        @if($driver->license_expiry->isPast())
                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Expired</span>
                        @elseif($driver->license_expiry->diffInDays(now()) < 30)
                            <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Expiring Soon</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Assigned Routes -->
        @if($driver->routes->count() > 0)
        <div class="md:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Assigned Routes</h3>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($driver->routes as $route)
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h4 class="font-medium text-gray-900">{{ $route->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $route->code }}</p>
                    <span class="inline-block mt-2 px-2 py-1 rounded text-xs {{ $route->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($route->status) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

