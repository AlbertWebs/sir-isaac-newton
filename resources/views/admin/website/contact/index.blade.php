@extends('layouts.app')

@section('title', 'Contact Management')
@section('page-title', 'Contact Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Contact Management</h2>
                    <p class="text-pink-100 text-sm mt-1">Manage contact information and view submissions</p>
                </div>
                <a href="{{ route('admin.website.contact.edit') }}" 
                    class="px-6 py-2.5 bg-white text-pink-600 rounded-lg hover:bg-pink-50 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Contact Info
                    </span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Contact Information Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4">
            <h3 class="text-lg font-bold text-white">Contact Information</h3>
        </div>
        <div class="p-6">
            @if($contactInfo)
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Address</p>
                    <p class="text-gray-900">{{ $contactInfo->address ?? 'Not set' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Phone</p>
                    <p class="text-gray-900">{{ $contactInfo->phone ?? 'Not set' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Email</p>
                    <p class="text-gray-900">{{ $contactInfo->email ?? 'Not set' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Google Map</p>
                    <p class="text-gray-900 text-sm">{{ $contactInfo->google_map_embed_url ? 'Configured' : 'Not set' }}</p>
                </div>
            </div>
            @else
            <p class="text-gray-500 text-center py-4">No contact information set. <a href="{{ route('admin.website.contact.edit') }}" class="text-pink-600 hover:underline">Add contact information</a></p>
            @endif
        </div>
    </div>

    <!-- Contact Submissions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4">
            <h3 class="text-lg font-bold text-white">Contact Form Submissions</h3>
        </div>
        @if($submissions->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($submissions as $submission)
                    <tr class="hover:bg-pink-50 transition-colors duration-150 {{ !$submission->is_read ? 'bg-pink-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $submission->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $submission->email }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ Str::limit($submission->message, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $submission->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($submission->is_read)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Read
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                    New
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.website.contact.show', $submission) }}" 
                                class="text-pink-600 hover:text-pink-900 transition-colors duration-200 p-2 hover:bg-pink-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $submissions->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No submissions</h3>
            <p class="mt-1 text-sm text-gray-500">Contact form submissions will appear here.</p>
        </div>
        @endif
    </div>
</div>
@endsection

