@extends('layouts.website')

@section('title', 'Classes')
@section('description', 'Explore our classes and programs at Sir Isaac Newton School - From PP1 to Grade 6.')

@section('content')
<!-- Breadcrumb -->
@if(isset($breadcrumb) && $breadcrumb)
<section class="breadcumb-wrapper" data-bg-src="{{ $breadcrumb['background_image'] ?? asset('selected/assets/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $breadcrumb['title'] ?? 'Classes' }}</h1>
            <p class="breadcumb-text">{{ $breadcrumb['paragraph'] ?? 'Explore our classes' }}</p>
        </div>
    </div>
</section>
@endif

<!-- Classes Section -->
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title">Our Classes</h2>
            <p class="sec-text">Choose the right class for your child</p>
        </div>
        <div class="row gx-50 gy-gx">
            @forelse($classes ?? [] as $class)
            <div class="col-md-6 col-lg-4">
                <div class="class-style1">
                    <div class="class-img">
                        <a href="#"><img src="{{ asset('selected/assets/img/class/cl-1-1.jpg') }}" alt="{{ $class['name'] }}"></a>
                    </div>
                    <div class="class-content">
                        <h3 class="class-title"><a class="text-inherit" href="#">{{ $class['name'] }}</a></h3>
                        <p class="class-info">Available: <span class="info">{{ ($class['capacity'] ?? 0) - ($class['current_enrollment'] ?? 0) }} Seats</span></p>
                        @if($class['description'])
                            <p class="class-text">{{ Str::limit($class['description'], 100) }}</p>
                        @endif
                        @if($class['price'] ?? null)
                            <p class="class-price">KES {{ number_format($class['price'], 2) }} <span class="duration">/ term</span></p>
                        @endif
                        <a href="{{ route('website.enroll') }}" class="class-btn"><i class="far fa-plus"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No classes available at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

