@extends('layouts.app')

@section('title', 'View Announcement')
@section('page-title', 'Announcement Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex items-start justify-between mb-6 pb-6 border-b">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $announcement->title }}</h2>
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $announcement->target_audience === 'all' ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $announcement->target_audience === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $announcement->target_audience === 'teachers' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $announcement->target_audience === 'parents' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $announcement->target_audience === 'students' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    ">
                        {{ ucfirst($announcement->target_audience) }} Portal
                    </span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $announcement->priority === 'high' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $announcement->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $announcement->priority === 'low' ? 'bg-gray-100 text-gray-800' : '' }}
                    ">
                        {{ ucfirst($announcement->priority) }} Priority
                    </span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $announcement->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $announcement->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $announcement->status === 'archived' ? 'bg-red-100 text-red-800' : '' }}
                    ">
                        {{ ucfirst($announcement->status) }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2">
                @if(auth()->user()->hasPermission('announcements.edit'))
                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                @endif
            </div>
        </div>

        <!-- Message Content -->
        <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Message</h3>
            <div class="prose max-w-none bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-800 whitespace-pre-wrap">{{ $announcement->message }}</p>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Posted By</h3>
                <p class="text-gray-900">{{ $announcement->postedBy->name ?? 'System' }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Published Date</h3>
                <p class="text-gray-900">
                    @if($announcement->published_at)
                        {{ $announcement->published_at->format('F d, Y \a\t H:i') }}
                    @else
                        <span class="text-gray-400">Not published</span>
                    @endif
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Created</h3>
                <p class="text-gray-900">{{ $announcement->created_at->format('F d, Y \a\t H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Last Updated</h3>
                <p class="text-gray-900">{{ $announcement->updated_at->format('F d, Y \a\t H:i') }}</p>
            </div>
        </div>

        <!-- Targeted Classes -->
        @if($targetClasses->isNotEmpty())
        <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Targeted Classes</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($targetClasses as $class)
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                        {{ $class->name }} ({{ $class->level }})
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Attachment -->
        @if($announcement->hasAttachment())
        <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Attachment</h3>
            <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $announcement->attachment_name }}</p>
                        <p class="text-xs text-gray-500">{{ $announcement->attachment_type }}</p>
                    </div>
                </div>
                <a href="{{ $announcement->getAttachmentUrl() }}" target="_blank" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Download
                </a>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6 border-t">
            <a href="{{ route('admin.announcements.index') }}" 
                class="text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Announcements
            </a>
            @if(auth()->user()->hasPermission('announcements.delete'))
            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" 
                onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection

