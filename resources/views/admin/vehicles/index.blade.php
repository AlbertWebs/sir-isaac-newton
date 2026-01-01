@extends('layouts.app')

@section('title', 'Vehicles Management')
@section('page-title', 'Vehicles Management')

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">All Vehicles</h2>
        <p class="text-sm text-gray-600 mt-1">Manage school vehicles and transportation fleet</p>
    </div>
    @if(auth()->user()->hasPermission('transport.create'))
    <a href="{{ route('vehicles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Add Vehicle
    </a>
    @endif
</div>

<!-- Search and Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.vehicles.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
        <!-- Search Input -->
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Vehicles</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input 
                    type="text" 
                    id="search" 
                    name="search" 
                    value="{{ $searchTerm }}"
                    placeholder="Search by registration, make, model, insurance..."
                    class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
        </div>
        
        <!-- Type Filter -->
        <div class="md:w-48">
            <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">Filter by Type</label>
            <select 
                id="vehicle_type" 
                name="vehicle_type" 
                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                onchange="this.form.submit()"
            >
                <option value="">All Types</option>
                <option value="bus" {{ $typeFilter === 'bus' ? 'selected' : '' }}>Bus</option>
                <option value="van" {{ $typeFilter === 'van' ? 'selected' : '' }}>Van</option>
                <option value="car" {{ $typeFilter === 'car' ? 'selected' : '' }}>Car</option>
                <option value="minibus" {{ $typeFilter === 'minibus' ? 'selected' : '' }}>Minibus</option>
                <option value="other" {{ $typeFilter === 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        
        <!-- Status Filter -->
        <div class="md:w-48">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
            <select 
                id="status" 
                name="status" 
                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                onchange="this.form.submit()"
            >
                <option value="">All Status</option>
                <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="maintenance" {{ $statusFilter === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
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

<!-- Vehicles Table -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Registration</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Make & Model</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Capacity</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Year</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Insurance</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($vehicles as $vehicle)
                    <tr class="hover:bg-gray-50 transition-colors duration-150 cursor-pointer group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-2 h-2 bg-gray-500 rounded-full mr-3 group-hover:bg-gray-600 transition-colors"></div>
                                <div class="text-sm font-semibold text-gray-900">{{ $vehicle->registration_number }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $vehicle->make }}</div>
                            <div class="text-xs text-gray-500">{{ $vehicle->model }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                {{ ucfirst($vehicle->vehicle_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700 font-medium">{{ $vehicle->capacity }} seats</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $vehicle->year ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($vehicle->insurance_expiry)
                                <div class="text-sm text-gray-900 font-medium">{{ $vehicle->insurance_number ?? 'N/A' }}</div>
                                <div class="text-xs mt-1 {{ $vehicle->insurance_expiry->isPast() ? 'text-red-600 font-medium' : ($vehicle->insurance_expiry->isBefore(now()->addDays(30)) ? 'text-yellow-600 font-medium' : 'text-gray-500') }}">
                                    Expires: {{ $vehicle->insurance_expiry->format('M d, Y') }}
                                </div>
                            @else
                                <span class="text-gray-400 italic text-sm">Not set</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold 
                                {{ $vehicle->status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $vehicle->status === 'inactive' ? 'bg-gray-100 text-gray-600' : '' }}
                                {{ $vehicle->status === 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            ">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                @if(auth()->user()->hasPermission('transport.edit'))
                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="p-2 text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-all duration-200" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @endif
                                @if(auth()->user()->hasPermission('transport.delete'))
                                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-lg font-medium mb-2">No vehicles found</p>
                                <p class="text-gray-500 text-sm mb-6">Get started by adding your first vehicle</p>
                                @if(auth()->user()->hasPermission('transport.create'))
                                <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-gray-600 to-slate-600 text-white rounded-lg hover:from-gray-700 hover:to-slate-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add First Vehicle
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($vehicles->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $vehicles->links() }}
    </div>
    @endif
</div>
@endsection

