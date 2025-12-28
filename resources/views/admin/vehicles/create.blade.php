@extends('layouts.app')

@section('title', 'Add Vehicle')
@section('page-title', 'Add New Vehicle')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-gray-600 to-slate-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Create New Vehicle</h2>
            <p class="text-gray-100 text-sm mt-1">Add a new vehicle to the transportation fleet</p>
        </div>

        <form method="POST" action="{{ route('admin.vehicles.store') }}" class="p-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Vehicle Information -->
                <div class="md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-gray-500 to-slate-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Vehicle Information</h3>
                    </div>
                </div>

                <div class="group">
                    <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Registration Number *
                        </span>
                    </label>
                    <input type="text" id="registration_number" name="registration_number" value="{{ old('registration_number') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., KCA 123A">
                    @error('registration_number')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Vehicle Type *
                        </span>
                    </label>
                    <select id="vehicle_type" name="vehicle_type" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer">
                        <option value="">Select Type</option>
                        @foreach($vehicleTypes as $type)
                            <option value="{{ $type }}" {{ old('vehicle_type') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_type')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="make" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Make *
                        </span>
                    </label>
                    <input type="text" id="make" name="make" value="{{ old('make') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., Toyota">
                    @error('make')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="model" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Model *
                        </span>
                    </label>
                    <input type="text" id="model" name="model" value="{{ old('model') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., Hiace">
                    @error('model')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Year
                        </span>
                    </label>
                    <input type="number" id="year" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') + 1 }}"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., 2020">
                    @error('year')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            Color
                        </span>
                    </label>
                    <input type="text" id="color" name="color" value="{{ old('color') }}"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., White">
                    @error('color')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Capacity (Seats) *
                        </span>
                    </label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity', 14) }}" required min="1"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="e.g., 14">
                    @error('capacity')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Insurance & Inspection -->
                <div class="md:col-span-2 mt-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-gray-500 to-slate-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Insurance & Inspection</h3>
                    </div>
                </div>

                <div class="group">
                    <label for="insurance_number" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Insurance Number
                        </span>
                    </label>
                    <input type="text" id="insurance_number" name="insurance_number" value="{{ old('insurance_number') }}"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        placeholder="Insurance policy number">
                    @error('insurance_number')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="insurance_expiry" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Insurance Expiry Date
                        </span>
                    </label>
                    <input type="date" id="insurance_expiry" name="insurance_expiry" value="{{ old('insurance_expiry') }}"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white">
                    @error('insurance_expiry')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="group">
                    <label for="inspection_expiry" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Inspection Expiry Date
                        </span>
                    </label>
                    <input type="date" id="inspection_expiry" name="inspection_expiry" value="{{ old('inspection_expiry') }}"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white">
                    @error('inspection_expiry')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status & Notes -->
                <div class="md:col-span-2 mt-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-gray-500 to-slate-500 rounded-full mr-3"></div>
                        <h3 class="text-lg font-semibold text-gray-800">Status & Notes</h3>
                    </div>
                </div>

                <div class="group">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status *
                        </span>
                    </label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
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

                <div class="md:col-span-2 group">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-gray-600 transition-colors">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Notes
                        </span>
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white resize-none"
                        placeholder="Additional notes about the vehicle...">{{ old('notes') }}</textarea>
                    @error('notes')
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
                <a href="{{ route('admin.vehicles.index') }}" 
                    class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-gray-600 to-slate-600 text-white rounded-lg hover:from-gray-700 hover:to-slate-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Vehicle
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

