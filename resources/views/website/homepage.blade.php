@extends('layouts.website')

@section('title', 'Home')
@section('description', 'Sir Isaac Newton School - Creating World Changers. Quality education and holistic development for children.')

@section('content')
<!-- Hero Area -->
<section class="vs-hero-wrapper">
    <div class="vs-hero-carousel" data-height="770" data-container="1900" data-slidertype="responsive" data-navbuttons="true">
        @forelse($sliders ?? [] as $slider)
        <div class="ls-slide" data-ls="duration:12000; transition2d:5; kenburnszoom:in; kenburnsscale:1.1;">
            <img width="1920" height="770" src="{{ $slider['image'] ?? asset('selected/assets/img/hero/hero-1-1.jpg') }}" class="ls-bg" alt="Hero Slide" decoding="async">
            <h1 style="font-size:60px; font-family:'Fredoka', sans-serif; line-height:60px; color:#ffffff; top:284px; left:312px; width:711px;" class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer" data-ls="offsetxin:-100; delayin:200; easingin:easeOutQuint; offsetxout:-100; easingout:easeOutQuint;">
                {{ $slider['text'] ?? 'We Prepare Your Child For Life' }}
            </h1>
            @if($slider['button_text'] ?? null)
            <div style="font-size:30px; left:100%; top:494px; font-family:'Fredoka', sans-serif; width:711px; margin-left:-877px;" class="ls-l ls-hide-tablet ls-hide-phone ls-html-layer" data-ls="offsetyin:100; delayin:700; easingin:easeOutQuint; offsetyout:100; easingout:easeOutQuint;">
                <a href="{{ $slider['button_link'] ?? route('website.contact') }}" class="vs-btn">{{ $slider['button_text'] }}</a>
            </div>
            @endif
        </div>
        @empty
        <!-- Default Slide -->
        <div class="ls-slide" data-ls="duration:12000; transition2d:5; kenburnszoom:in; kenburnsscale:1.1;">
            <img width="1920" height="770" src="{{ asset('selected/assets/img/hero/hero-1-1.jpg') }}" class="ls-bg" alt="Hero Slide" decoding="async">
            <h1 style="font-size:60px; font-family:'Fredoka', sans-serif; line-height:60px; color:#ffffff; top:284px; left:312px; width:711px;" class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer">
                We Prepare Your Child For Life
            </h1>
            <div style="font-size:30px; left:100%; top:494px; font-family:'Fredoka', sans-serif; width:711px; margin-left:-877px;" class="ls-l ls-hide-tablet ls-hide-phone ls-html-layer">
                <a href="{{ route('website.contact') }}" class="vs-btn">Apply Today</a>
            </div>
        </div>
        @endforelse
    </div>
</section>

<!-- About Area -->
@if(isset($about_section) && $about_section)
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row gx-70 align-items-center">
            <div class="col-lg-6">
                <div class="img-box1">
                    <div class="vs-circle"></div>
                    @if($about_section->image_1)
                        <div class="img-1 mega-hover"><img src="{{ asset('storage/' . $about_section->image_1) }}" alt="About"></div>
                    @endif
                    @if($about_section->image_2)
                        <div class="img-2 mega-hover"><img src="{{ asset('storage/' . $about_section->image_2) }}" alt="About"></div>
                    @endif
                    @if($about_section->image_3)
                        <div class="img-3 mega-hover"><img src="{{ asset('storage/' . $about_section->image_3) }}" alt="About"></div>
                    @endif
                    @if($about_section->image_4)
                        <div class="img-4 mega-hover"><img src="{{ asset('storage/' . $about_section->image_4) }}" alt="About"></div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-start">
                <span class="sec-subtitle">{{ $about_section->title ?? 'About Our School' }}</span>
                <h2 class="sec-title">{{ $about_section->heading ?? 'Your Child Will Take The Lead Learning' }}</h2>
                <p class="sec-text pe-xl-5 mb-4 pb-xl-3">{{ $about_section->paragraph ?? 'We are constantly expanding the range of services offered, taking care of children of all ages.' }}</p>
                @if($about_section->button_text)
                    <a href="{{ $about_section->button_link ?? route('website.about') }}" class="vs-btn">{{ $about_section->button_text }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<!-- Features/Service Area -->
@if(isset($features) && count($features) > 0)
<section class="space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <div class="sec-bubble">
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
            </div>
            <h2 class="sec-title">{{ $features[0]['section_heading'] ?? 'Enrol Your Child In A Session Now!' }}</h2>
            <p class="sec-text">{{ $features[0]['section_title'] ?? 'Pre-school has an open door policy and also offer a free trial session to all children.' }}</p>
        </div>
        <div class="row vs-carousel" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2">
            @foreach($features as $feature)
            <div class="service-style1 col-xl-3">
                <div class="service-body">
                    @if($feature['image'])
                        <div class="service-img"><a href="#"><img src="{{ $feature['image'] }}" alt="{{ $feature['title'] }}"></a></div>
                    @endif
                    <div class="service-content">
                        @if($feature['icon'])
                            <div class="service-icon"><img src="{{ $feature['icon'] }}" alt="icon"></div>
                        @endif
                        <h3 class="service-title"><a href="#">{{ $feature['title'] }}</a></h3>
                        <p class="service-text">{{ $feature['paragraph'] }}</p>
                        <div class="service-bottom">
                            <a href="{{ route('website.about') }}" class="service-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Programs/Classes Section -->
@if(isset($programs_section) && $programs_section)
<section class="space-extra-bottom" data-bg-src="{{ asset('selected/assets/img/bg/bg-h-1-1.jpg') }}">
    <div class="container">
        <div class="row justify-content-between text-center text-md-start">
            <div class="col-md-auto">
                <div class="title-area">
                    <span class="sec-subtitle">{{ $programs_section->title ?? 'Choose Your Own Grade Level' }}</span>
                    <h2 class="sec-title">{{ $programs_section->heading ?? 'Smarty Programs' }}</h2>
                </div>
            </div>
        </div>
        <div class="row vs-carousel gx-15 catslider1" data-slide-show="5" data-lg-slide-show="4" data-md-slide-show="3" data-sm-slide-show="2" data-xs-slide-show="2">
            @php
                $classes = \App\Models\SchoolClass::whereIn('level', ['pp1', 'pp2', 'grade_1', 'grade_2', 'grade_3', 'grade_4', 'grade_5', 'grade_6'])
                    ->where('website_visible', true)
                    ->where('status', 'active')
                    ->orderByRaw("CASE level WHEN 'pp1' THEN 1 WHEN 'pp2' THEN 2 WHEN 'grade_1' THEN 3 WHEN 'grade_2' THEN 4 WHEN 'grade_3' THEN 5 WHEN 'grade_4' THEN 6 WHEN 'grade_5' THEN 7 WHEN 'grade_6' THEN 8 END")
                    ->get();
            @endphp
            @foreach($classes as $class)
            <div class="col-xl-3">
                <div class="category-style1">
                    <div class="category-bg1"></div>
                    <div class="category-bg2"></div>
                    <div class="category-bg3"></div>
                    <div class="category-grade">
                        <span class="grade-label">Grade</span>
                        <span class="grade-name">{{ strtoupper(str_replace('grade_', '', $class->level)) }}</span>
                    </div>
                    <h3 class="category-name h4"><a href="{{ route('website.classes') }}" class="text-inherit">{{ $class->name }}</a></h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Session Times -->
@if(isset($session_times['section']) && $session_times['section'])
<section class="space-extra" data-bg-src="{{ asset('selected/assets/img/bg/table-bg-1-1.jpg') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10 col-xxl-8">
                <div class="table-style1">
                    <div class="table-icon"><i class="fal fa-alarm-clock"></i></div>
                    <h2 class="sec-title">{{ $session_times['section']->title ?? 'Session Times' }}</h2>
                    <p class="sec-text">{{ $session_times['section']->paragraph ?? 'We provide full day care from 8.30am to 3.30pm for children aged 18 months to 5 years.' }}</p>
                    <div class="table-body">
                        @foreach($session_times['schedule'] ?? [] as $schedule)
                        <div class="tr">
                            <div class="th">{{ $schedule['label'] }}</div>
                            <div class="td">{{ $schedule['time_range'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- FAQ Section -->
@if(isset($faqs['items']) && count($faqs['items']) > 0)
<section class="space-extra-bottom">
    <div class="container">
        <div class="row gx-80">
            <div class="col-lg-6 pb-3 pb-xl-0">
                <div class="img-box3">
                    <div class="img-1 mega-hover">
                        <img src="{{ asset('selected/assets/img/about/faq-1-1.jpg') }}" alt="FAQ">
                        <a href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="play-btn popup-video position-center"><i class="fas fa-play"></i></a>
                    </div>
                    <div class="vs-circle jump"></div>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="title-area text-center text-lg-start">
                    <span class="sec-subtitle">{{ $faqs['title'] ?? 'Guide to Preschool' }}</span>
                    <h2 class="sec-title">{{ $faqs['heading'] ?? 'Guide to Preschool' }}</h2>
                </div>
                <div class="accordion accordion-style1" id="faqVersion1">
                    @foreach($faqs['items'] as $index => $faq)
                    <div class="accordion-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                {{ $faq['question'] }}
                            </button>
                        </div>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqVersion1">
                            <div class="accordion-body">
                                <p>{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

