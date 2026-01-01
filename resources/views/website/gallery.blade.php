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
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('website.homepage') }}">Home</a></li>
                    <li>Gallery</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title">Our Gallery</h2>
            <p class="sec-text">Capturing moments of learning and growth</p>
        </div>

        {{-- Activity/Event Filter --}}
        @if(isset($activity_events) && count($activity_events) > 0)
        <div class="row mb-5">
            <div class="col-12 text-center">
                <div class="filter-btns-wrap filter-active">
                    <button data-filter="*" class="filter-btn active">All</button>
                    @foreach($activity_events as $event)
                    <button data-filter=".{{ Str::slug($event) }}" class="filter-btn">{{ $event }}</button>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="row gallery-row filter-active">
            @forelse($images ?? [] as $image)
            <div class="col-md-6 col-lg-4 filter-item {{ Str::slug($image['activity_event']) }}">
                <div class="gallery-style2" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <div class="gallery-img">
                        <img src="{{ $image['image_url'] }}" alt="{{ $image['caption'] ?? 'Gallery Image' }}" style="width: 100%; height: 250px; object-fit: cover; border-radius: 10px 10px 0 0;">
                        <a href="{{ $image['image_url'] }}" class="gallery-btn popup-image"><i class="far fa-search-plus"></i></a>
                    </div>
                    <div class="gallery-content" style="padding: 15px; background-color: #f8f8f8; border-radius: 0 0 10px 10px;">
                        <h3 class="gallery-title" style="font-size: 1.25rem; margin-bottom: 5px; color: #333;">{{ $image['caption'] ?? 'Image' }}</h3>
                        @if($image['activity_event'])
                            <p class="gallery-tag" style="font-size: 0.9rem; color: #777; margin-bottom: 0;">{{ $image['activity_event'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No images available at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>
        
        {{-- Pagination --}}
        @if(isset($pagination) && $pagination['last_page'] > 1)
            <div class="row">
                <div class="col-12">
                    <div class="vs-pagination text-center pt-50">
                        <ul>
                            @if($pagination['current_page'] > 1)
                                <li><a href="{{ route('website.gallery', ['page' => $pagination['current_page'] - 1]) }}"><i class="far fa-arrow-left"></i></a></li>
                            @endif
                            @for($i = 1; $i <= $pagination['last_page']; $i++)
                                <li><a href="{{ route('website.gallery', ['page' => $i]) }}" class="{{ $i == $pagination['current_page'] ? 'active' : '' }}">{{ $i }}</a></li>
                            @endfor
                            @if($pagination['current_page'] < $pagination['last_page'])
                                <li><a href="{{ route('website.gallery', ['page' => $pagination['current_page'] + 1]) }}"><i class="far fa-arrow-right"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

