@extends('layouts.app')

@section('title', 'View Submission')
@section('page-title', 'Contact Form Submission')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Contact Form Submission</h2>
            <p class="text-pink-100 text-sm mt-1">View submission details</p>
        </div>

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Name</p>
                    <p class="text-gray-900 text-lg">{{ $submission->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-1">Email</p>
                    <p class="text-gray-900 text-lg">{{ $submission->email }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm font-medium text-gray-700 mb-1">Submitted</p>
                    <p class="text-gray-600">{{ $submission->created_at->format('F d, Y \a\t g:i A') }}</p>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-sm font-medium text-gray-700 mb-2">Message</p>
                <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $submission->message }}</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <form action="{{ route('admin.website.contact.destroy', $submission) }}" method="POST" 
                    onsubmit="return confirm('Are you sure you want to delete this submission?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="px-6 py-2.5 border-2 border-red-300 text-red-700 rounded-lg hover:bg-red-50 hover:border-red-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                        Delete
                    </button>
                </form>
                <a href="{{ route('admin.website.contact.index') }}" 
                    class="px-6 py-2.5 bg-gradient-to-r from-pink-600 to-rose-600 text-white rounded-lg hover:from-pink-700 hover:to-rose-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Back to Submissions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

