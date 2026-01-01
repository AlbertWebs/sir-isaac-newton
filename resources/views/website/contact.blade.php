@extends('layouts.website')

@section('title', 'Contact Us')
@section('description', 'Get in touch with Sir Isaac Newton School. We are here to answer your questions and help with enrollment.')

@section('content')
<!-- Breadcrumb -->
@if(isset($breadcrumb) && $breadcrumb)
<section class="breadcumb-wrapper" data-bg-src="{{ $breadcrumb['background_image'] ?? asset('selected/assets/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $breadcrumb['title'] ?? 'Contact Us' }}</h1>
            <p class="breadcumb-text">{{ $breadcrumb['paragraph'] ?? 'Get in touch with us' }}</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('website.homepage') }}">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

<section class=" space-top space-extra-bottom ">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="info-style2">
                    <div class="info-icon"><img src="{{ asset('selected/assets/img/icon/c-b-1-1.svg') }}" alt="icon"></div>
                    <h3 class="info-title">Phone No</h3>
                    <p class="info-text"><a href="tel:{{ $phone ?? '#' }}" class="text-inherit">{{ $phone ?? 'N/A' }}</a></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-style2">
                    <div class="info-icon"><img src="{{ asset('selected/assets/img/icon/c-b-1-2.svg') }}" alt="icon"></div>
                    <h3 class="info-title">Monday to Friday</h3>
                    <p class="info-text">8.30am – 02.00pm</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-style2">
                    <div class="info-icon"><img src="{{ asset('selected/assets/img/icon/c-b-1-3.svg') }}" alt="icon"></div>
                    <h3 class="info-title">Email Address</h3>
                    <p class="info-text"><a href="mailto:{{ $email ?? '#' }}" class="text-inherit">{{ $email ?? 'N/A' }}</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class=" space-extra-bottom ">
    <div class="container">
        <div class="row flex-row-reverse gx-60 justify-content-between">
            <div class="col-xl-auto">
                <img src="{{ asset('selected/assets/img/about/con-2-1.png') }}" alt="girl" class="w-100">
            </div>
            <div class="col-xl col-xxl-6 align-self-center">
                <div class="title-area">
                    <span class="sec-subtitle">Have Any questions? so plese</span>
                    <h2 class="sec-title">Feel Free to Contact!</h2>
                </div>
                
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

                <form action="{{ route('website.contact.submit') }}" method="POST" class="form-style3 layout2">
                    @csrf
                    <div class="row justify-content-between">
                        <div class="col-md-6 form-group">
                            <label>First Name <span class="required">(Required)</span></label>
                            <input name="name" type="text" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name <span class="required">(Required)</span></label>
                            <input name="last_name" type="text" value="{{ old('last_name') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email Address <span class="required">(Required)</span></label>
                            <input name="email" type="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phone Number <span class="required">(Required)</span></label>
                            <input name="phone" type="tel" value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-12 form-group">
                            <label>Message <span class="required">(Required)</span></label>
                            <textarea name="message" cols="30" rows="10"
                                placeholder="Type your message" required>{{ old('message') }}</textarea>
                        </div>
                        <div class="col-auto form-group">
                            <button class="vs-btn" type="submit">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class=" space-bottom">
    <div class="container">
        <div class="title-area">
            <h2 class="mt-n2">How To Find Us</h2>
        </div>
        <div class="map-style1">
            @if($google_map_embed_url ?? null)
            <iframe
                    src=" {!! $google_map_embed_url !!}"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            @else
                <iframe
                    src=" {!! $google_map_embed_url !!}"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            @endif
        </div>
    </div>
</section>
@endsection

