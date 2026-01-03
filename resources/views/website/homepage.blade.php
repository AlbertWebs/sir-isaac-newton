@extends('layouts.website')

@section('title', 'Home')
@section('description', 'Sir Isaac Newton School - Creating World Changers. Quality education and holistic development for children.')

@section('content')
<section class="vs-hero-wrapper  ">
    <div class="vs-hero-carousel" data-height="900" data-container="1900" data-slidertype="responsive"
        data-navbuttons="true">
        @forelse($sliders ?? [] as $slider)
        <!-- Slide 1-->
        <div class="ls-slide" data-ls="duration:12000; transition2d:5; kenburnszoom:in; kenburnsscale:1.1;">
            <img width="1920" height="900" style="object-fit: cover;" src="{{ $slider['image'] ?? asset('selected/assets/img/hero/hero-1-1.jpg') }}" class="ls-bg ls-hide-desktop ls-hide-tablet" alt="bg"
                decoding="async">
            <ls-layer
                style="font-size:36px; color:#000; stroke:#000; stroke-width:0px; text-align:left; font-style:normal; text-decoration:none; text-transform:none; font-weight:400; letter-spacing:0px; border-style:solid; background-position:0% 0%; background-repeat:no-repeat; background-clip:border-box; overflow:visible; width:255px; height:255px; border-width:60px 60px 60px 60px; border-color:#FFD600; border-radius:50% 50% 50% 50%; top:126px; left:740px; z-index:4; -webkit-background-clip:border-box;"
                class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer " data-ls="static:forever;">
            </ls-layer>
            <div style="font-size:36px; stroke:#000; stroke-width:0px; text-align:left; font-style:normal; text-decoration:none; text-transform:none; font-weight:400; letter-spacing:0px; background-position:0% 0%; background-repeat:no-repeat; background-clip:border-box; overflow:visible; width:711px; height:410px; left:312px; top:213px; background-color:#002c53; border-radius:213px 206px 50px 213px; z-index:5; -webkit-background-clip:border-box;"
                class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer " data-ls="static:forever;"></div>
            <div style="font-size:36px; stroke:#000; stroke-width:0px; text-align:left; font-style:normal; text-decoration:none; text-transform:none; font-weight:400; letter-spacing:0px; background-position:0% 0%; background-repeat:no-repeat; background-clip:border-box; opacity:0.9; overflow:visible; width:1200px; height:600px; left:350px; top:76px; background-color:#002c53; border-radius:213px 206px 50px 213px; z-index:5; -webkit-background-clip:border-box;"
                class="ls-l ls-hide-desktop ls-hide-phone ls-text-layer " data-ls="static:forever;"></div>
            <!-- <div style="font-size:36px; stroke:#000; stroke-width:0px; text-align:left; font-style:normal; text-decoration:none; text-transform:none; font-weight:400; letter-spacing:0px; background-position:0% 0%; background-repeat:no-repeat; background-clip:border-box; opacity:0.9; overflow:visible; width:1300px; height:700px; left:50%; top:33px; background-color:#002c53; border-radius:213px 206px 50px 213px; z-index:5; -webkit-background-clip:border-box;"
                class="ls-l ls-hide-desktop ls-hide-tablet ls-text-layer " data-ls="static:forever;"></div> -->
            <h1 style="font-size:60px; stroke:#000; stroke-width:0px; text-align:center; font-style:normal; text-decoration:none; text-transform:none; font-weight:600; letter-spacing:0px; background-position:0% 0%; background-repeat:no-repeat; background-clip:border-box; overflow:visible; font-family:'Fredoka', sans-serif; line-height:60px; color:#ffffff; top:284px; left:312px; width:711px; -webkit-background-clip:border-box;"
                class="ls-l ls-hide-tablet ls-hide-phone ls-hide-phone ls-text-layer "
                data-ls="offsetxin:-100; delayin:200; easingin:easeOutQuint; offsetxout:-100; easingout:easeOutQuint;">
                {!! $slider['text'] ?? 'We Prepare Your Child For Life' !!}
            </h1>
         
            <p style="font-size:18px; stroke:#000; stroke-width:0px; text-align:center; font-style:normal; text-decoration:none; text-transform:none; font-weight:400; letter-spacing:0px; background-position:0% 0%; background-repeat:no-repeat; background-clip:border-box; overflow:visible; font-family:'Jost', sans-serif; color:#ffffff; width:711px; left:312px; top:438px; -webkit-background-clip:border-box;"
                class="ls-l ls-hide-tablet ls-hide-phone ls-text-layer"
                data-ls="offsetyin:100; delayin:500; easingin:easeOutQuint; offsetyout:100; easingout:easeOutQuint;">
                {!! $slider['description'] ?? 'Montessori Is A Nurturing And Holistic Approach To Learning' !!}
            </p>
            <div style="font-size:30px; color:#000; stroke:#000; stroke-width:0px; text-align:center; font-style:normal; text-decoration:none; text-transform:none; font-weight:400; letter-spacing:0px; background-position:0% 0%; background-repeat:no-repeat; background-clip:border-box; overflow:visible; left:100%; top:494px; font-family:'Fredoka', sans-serif; width:711px; margin-left:-877px; -webkit-background-clip:border-box;"
                class="ls-l ls-hide-tablet ls-hide-phone ls-html-layer"
                data-ls="offsetyin:100; delayin:700; easingin:easeOutQuint; offsetyout:100; easingout:easeOutQuint;">
                <a href="{{ $slider['button_link'] ?? route('website.contact') }}" class="vs-btn">
                    {{ $slider['button_text'] }}
                </a>
            </div>

        
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
<!-- Hero Area end -->


<!-- About Area -->
@if(isset($about_section) && $about_section)
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row gx-70 align-items-center">
            <div class="col-lg-6">
                <div class="img-box1">
                    <div class="vs-circle"></div>
                    @if(isset($about_section['image_1']) && $about_section['image_1'])
                        <div class="img-1 mega-hover"><img src="{{ $about_section['image_1'] }}" alt="About"></div>
                    @endif
                    @if(isset($about_section['image_2']) && $about_section['image_2'])
                        <div class="img-2 mega-hover"><img src="{{ $about_section['image_2'] }}" alt="About"></div>
                    @endif
                    @if(isset($about_section['image_3']) && $about_section['image_3'])
                        <div class="img-3 mega-hover"><img src="{{ $about_section['image_3'] }}" alt="About"></div>
                    @endif
                    @if(isset($about_section['image_4']) && $about_section['image_4'])
                        <div class="img-4 mega-hover"><img src="{{ $about_section['image_4'] }}" alt="About"></div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-start">
                <span class="sec-subtitle">{{ $about_section['title'] ?? 'About Our School' }}</span>
                <h2 class="sec-title">{{ $about_section['heading'] ?? 'Your Child Will Take The Lead Learning' }}</h2>
                <p class="sec-text pe-xl-5 mb-4 pb-xl-3">{{ $about_section['paragraph'] ?? 'We are constantly expanding the range of services offered, taking care of children of all ages.' }}</p>
                @if($about_section['button_text'])
                    <a href="{{ $about_section['button_link'] ?? route('website.about') }}" class="vs-btn">{{ $about_section['button_text'] }}</a>
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
        <div class="row vs-carousel" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-sm-slide-show="2" data-xs-slide-show="2">
            @foreach($features as $feature)
            <div class="service-style1 col-xl-3">
                <div class="service-body">
                    @if($feature['image'])
                        <div class="service-img"><a href="#"><img style="min-height:350px;" src="{{ $feature['image'] }}" alt="{{ $feature['title'] }}"></a></div>
                    @endif
                    <div class="service-content">
                        @if($feature['icon'])
                            <div class="service-icon"><img src="{{url('/')}}/selected/assets/img/icon/sr-1-2.svg" alt="icon"></div>
                        @endif
                        <h3 class="service-title"><a href="#">{{ $feature['title'] }}</a></h3>
                        <!-- <p class="service-text">{{ $feature['paragraph'] }}</p>
                        <div class="service-bottom">
                            <a href="{{ route('website.about') }}" class="service-btn">Learn More</a>
                        </div> -->
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class=" space-extra-bottom">
            <div class="container ">
                <div class="row justify-content-between text-center text-md-start">
                    <div class="col-md-auto">
                        <div class="title-area">
                            <span class="sec-subtitle">choose your own grade level</span>
                            <h2 class="sec-title">Smarty Programs</h2>
                        </div>
                    </div>
                    <div class="col-md-auto align-self-end">
                        <div class="sec-btns">
                            <button class="icon-btn" data-slick-prev=".catslider1"><i
                                    class="far fa-arrow-left"></i></button>
                            <button class="icon-btn" data-slick-next=".catslider1"><i
                                    class="far fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row vs-carousel gx-15 catslider1" data-slide-show="5" data-lg-slide-show="4"
                    data-md-slide-show="3" data-sm-slide-show="2" data-xs-slide-show="2">
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">👶</span>
                                <span class="grade-name">k</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">Day Care</a></h3>
                            <p class="category-label">( 1.5 - 3 Years )</p>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">😅</span>
                                <span class="grade-name">k</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">Playgroup</a></h3>
                            <p class="category-label">( 2 - 3 Years )</p>
                        </div>
                    </div>
                    <!--  -->
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">😅</span>
                                <span class="grade-name">k</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">PP1</a></h3>
                            <p class="category-label">( 2 - 3 Years )</p>
                        </div>
                    </div>
                    <!--  -->
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">😅</span>
                                <span class="grade-name">k</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">PP2</a></h3>
                            <p class="category-label">( 2 - 3 Years )</p>
                        </div>
                    </div>
                    <!--  -->
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">Grade</span>
                                <span class="grade-name">1</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">Grade 1</a></h3>
                            <p class="category-label">( 4 - 5 Years )</p>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">Grade</span>
                                <span class="grade-name">2</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">Grade 2</a></h3>
                            <p class="category-label">( 6 - 8 Years )</p>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">Grade</span>
                                <span class="grade-name">3</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">Grade 3</a></h3>
                            <p class="category-label">( 8 - 9 Years )</p>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">Grade</span>
                                <span class="grade-name">4</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">Grade 4</a></h3>
                            <p class="category-label">( 10 - 11 Years )</p>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">Grade</span>
                                <span class="grade-name">5</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">Grade 5</a></h3>
                            <p class="category-label">( 12 - 13 Years )</p>
                        </div>
                    </div>
                    <!--  -->
                    <div class="col-xl-3">
                        <div class="category-style1">
                            <div class="category-bg1"></div>
                            <div class="category-bg2"></div>
                            <div class="category-bg3"></div>
                            <div class="category-grade">
                                <span class="grade-label">Grade</span>
                                <span class="grade-name">6</span>
                            </div>
                            <h3 class="category-name h4"><a href="class.html" class="text-inherit">Grade 6</a></h3>
                            <p class="category-label">( 16 - 17 Years )</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<!-- Programs/Classes Section -->
@if(isset($programs_section) && $programs_section)
<!-- <section class="space-extra-bottom space-extra-top pt-50" data-bg-src="{{ asset('selected/assets/img/bg/bg-h-1-1.jpg') }}">
    <div class="container">
        <div class="row justify-content-between text-center text-md-start">
            <div class="col-md-auto">
                <div class="title-area">
                    <span class="sec-subtitle">{{ $programs_section['title'] ?? 'Choose Your Own Grade Level' }}</span>
                    <h2 class="sec-title">{{ $programs_section['heading'] ?? 'Smarty Programs' }}</h2>
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
</section> -->
@endif

<!-- Session Times -->
@if(isset($session_times['section']) && $session_times['section'])
<section class="space-extra" data-bg-src="{{ asset('selected/assets/img/about/background.jpg') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-10 col-xxl-8">
                <div class="table-style1">
                    <div class="table-icon"><i class="fal fa-alarm-clock"></i></div>
                    <h2 class="sec-title">{{ $session_times['section']['title'] ?? 'Session Times' }}</h2>
                    <p class="sec-text">{{ $session_times['section']['paragraph'] ?? 'We provide full day care from 8.30am to 3.30pm for children aged 18 months to 5 years.' }}</p>
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
<section class="space-extra-bottom space-extra-top pt-50">
    <div class="container">
        <div class="row gx-80">
            <div class="col-lg-6 pb-3 pb-xl-0 d-none-mobile">
                <div class="img-box3">
                    <div class="img-1 mega-hover">
                        <img style="min-height:768px; object-fit: cover;" src="{{ asset('selected/assets/img/about/bg.jpg') }}" alt="FAQ">
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

