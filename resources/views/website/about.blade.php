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
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('website.homepage') }}">Home</a></li>
                    <li>About Us</li>
                </ul>
            </div>
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
                @if(isset($about_school['image']) && $about_school['image'])
                    <div class="img-box1a">
                        <img style="border-radius: 20px;" src="{{ asset('storage/' . $about_school['image']) }}" alt="About School" class="w-100">
                    </div>
                @endif
            </div>
            <div class="col-lg-6 text-center text-lg-start">
                <h2 class="sec-title">{{ $about_school['title'] ?? 'About Our School' }}</h2>
                <p class="sec-text">{{ $about_school['paragraph'] ?? 'We are committed to providing quality education and holistic development for all children.' }}</p>
            </div>
        </div>
    </div>
</section>
@endif

@if(isset($team) && count($team) > 0)
<section class=" space-top space-extra-bottom bg-smoke">
    <div class="container">
        <div class="title-area text-center">
            <div class="sec-bubble">
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
            </div>
            <h2 class="sec-title">Qualified Teachers</h2>
            <p class="sec-text">Meet our dedicated team of educators</p>
        </div>
        <div class="row align-items-center">
            @foreach($team as $index => $member)
                @if($index == 0)
                    <div class="col-lg-6">
                        <div class="team-style1">
                            <div class="team-img">
                                <a href="#"><img src="{{ $member['image'] ?? asset('selected/assets/img/team/t-1-1.jpg') }}" alt="{{ $member['name'] }}"></a>
                            </div>
                            <div class="team-content">
                                <h3 class="team-name h2"><a href="#" class="text-inherit">{{ $member['name'] }}</a></h3>
                                <p class="team-degi">{{ $member['position'] }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-6 col-lg-3">
                        <div class="team-style2">
                            <div class="team-img"><a href="#"><img src="{{ $member['image'] ?? asset('selected/assets/img/team/t-1-2.jpg') }}" alt="{{ $member['name'] }}"></a></div>
                            <h3 class="team-name"><a class="text-inherit" href="#">{{ $member['name'] }}</a></h3>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="row text-center text-lg-start mt-lg-5 pt-4 align-items-center justify-content-between">
            <div class="col-lg-8 col-xl-9">
                <div class="title-area mb-xl-0">
                    <span class="sec-subtitle">learning by connecting practice</span>
                    <h2 class="sec-title">Promoting high quality learning of Young Children</h2>
                </div>
            </div>
            <div class="col-lg-auto">
                <div class="sec-btns mb-0">
                    <a href="{{ route('website.enroll') }}" class="vs-btn">Start Registration</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if(isset($timeline) && count($timeline) > 0)
<section class=" space-top space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <span class="sec-subtitle">History</span>
            <h2 class="sec-title">School History</h2>
        </div>
        <div class="row">
            @foreach($timeline as $item)
                <div class="col-md-6 col-xl-3 feature-style4">
                    <div class="feature-body">
                        <span class="feature-year">{{ $item['year'] }}</span>
                        <h3 style="min-height: 60px;" class="feature-title h5">{{ $item['title'] }}</h3>
                        <p style="min-height: 135px; border:1px solid #000; padding:10px; border-radius: 10px;" class="feature-text">{{ $item['description'] }}</p>
                        <div class="feature-img">
                            <a href="#"><img src="{{ $item['image'] ?? asset('selected/assets/img/feature/fe-2-1.jpg') }}" alt="feature"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

    <div class=" space-extra-bottom">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-6 col-md-6 col-lg-auto">
                    <div class="vs-media media-style1 layout2">
                        <div class="media-icon"><img src="{{ asset('selected/assets/img/icon/coun-1-1.svg') }}" alt="icon"></div>
                        <div class="media-body">
                            <p class="media-label">{{ $stats['total_classrooms'] ?? 0 }}</p>
                            <p class="media-title">Student Classrooms</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-auto">
                    <div class="vs-media media-style1 layout2">
                        <div class="media-icon"><img src="{{ asset('selected/assets/img/icon/coun-1-2.svg') }}" alt="icon"></div>
                        <div class="media-body">
                            <p class="media-label">{{ $stats['total_kids_classes'] ?? 0 }}</p>
                            <p class="media-title">Kids Classes</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-auto">
                    <div class="vs-media media-style1 layout2">
                        <div class="media-icon"><img src="{{ asset('selected/assets/img/icon/coun-1-3.svg') }}" alt="icon"></div>
                        <div class="media-body">
                            <p class="media-label">{{ $stats['total_outdoor_activities'] ?? 0 }}</p>
                            <p class="media-title">Outdoor Activities</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-auto">
                    <div class="vs-media media-style1 layout2">
                        <div class="media-icon"><img src="{{ asset('selected/assets/img/icon/coun-1-4.svg') }}" alt="icon"></div>
                        <div class="media-body">
                            <p class="media-label">{{ $stats['total_teachers'] ?? 0 }}</p>
                            <p class="media-title">Loving Teachers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

