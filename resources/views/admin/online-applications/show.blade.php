@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="container-fluid py-6 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box bg-white p-4 rounded-lg shadow-md flex items-center justify-between">
                <h4 class="page-title text-2xl font-bold text-gray-800">Application Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.website.homepage.index') }}" class="text-blue-600 hover:text-blue-800">Website Management</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.website.online-applications.index') }}" class="text-blue-600 hover:text-blue-800">Online Applications</a></li>
                        <li class="breadcrumb-item active text-gray-600">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg rounded-lg">
                <div class="card-body p-6">
                    <h4 class="header-title text-2xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">Application #{{ $onlineApplication->id }} Details</h4>

                    @if(session('success'))
                        <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <p class="text-gray-800 bg-blue-50 p-2 rounded"><strong>Child's Name:</strong> <span class="font-semibold text-blue-800">{{ $onlineApplication->child_name }}</span></p>
                        <p class="text-gray-800 bg-blue-50 p-2 rounded"><strong>Child's Date of Birth:</strong> <span class="font-semibold text-blue-800">{{ \Carbon\Carbon::parse($onlineApplication->child_dob)->format('M d, Y') }}</span></p>
                        <p class="text-gray-800 bg-green-50 p-2 rounded"><strong>Parent's Name:</strong> <span class="font-semibold text-green-800">{{ $onlineApplication->parent_name }}</span></p>
                        <p class="text-gray-800 bg-green-50 p-2 rounded"><strong>Parent's Email:</strong> <span class="font-semibold text-green-800">{{ $onlineApplication->parent_email }}</span></p>
                        <p class="text-gray-800 bg-purple-50 p-2 rounded"><strong>Phone Number:</strong> <span class="font-semibold text-purple-800">{{ $onlineApplication->phone }}</span></p>
                        <p class="text-gray-800 bg-purple-50 p-2 rounded"><strong>Class Applied:</strong> <span class="font-semibold text-purple-800">{{ $onlineApplication->schoolClass->name ?? 'N/A' }}</span></p>
                        <p class="text-gray-800 bg-yellow-50 p-2 rounded col-span-1 md:col-span-2"><strong>Additional Info:</strong> <span class="font-semibold text-yellow-800">{{ $onlineApplication->additional_info ?? 'N/A' }}</span></p>
                        <p class="text-gray-800 bg-red-50 p-2 rounded"><strong>Notify Progress:</strong> <span class="font-semibold text-red-800">{{ $onlineApplication->notify_progress ? 'Yes' : 'No' }}</span></p>
                        <p class="text-gray-800 bg-indigo-50 p-2 rounded"><strong>Applied On:</strong> <span class="font-semibold text-indigo-800">{{ $onlineApplication->created_at->format('M d, Y H:i A') }}</span></p>
                        <p class="text-gray-800 bg-indigo-50 p-2 rounded"><strong>Last Updated:</strong> <span class="font-semibold text-indigo-800">{{ $onlineApplication->updated_at->format('M d, Y H:i A') }}</span></p>
                    </div>

                    <div class="mb-4 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h5 class="text-lg font-semibold text-gray-700 mb-4 border-b-2 border-gray-300 pb-2">Update Application Status</h5>
                        <form action="{{ route('admin.website.online-applications.update-status', $onlineApplication) }}" method="POST" class="flex flex-col sm:flex-row items-end space-y-4 sm:space-y-0 sm:space-x-4">
                            @csrf
                            @method('PUT')
                            <div class="flex-grow w-full">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                                <select name="status" id="status" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                                    <option value="pending" {{ $onlineApplication->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $onlineApplication->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="accepted" {{ $onlineApplication->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $onlineApplication->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="w-full sm:w-auto">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out w-full">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

