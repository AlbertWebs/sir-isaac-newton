@extends('layouts.website')

@section('title', 'Clubs')
@section('description', 'Explore the various clubs available at Sir Isaac Newton School.')

@section('content')
<!-- Breadcrumb -->
@if(isset($breadcrumb) && $breadcrumb)
<section class="breadcumb-wrapper" data-bg-src="{{ $breadcrumb['background_image'] ?? asset('selected/assets/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $breadcrumb['title'] ?? 'Clubs' }}</h1>
            <p class="breadcumb-text">{{ $breadcrumb['paragraph'] ?? 'Explore our exciting clubs' }}</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('website.homepage') }}">Home</a></li>
                    <li>Clubs</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

@if(isset($clubs) && (isset($clubs['early_club']) || isset($clubs['lunch_club']) || isset($clubs['afternoon_club']) || isset($clubs['music_club'])))
<section class=" space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <div class="sec-bubble">
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
            </div>
            <h2 class="sec-title">Available Clubs</h2>
            <p class="sec-text">We are constantly expanding the range of services offered</p>
        </div>
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6 col-xl-auto order-2 order-xl-1">
                @if(isset($clubs['early_club']) && $clubs['early_club'])
                    <div class="feature-style3">
                        <div class="feature-img">
                            <div class="img"><img src="{{ $clubs['early_club']['image'] ?? asset('selected/assets/img/feature/fe-1-1.jpg') }}" alt="{{ $clubs['early_club']['name'] }}"></div>
                        </div>
                        <div class="feature-body">
                            <h3 class="feature-title h4">{{ $clubs['early_club']['name'] }}</h3>
                            <div class="list-style2">
                                <ul class="list-unstyled">
                                    <li>{{ $clubs['early_club']['description'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(isset($clubs['lunch_club']) && $clubs['lunch_club'])
                    <div class="feature-style3">
                        <div class="feature-img">
                            <div class="img"><img src="{{ $clubs['lunch_club']['image'] ?? asset('selected/assets/img/feature/fe-1-2.jpg') }}" alt="{{ $clubs['lunch_club']['name'] }}"></div>
                        </div>
                        <div class="feature-body">
                            <h3 class="feature-title h4">{{ $clubs['lunch_club']['name'] }}</h3>
                            <div class="list-style2">
                                <ul class="list-unstyled">
                                    <li>{{ $clubs['lunch_club']['description'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-xl-auto order-1 order-xl-2">
                <img src="{{ asset('selected/assets/img/about/fe-1-1.png') }}" alt="feature" class="w-100">
            </div>
            <div class="col-md-6 col-xl-auto  order-3 order-xl-3">
                @if(isset($clubs['afternoon_club']) && $clubs['afternoon_club'])
                    <div class="feature-style3">
                        <div class="feature-img">
                            <div class="img"><img src="{{ $clubs['afternoon_club']['image'] ?? asset('selected/assets/img/feature/fe-1-3.jpg') }}" alt="{{ $clubs['afternoon_club']['name'] }}"></div>
                        </div>
                        <div class="feature-body">
                            <h3 class="feature-title h4">{{ $clubs['afternoon_club']['name'] }}</h3>
                            <div class="list-style2">
                                <ul class="list-unstyled">
                                    <li>{{ $clubs['afternoon_club']['description'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(isset($clubs['music_club']) && $clubs['music_club'])
                    <div class="feature-style3">
                        <div class="feature-img">
                            <div class="img"><img src="{{ $clubs['music_club']['image'] ?? asset('selected/assets/img/feature/fe-1-4.jpg') }}" alt="{{ $clubs['music_club']['name'] }}"></div>
                        </div>
                        <div class="feature-body">
                            <h3 class="feature-title h4">{{ $clubs['music_club']['name'] }}</h3>
                            <div class="list-style2">
                                <ul class="list-unstyled">
                                    <li>{{ $clubs['music_club']['description'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
@endsection