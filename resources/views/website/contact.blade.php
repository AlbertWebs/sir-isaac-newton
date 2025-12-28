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
        </div>
    </div>
</section>
@endif

<!-- Contact Section -->
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row gx-60">
            <div class="col-lg-6">
                <div class="title-area">
                    <h2 class="sec-title">Get In Touch</h2>
                    <p class="sec-text">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                </div>
                <div class="contact-info">
                    @if($address ?? null)
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Address</h4>
                                <p>{{ $address }}</p>
                            </div>
                        </div>
                    @endif
                    @if($phone ?? null)
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h4>Phone</h4>
                                <p><a href="tel:{{ $phone }}">{{ $phone }}</a></p>
                            </div>
                        </div>
                    @endif
                    @if($email ?? null)
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email</h4>
                                <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <form action="{{ url('/api/website/contact/submit') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="vs-btn">Send Message</button>
                </form>
            </div>
        </div>
        @if($google_map_embed_url ?? null)
        <div class="row mt-5">
            <div class="col-12">
                <div class="map-wrapper">
                    {!! $google_map_embed_url !!}
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

