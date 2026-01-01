@extends('layouts.app')

@section('title', 'Announcements Management')
@section('page-title', 'Announcements Management')

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">All Announcements</h2>
        <p class="text-sm text-gray-600 mt-1">Manage announcements and notifications for different portals</p>
    </div>
    @if(auth()->user()->hasPermission('announcements.create'))
    <a href="{{ route('announcements.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Create Announcement
    </a>
    @endif
</div>

<!-- Search and Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.announcements.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
        <!-- Search Input -->
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Announcements</label>
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
                    placeholder="Search by title, message..."
                    class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
        </div>
        
        <!-- Target Audience Filter -->
        <div class="md:w-48">
            <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-2">Target Portal</label>
            <select 
                id="target_audience" 
                name="target_audience" 
                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                onchange="this.form.submit()"
            >
                <option value="">All Portals</option>
                <option value="all" {{ $audienceFilter === 'all' ? 'selected' : '' }}>All</option>
                <option value="admin" {{ $audienceFilter === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="teachers" {{ $audienceFilter === 'teachers' ? 'selected' : '' }}>Teachers</option>
                <option value="parents" {{ $audienceFilter === 'parents' ? 'selected' : '' }}>Parents</option>
                <option value="students" {{ $audienceFilter === 'students' ? 'selected' : '' }}>Students</option>
            </select>
        </div>
        
        <!-- Status Filter -->
        <div class="md:w-48">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select 
                id="status" 
                name="status" 
                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                onchange="this.form.submit()"
            >
                <option value="">All Status</option>
                <option value="draft" {{ $statusFilter === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active</option>
                <option value="archived" {{ $statusFilter === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>
        
        <!-- Priority Filter -->
        <div class="md:w-48">
            <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
            <select 
                id="priority" 
                name="priority" 
                class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                onchange="this.form.submit()"
            >
                <option value="">All Priorities</option>
                <option value="low" {{ $priorityFilter === 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $priorityFilter === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $priorityFilter === 'high' ? 'selected' : '' }}>High</option>
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

<!-- Announcements Table -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-pink-50 to-rose-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Target Portal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Priority</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Posted By</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Published</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($announcements as $announcement)
                    <tr class="hover:bg-pink-50 transition-colors duration-150 cursor-pointer group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-2 h-2 bg-pink-500 rounded-full mr-3 group-hover:bg-pink-600 transition-colors"></div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $announcement->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($announcement->message, 60) }}</div>
                                    @if($announcement->hasAttachment())
                                        <div class="mt-1.5">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-pink-100 text-pink-700">
                                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                                Attachment
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full 
                                {{ $announcement->target_audience === 'all' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $announcement->target_audience === 'admin' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $announcement->target_audience === 'teachers' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $announcement->target_audience === 'parents' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $announcement->target_audience === 'students' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            ">
                                {{ ucfirst($announcement->target_audience) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full 
                                {{ $announcement->priority === 'high' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $announcement->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $announcement->priority === 'low' ? 'bg-gray-100 text-gray-600' : '' }}
                            ">
                                {{ ucfirst($announcement->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $announcement->postedBy->name ?? 'System' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($announcement->published_at)
                                <div class="text-sm text-gray-900 font-medium">{{ $announcement->published_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $announcement->published_at->format('H:i') }}</div>
                            @else
                                <span class="text-gray-400 italic text-sm">Not published</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold 
                                {{ $announcement->status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $announcement->status === 'draft' ? 'bg-gray-100 text-gray-600' : '' }}
                                {{ $announcement->status === 'archived' ? 'bg-red-100 text-red-700' : '' }}
                            ">
                                {{ ucfirst($announcement->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                @if(auth()->user()->hasPermission('announcements.edit'))
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="p-2 text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-all duration-200" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @endif
                                @if(auth()->user()->hasPermission('announcements.delete'))
                                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
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
                        <td colspan="7" class="px-6 py-16">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-pink-100 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-lg font-medium mb-2">No announcements found</p>
                                <p class="text-gray-500 text-sm mb-6">Get started by creating your first announcement</p>
                                @if(auth()->user()->hasPermission('announcements.create'))
                                <a href="{{ route('announcements.create') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-pink-600 to-rose-600 text-white rounded-lg hover:from-pink-700 hover:to-rose-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create First Announcement
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($announcements->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        {{ $announcements->links() }}
    </div>
    @endif
</div>
@endsection

