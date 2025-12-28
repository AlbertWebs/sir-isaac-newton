@extends('layouts.website')

@section('title', 'Gallery')
@section('description', 'View our gallery of school activities, events, and moments at Sir Isaac Newton School.')

@section('content')
<!-- Breadcrumb -->
@if(isset($breadcrumb) && $breadcrumb)
<section class="breadcumb-wrapper" data-bg-src="{{ $breadcrumb['background_image'] ?? asset('selected/assets/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $breadcrumb['title'] ?? 'Gallery' }}</h1>
            <p class="breadcumb-text">{{ $breadcrumb['paragraph'] ?? 'View our gallery' }}</p>
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title">Our Gallery</h2>
            <p class="sec-text">Capturing moments of learning and growth</p>
        </div>
        <div class="row gx-4 gy-4">
            @forelse($images ?? [] as $image)
            <div class="col-md-6 col-lg-4">
                <div class="gallery-item">
                    <a href="{{ $image['image_url'] }}" class="popup-image">
                        <img src="{{ $image['image_url'] }}" alt="{{ $image['caption'] ?? 'Gallery Image' }}" class="w-100">
                        @if($image['caption'])
                            <div class="gallery-caption">{{ $image['caption'] }}</div>
                        @endif
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No images available at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

