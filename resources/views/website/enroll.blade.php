@extends('layouts.website')

@section('title', 'Enroll')
@section('description', 'Enroll your child at Sir Isaac Newton School. Start the application process today.')

@section('content')
<!-- Breadcrumb -->
@if(isset($breadcrumb) && $breadcrumb)
<section class="breadcumb-wrapper" data-bg-src="{{ $breadcrumb['background_image'] ?? asset('selected/assets/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $breadcrumb['title'] ?? 'Enrollment' }}</h1>
            <p class="breadcumb-text">{{ $breadcrumb['paragraph'] ?? 'Apply for admission' }}</p>
        </div>
    </div>
</section>
@endif

<!-- Enrollment Form Section -->
<section class="space-top space-extra-bottom" data-bg-src="{{ asset('selected/assets/img/bg/bg-con-1-1.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-xl-auto col-xxl-6">
                <div class="img-box6">
                    <div class="img-1 mega-hover"><img src="{{ asset('selected/assets/img/about/con-1-1.jpg') }}" alt="image"></div>
                    <div class="img-2 mega-hover"><img src="{{ asset('selected/assets/img/about/con-1-2.jpg') }}" alt="image"></div>
                </div>
            </div>
            <div class="col-xl col-xxl-6 align-self-center">
                <h2 class="sec-title mb-3">Apply for Admission</h2>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('website.enroll.submit') }}" method="POST" class="form-style3">
                    @csrf
                    <div class="row justify-content-between">
                        <div class="col-md-6 form-group">
                            <label>Child's Name <span class="required">(Required)</span></label>
                            <input type="text" name="child_name" value="{{ old('child_name') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Child's Date of Birth <span class="required">(Required)</span></label>
                            <input type="date" name="child_dob" value="{{ old('child_dob') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Parent's Name <span class="required">(Required)</span></label>
                            <input type="text" name="parent_name" value="{{ old('parent_name') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Parent's Email <span class="required">(Required)</span></label>
                            <input type="email" name="parent_email" value="{{ old('parent_email') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phone Number <span class="required">(Required)</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Select Class</label>
                            <select name="class_id" class="form-control">
                                <option value="">-- Select Class --</option>
                                @foreach($classes ?? [] as $class)
                                    <option value="{{ $class['id'] }}" {{ old('class_id') == $class['id'] ? 'selected' : '' }}>
                                        {{ $class['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Additional Information</label>
                            <textarea name="additional_info" rows="4" class="form-control">{{ old('additional_info') }}</textarea>
                        </div>
                        <div class="col-auto align-self-center form-group">
                            <input type="checkbox" id="notify_progress" name="notify_progress" value="1" {{ old('notify_progress') ? 'checked' : '' }}>
                            <label for="notify_progress">Notify me about my child's weekly progress</label>
                        </div>
                        <div class="col-auto form-group">
                            <button class="vs-btn" type="submit">Apply Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

