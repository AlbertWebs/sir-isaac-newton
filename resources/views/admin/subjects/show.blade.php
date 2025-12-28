@extends('layouts.app')

@section('title', 'Subject Details')
@section('page-title', 'Subject Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Subject Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $subject->name }}</h2>
                <p class="text-gray-600">{{ $subject->code }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $subject->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($subject->status) }}
                </span>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Subject
                </a>
                @endif
                <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Subject Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Subject Information</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Subject Name</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $subject->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Subject Code</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $subject->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                    <dd class="text-sm text-gray-900 mt-1">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">{{ ucfirst(str_replace('_', ' ', $subject->type)) }}</span>
                    </dd>
                </div>
                @if($subject->description)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $subject->description }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Assigned Classes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Assigned Classes</h3>
            @if($subject->classes->count() > 0)
                <div class="space-y-2">
                    @foreach($subject->classes as $class)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $class->name }}</p>
                            <p class="text-xs text-gray-500">{{ $class->code }} - {{ $class->level }}</p>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Active</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">This subject is not assigned to any classes yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection

