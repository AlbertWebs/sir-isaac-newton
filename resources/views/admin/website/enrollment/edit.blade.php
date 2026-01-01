@extends('layouts.admin')

@section('title', 'Edit Enrollment Page Content')
@section('description', 'Manage images and content for the public enrollment page.')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.website.homepage.index') }}" class="text-blue-600 hover:text-blue-800">Website Management</a></li>
                        <li class="breadcrumb-item active">Enrollment Page</li>
                    </ol>
                </div>
                <h4 class="page-title text-2xl font-bold text-gray-800">Edit Enrollment Page Content</h4>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="header-title mb-3">Manage Enrollment Images</h4>

            <form action="{{ route('admin.website.enrollment.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="enroll_image_1" class="form-label">Enrollment Image 1</label>
                    <input type="file" id="enroll_image_1" name="enroll_image_1" class="form-control @error('enroll_image_1') is-invalid @enderror">
                    @error('enroll_image_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(isset($schoolInformation->enroll_image_1) && $schoolInformation->enroll_image_1)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $schoolInformation->enroll_image_1) }}" alt="Enrollment Image 1" class="img-thumbnail" width="200">
                            <p class="mt-1 text-sm text-gray-500">Current Image</p>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="enroll_image_2" class="form-label">Enrollment Image 2</label>
                    <input type="file" id="enroll_image_2" name="enroll_image_2" class="form-control @error('enroll_image_2') is-invalid @enderror">
                    @error('enroll_image_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(isset($schoolInformation->enroll_image_2) && $schoolInformation->enroll_image_2)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $schoolInformation->enroll_image_2) }}" alt="Enrollment Image 2" class="img-thumbnail" width="200">
                            <p class="mt-1 text-sm text-gray-500">Current Image</p>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update Images</button>
            </form>
        </div>
    </div>
@endsection
