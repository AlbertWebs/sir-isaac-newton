@extends('layouts.website')

@section('title', 'About Us')
@section('description', 'Learn more about Sir Isaac Newton School - Our mission, team, history, and commitment to creating world changers.')

@section('content')
<!-- Breadcrumb -->
@if(isset($breadcrumb) && $breadcrumb)
<section class="breadcumb-wrapper" data-bg-src="{{ $breadcrumb['background_image'] ?? asset('selected/assets/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $breadcrumb['title'] ?? 'About Us' }}</h1>
            <p class="breadcumb-text">{{ $breadcrumb['paragraph'] ?? 'Learn more about our school' }}</p>
        </div>
    </div>
</section>
@endif

<!-- About School Section -->
@if(isset($about_school) && $about_school)
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row gx-70 align-items-center">
            <div class="col-lg-6">
                @if($about_school->image)
                    <div class="img-box1">
                        <img src="{{ asset('storage/' . $about_school->image) }}" alt="About School" class="w-100">
                    </div>
                @endif
            </div>
            <div class="col-lg-6 text-center text-lg-start">
                <h2 class="sec-title">{{ $about_school->title ?? 'About Our School' }}</h2>
                <p class="sec-text">{{ $about_school->paragraph ?? 'We are committed to providing quality education and holistic development for all children.' }}</p>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Team Section -->
@if(isset($team) && count($team) > 0)
<section class="space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title">Our Team</h2>
            <p class="sec-text">Meet our dedicated team of educators</p>
        </div>
        <div class="row vs-carousel" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2">
            @foreach($team as $member)
            <div class="col-xl-3">
                <div class="team-style1">
                    <div class="team-img">
                        <img src="{{ $member['image'] ?? asset('selected/assets/img/team/team-1-1.jpg') }}" alt="{{ $member['name'] }}">
                    </div>
                    <div class="team-content">
                        <h3 class="team-name">{{ $member['name'] }}</h3>
                        <p class="team-title">{{ $member['position'] }}</p>
                        @if($member['bio'])
                            <p class="team-text">{{ Str::limit($member['bio'], 100) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- History Timeline -->
@if(isset($timeline) && count($timeline) > 0)
<section class="space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title">School History</h2>
        </div>
        <div class="timeline-wrapper">
            @foreach($timeline as $item)
            <div class="timeline-item">
                <div class="timeline-year">{{ $item['year'] }}</div>
                <div class="timeline-content">
                    <h3>{{ $item['title'] }}</h3>
                    @if($item['feature_label'])
                        <span class="timeline-label">{{ $item['feature_label'] }}</span>
                    @endif
                    <p>{{ $item['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Clubs Section -->
@if(isset($clubs) && count($clubs) > 0)
<section class="space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title">Our Clubs</h2>
        </div>
        <div class="row gx-4">
            @foreach($clubs as $club)
            <div class="col-md-6 col-lg-4">
                <div class="club-card">
                    @if($club['image'])
                        <img src="{{ $club['image'] }}" alt="{{ $club['name'] }}" class="w-100">
                    @endif
                    <h3>{{ $club['name'] }}</h3>
                    <p>{{ $club['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

