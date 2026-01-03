<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    @php
        $defaultTitle = $schoolInfoForLayout->meta_title ?? ('Sir Isaac Newton School - ' . config('app.name') . ' | Best Schools in Kisumu');
        $defaultDescription = $schoolInfoForLayout->meta_description ?? 'Sir Isaac Newton School - Creating World Changers. Discover the best education in Kisumu. Quality learning from kindergarten to primary.';
        $defaultKeywords = $schoolInfoForLayout->meta_keywords ?? 'school, education, kindergarten, primary, Sir Isaac Newton, Kisumu, best schools in Kisumu, CBC curriculum, quality education';
        $defaultOgImage = (isset($schoolInfoForLayout->logo) && $schoolInfoForLayout->logo) ? asset('storage/' . $schoolInfoForLayout->logo) : asset('selected/assets/img/logo.svg');
        
        // Prepare Social Links for Schema
        $socialLinks = [];
        if (isset($schoolInfoForLayout->social_media) && is_array($schoolInfoForLayout->social_media)) {
            foreach(['facebook', 'twitter', 'linkedin', 'youtube'] as $platform) {
                if (!empty($schoolInfoForLayout->social_media[$platform])) {
                    $socialLinks[] = $schoolInfoForLayout->social_media[$platform];
                }
            }
        }
        $socialLinks[] = url('/');
    @endphp

    <title>{{$defaultTitle}}</title>

    <meta name="description" content="@yield('description', $defaultDescription)">
    <meta name="keywords" content="@yield('keywords', $defaultKeywords)">
    <meta name="robots" content="INDEX,FOLLOW">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', $defaultTitle)">
    <meta property="og:description" content="@yield('og_description', $defaultDescription)">
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('twitter_title', $defaultTitle)">
    <meta name="twitter:description" content="@yield('twitter_description', $defaultDescription)">
    <meta name="twitter:image" content="@yield('twitter_image', $defaultOgImage)">

    {{-- Schema.org Markup --}}
    @verbatim
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "{{ url('/') }}#organization",
          "name": "{{ $schoolInfoForLayout->name ?? 'Sir Isaac Newton School' }}",
          "url": "{{ url('/') }}",
          "logo": "{{ $defaultOgImage }}",
          "description": "{{ $defaultDescription }}",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $schoolInfoForLayout->address ?? '123 School Lane' }}",
            "addressLocality": "Kisumu",
            "addressRegion": "Kisumu County",
            "postalCode": "40100",
            "addressCountry": "KE"
          },
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "{{ $schoolInfoForLayout->phone ?? '+2547XXXXXXXX' }}",
            "contactType": "Customer Service",
            "email": "{{ $schoolInfoForLayout->email ?? 'info@sirisaacnewton.ac.ke' }}"
          },
          "sameAs": {!! json_encode($socialLinks) !!}
        },
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}#website",
          "url": "{{ url('/') }}",
          "name": "{{ $schoolInfoForLayout->name ?? 'Sir Isaac Newton School' }}",
          "publisher": {
            "@id": "{{ url('/') }}#organization"
          },
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/search') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        }
      ]
    }
    </script>
    @endverbatim
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ $defaultOgImage }}" type="image/x-icon">
    <link rel="icon" href="{{ $defaultOgImage }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Jost:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('selected/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('selected/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('selected/assets/css/layerslider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('selected/assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('selected/assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('selected/assets/css/style.css') }}">
    <style>
        .image-logo {
            max-width: 150px !important;
            max-height: 150px !important;
        }
        @media screen and (max-width: 768px) {
            .image-logo {
                max-width: 80px !important;
                max-height: 80px !important;
            }
            .ls-hide-phone{
                display: none !important;
            }
        }
        @media (max-width: 767px) {
            .vs-menu-area {
                padding: 15px; /* Reduce overall padding of the mobile menu header */
            }
            .vs-menu-area .mobile-logo img {
                max-width: 80px !important; /* Reduce logo size in mobile menu */
                max-height: 80px !important;
            }
            .top-menu-contact-info {
                font-size: 0.85em; /* Keep previous font size, or adjust if needed */
                margin-right: 15px; /* Add space between items */
                white-space: nowrap;
            }
            .top-menu-contact-info a {
                display: none; /* Hide text, only show icon */
            }
            .top-menu-contact-info i {
                margin-right: 0; /* Remove margin from icon if text is hidden */
                font-size: 1.2em; /* Increase icon size for better visibility */
            }
            .top-menu-contact-info:last-child {
                margin-right: 0; /* No margin on the last item */
            }
            .header-social.mt-2 {
                margin-top: 5px !important; /* Reduce top margin */
                gap: 8px !important; /* Adjust gap between icons */
            }
            .header-social.mt-2 a {
                font-size: 1em !important; /* Adjust icon size */
                padding: 3px !important; /* Adjust padding around icons */
            }
            
            /* Why Choose Us / Our Features section mobile optimization */
            .service-style1 .service-body {
                position: relative; /* Enable absolute positioning for children */
                overflow: hidden; /* Hide overflowing content */
                height: 280px; /* Fixed height for cards */
                min-height: 280px; /* Ensure minimum height */
            }
            .service-style1 .service-img {
                height: 100%; /* Ensure image container fills the body */
            }
            .service-style1 .service-img img {
                object-fit: cover; /* Prevent image stretching */
                height: 100%; /* Ensure image fills container */
                width: 100%; /* Ensure image fills container */
            }
            .service-style1 .service-content {
                position: absolute; /* Position content at the bottom */
                bottom: 0;
                left: 0;
                width: 100%;
                background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent dark background */
                padding: 10px;
                color: #ffffff; /* White text for readability */
                text-align: center; /* Center text */
            }
            .service-style1 .service-title {
                font-size: 1.1em; /* Reduced font size for title */
                margin-bottom: 5px; /* Add some space below title */
            }
            .service-style1 .service-title a {
                color: #ffffff !important; /* Ensure title text is white */
            }
            .service-style1 .service-icon {
                display: none; /* Hide icons on mobile */
            }
            .d-none-mobile{
                display: none !important;
            }
        }
        @media (min-width: 992px) {
            .main-menu ul li a {
                padding: 15px 15px; /* Adjust padding as needed to reduce height */
            }
        }
        @media (max-width: 575px) {
                .header-layout1 .header-top {
                    padding: 0px 0px;
                }
            }

        /* Mobile Bottom Nav Styles */
        .vs-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #ffffff; /* White background */
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow at the top */
            z-index: 1000;
            display: none; /* Hidden by default, shown only on mobile */
            padding: 5px 0; /* Reduced padding */
        }

        @media (max-width: 991px) {
            .vs-bottom-nav {
                display: block; /* Show on mobile devices */
            }
        }

        .vs-bottom-nav-inner {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100%;
        }

        .vs-bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #333333; /* Dark text for links */
            font-size: 0.7em; /* Reduced font size */
            padding: 3px; /* Reduced padding */
            transition: color 0.3s ease;
            flex-grow: 1; /* Distribute space evenly */
            border-top: 2px solid #f0f0f0; /* Subtle top border */
            border-right: 1px solid #f0f0f0; /* Separator between links */
        }

        .vs-bottom-nav-item:last-child {
            border-right: none; /* No right border on the last item */
        }

        .vs-bottom-nav-item i {
            font-size: 1.2em; /* Reduced icon size */
            margin-bottom: 3px; /* Reduced margin */
        }

        .vs-bottom-nav-item.active,
        .vs-bottom-nav-item:hover {
            color: #cd9933; /* Active/hover color, match theme */
        }

        .vs-bottom-nav-item-center {
            transform: translateY(-15px); /* Slightly less lift */
            background-color: #cd9933; /* Highlight color for center button */
            color: #ffffff !important; /* White text for center button */
            border-radius: 50%; /* Circular shape */
            padding: 10px; /* Reduced padding */
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.2); /* Stronger shadow */
        }
        .vs-bottom-nav-item-center i,
        .vs-bottom-nav-item-center span {
            color: #ffffff !important; /* Ensure icon and text are white */
        }
        .vs-bottom-nav-item-center:hover {
            background-color: #e65c00; /* Darker hover for center button */
        }

        /* Desktop Social Media Icons Styling */
        @media (min-width: 992px) {
            .header-social {
                display: flex; /* Use flexbox for alignment */
                align-items: center;
                gap: 10px; /* Space between icons */
            }

            .header-social.style-white a {
                font-size: 0.9em; /* Adjusted icon size for better fit */
                color: #ffffff !important; /* Force white color */
                font-weight: 700; /* Make icons bolder */
                transition: all 0.3s ease; /* Smooth transition for all properties */
                display: flex; /* Use flexbox for centering */
                justify-content: center;
                align-items: center;
                width: 35px; /* Slightly increase size */
                height: 35px; /* Slightly increase size */
                border-radius: 50%; /* Make them circular */
                background-color: transparent !important; /* Transparent background initially */
                border: 1px solid #cd9933 !important; /* Theme color border */
                box-shadow: 0 0 5px rgba(255, 255, 255, 0.2); /* Subtle initial shadow */
            }

            .header-social.style-white a:hover {
                color: #ffffff !important; /* White icon on hover */
                background-color: #cd9933 !important; /* Solid theme color background on hover */
                transform: translateY(-2px); /* Slight lift effect on hover */
                border-color: #cd9933 !important; /* Keep theme color border on hover */
                box-shadow: 0 0 15px rgba(205, 153, 51, 0.8); /* More prominent shadow on hover */
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Preloader -->
    <div class="preloader">
        <button class="vs-btn preloaderCls">Cancel Preloader</button>
        <div class="preloader-inner">
            <div class="loader"></div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="vs-menu-wrapper">
        <div class="vs-menu-area text-center">
            <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="{{ route('website.homepage') }}">
                    @if(isset($schoolInfoForLayout->logo) && $schoolInfoForLayout->logo)
                        <img style="max-width: 100px !important; max-height: 100px !important;" src="{{ asset('storage/' . $schoolInfoForLayout->logo) }}" alt="Sir Isaac Newton School Mobile Logo">
                    @else
                        <img src="{{ asset('selected/assets/img/logo.svg') }}" alt="Sir Isaac Newton School Mobile Logo">
                    @endif
                </a>
            </div>
            <div class="vs-mobile-menu">
                <ul>
                    <li class="{{ request()->routeIs('website.homepage') ? 'active' : '' }}"><a href="{{ route('website.homepage') }}">Home</a></li>
                    <li class="{{ request()->routeIs('website.about') ? 'active' : '' }}"><a href="{{ route('website.about') }}">About Us</a></li>
                    <li class="{{ request()->routeIs('website.classes') ? 'active' : '' }}"><a href="{{ route('website.classes') }}">Classes</a></li>
                    <li class="{{ request()->routeIs('website.gallery') ? 'active' : '' }}"><a href="{{ route('website.gallery') }}">Gallery</a></li>
                    <li class="{{ request()->routeIs('website.clubs') ? 'active' : '' }}"><a href="{{ route('website.clubs') }}">Clubs</a></li>
                    <li class="{{ request()->routeIs('website.contact') ? 'active' : '' }}"><a href="{{ route('website.contact') }}">Contact Us</a></li>
                    <li class="{{ request()->routeIs('website.enroll') ? 'active' : '' }}"><a href="{{ route('website.enroll') }}">Enroll</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Sidemenu -->
    <div class="sidemenu-wrapper d-none d-lg-block">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget">
                <div class="widget-about">
                    <div class="footer-logo">
                        <a href="{{ route('website.homepage') }}">
                            @if(isset($schoolInfoForLayout->logo) && $schoolInfoForLayout->logo)
                                <img style="max-width: 150px !important; max-height: 150px !important;" src="{{ asset('storage/' . $schoolInfoForLayout->logo) }}" alt="Sir Isaac Newton School Logo">
                            @else
                                <img src="{{ asset('selected/assets/img/logo.svg') }}" alt="Sir Isaac Newton School Logo">
                            @endif
                        </a>
                    </div>
                    <p class="mb-0">We are constantly expanding the range of services offered, taking care of children of all ages.</p>
                </div>
            </div>
            @php
                $contactInfo = \App\Models\ContactInformation::first();
                $schoolInfo = \App\Models\SchoolInformation::where('status', 'active')->first();
            @endphp
            <div class="widget">
                <h3 class="widget_title">Get In Touch</h3>
                <div>
                    <p class="footer-text">Monday to Friday: <span class="time">8.30am – 02.00pm</span></p>
                    <p class="footer-text">Saturday, Sunday: <span class="time">Close</span></p>
                    @if($contactInfo || $schoolInfo)
                        <p class="footer-info">
                            <i class="fal fa-envelope"></i>Email: 
                            <a href="mailto:{{ $contactInfo->email ?? $schoolInfo->email ?? 'info@sirisaacnewton.ac.ke' }}">
                                {{ $contactInfo->email ?? $schoolInfo->email ?? 'info@sirisaacnewton.ac.ke' }}
                            </a>
                        </p>
                        <p class="footer-info">
                            <i class="fas fa-mobile-alt"></i>Phone: 
                            <a href="tel:{{ $contactInfo->phone ?? $schoolInfo->phone ?? '' }}">
                                {{ $contactInfo->phone ?? $schoolInfo->phone ?? '' }}
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Popup Search Box -->
    <div class="popup-search-box d-none d-lg-block">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" class="border-theme" placeholder="What are you looking for">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>

    <!-- Header Area -->
    <header class="vs-header header-layout1">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-links style-white">
                            <ul>
                                <li><a href="{{ route('website.enroll') }}"><i class="far fa-user-circle"></i>Login & Register</a></li>
                                <li><a href="#" class="searchBoxTggler"><i class="far fa-search"></i>Search Keyword</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-social style-white">
                            @if(isset($schoolInfoForLayout->social_media) && is_array($schoolInfoForLayout->social_media))
                                @if(!empty($schoolInfoForLayout->social_media['facebook']))
                                    <a href="{{ $schoolInfoForLayout->social_media['facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if(!empty($schoolInfoForLayout->social_media['twitter']))
                                    <a href="{{ $schoolInfoForLayout->social_media['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                @endif
                                @if(!empty($schoolInfoForLayout->social_media['linkedin']))
                                    <a href="{{ $schoolInfoForLayout->social_media['linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if(!empty($schoolInfoForLayout->social_media['instagram']))
                                    <a href="{{ $schoolInfoForLayout->social_media['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                @endif
                                @if(!empty($schoolInfoForLayout->social_media['whatsapp']))
                                    <a href="{{ $schoolInfoForLayout->social_media['whatsapp'] }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-auto text-center d-none">
                        <div class="header-links style2 style-white">
                            <ul class="d-flex flex-wrap justify-content-center justify-content-lg-end">
                                @if($contactInfo || $schoolInfo)
                                    <li class="top-menu-contact-info">
                                        <i class="fas fa-envelope"></i>Email: 
                                        <a href="mailto:{{ $contactInfo->email ?? $schoolInfo->email ?? 'info@sirisaacnewton.ac.ke' }}">
                                            {{ $contactInfo->email ?? $schoolInfo->email ?? 'info@sirisaacnewton.ac.ke' }}
                                        </a>
                                    </li>
                                    <li class="top-menu-contact-info">
                                        <i class="fas fa-mobile-alt"></i><a href="tel:{{ $contactInfo->phone ?? $schoolInfo->phone ?? '' }}">{{ $contactInfo->phone ?? $schoolInfo->phone ?? '' }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                  
                    <div class="col-lg-auto text-center d-lg-none d-block">
                                
                                @if(isset($schoolInfoForLayout->social_media) && is_array($schoolInfoForLayout->social_media))
                                    @if(!empty($schoolInfoForLayout->social_media['facebook']))
                                    @endif
                                    @if(!empty($schoolInfoForLayout->social_media['twitter']))
                                        <a style="background-color: #transparent; width:20px; height:20px; padding:1px;" href="{{ $schoolInfoForLayout->social_media['twitter'] }}" target="_blank"><i class="fab fa-twitter fa-lg"></i></a>
                                    @endif
                                    @if(!empty($schoolInfoForLayout->social_media['linkedin']))
                                        <a style="background-color: #transparent; width:20px; height:20px; padding:1px;" href="{{ $schoolInfoForLayout->social_media['linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in fa-lg"></i></a>
                                    @endif
                                    @if(!empty($schoolInfoForLayout->social_media['instagram']))
                                        <a style="background-color: #transparent; width:20px; height:20px; padding:1px;" href="{{ $schoolInfoForLayout->social_media['instagram'] }}" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
                                    @endif
                                    @if(!empty($schoolInfoForLayout->social_media['whatsapp']))
                                        <a style="background-color: #transparent; width:20px; height:20px; padding:1px;" href="{{ $schoolInfoForLayout->social_media['whatsapp'] }}" target="_blank"><i class="fab fa-whatsapp fa-lg"></i></a>
                                    @endif
                                    @if(!empty($schoolInfoForLayout->social_media['youtube']))
                                        <a style="background-color: #transparent; width:20px; height:20px; padding:1px;" href="{{ $schoolInfoForLayout->social_media['youtube'] }}" target="_blank"><i class="fab fa-youtube fa-lg"></i></a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrap">
            <div class="sticky-active">
                <div class="container">
                    <div class="row gx-3 align-items-center justify-content-between">
                        <div class="col-8 col-sm-auto">
                            <div class="header-logo">
                                <a href="{{ route('website.homepage') }}">
                                    @if(isset($schoolInfoForLayout->logo) && $schoolInfoForLayout->logo)
                                        <img class="image-logo" src="{{ asset('storage/' . $schoolInfoForLayout->logo) }}" alt="Sir Isaac Newton School Logo">
                                    @else
                                        <img class="image-logo" src="{{ asset('selected/assets/img/logo.svg') }}" alt="Sir Isaac Newton School Logo">
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="col text-end text-lg-center">
                            <nav class="main-menu menu-style1 d-none d-lg-block">
                                <ul>
                                    <li class="{{ request()->routeIs('website.homepage') ? 'active' : '' }}"><a href="{{ route('website.homepage') }}">Home</a></li>
                                    <li class="{{ request()->routeIs('website.about') ? 'active' : '' }}"><a href="{{ route('website.about') }}">About Us</a></li>
                                    <li class="{{ request()->routeIs('website.classes') ? 'active' : '' }}"><a href="{{ route('website.classes') }}">Classes</a></li>
                                    <li class="{{ request()->routeIs('website.gallery') ? 'active' : '' }}"><a href="{{ route('website.gallery') }}">Gallery</a></li>
                                    <li class="{{ request()->routeIs('website.clubs') ? 'active' : '' }}"><a href="{{ route('website.clubs') }}">Clubs</a></li>
                                    <li class="{{ request()->routeIs('website.contact') ? 'active' : '' }}"><a href="{{ route('website.contact') }}">Contact</a></li>
                                </ul>
                            </nav>
                            <button class="vs-menu-toggle d-inline-block d-lg-none"><i class="fal fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <div class="header-icons">
                                <button class="simple-icon sideMenuToggler"><i class="far fa-bars"></i></button>
                            </div>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <a href="{{ route('website.enroll') }}" class="vs-btn">Apply Today</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer Area -->
    <footer class="footer-wrapper footer-layout1" data-bg-src="{{ asset('selected/assets/img/bg/footer-bg-1-1.png') }}">
        <div class="footer-top">
            <div class="container">
                <div class="row gx-60 gy-4 text-center text-lg-start justify-content-between align-items-center">
                    <div class="col-lg">
                        <a href="{{ route('website.homepage') }}">
                            @if(isset($schoolInfoForLayout->logo) && $schoolInfoForLayout->logo)
                                <img style="max-height: 100px;" src="{{ asset('storage/' . $schoolInfoForLayout->logo) }}" alt="Sir Isaac Newton School Logo">
                            @else
                                <img src="{{ asset('selected/assets/img/logo-2.svg') }}" alt="Sir Isaac Newton School">
                            @endif
                        </a>
                    </div>
                    <div class="col-lg-auto">
                        <h3 class="h4 mb-0 text-white">
                            <img src="{{ asset('selected/assets/img/icon/check-list.svg') }}" alt="icon" class="me-2">
                            Enrol your child in a Session now!
                        </h3>
                    </div>
                    <div class="col-lg-auto">
                        <a href="{{ route('website.enroll') }}" class="vs-btn">Start Registration</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-area">
            <div class="container">
                <div class="row justify-content-center gx-60">
                    <div class="col-lg-4">
                        <div class="widget footer-widget">
                            <div class="widget-about">
                                <h3 class="mt-n2">Giving your child the best start in life</h3>
                                @if($contactInfo || $schoolInfo)
                                    <p class="map-link">
                                        <img src="{{ asset('selected/assets/img/icon/map.svg') }}" alt="svg">
                                        {{ $contactInfo->address ?? $schoolInfo->address ?? 'Sir Isaac Newton School' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Get In Touch</h3>
                            <div>
                                <p class="footer-text">Monday to Friday: <span class="time">8.30am – 02.00pm</span></p>
                                <p class="footer-text">Saturday, Sunday: <span class="time">Close</span></p>
                                @if($contactInfo || $schoolInfo)
                                    <p class="footer-info">
                                        <i class="fal fa-envelope"></i>Email: 
                                        <a href="mailto:{{ $contactInfo->email ?? $schoolInfo->email ?? 'info@sirisaacnewton.ac.ke' }}">
                                            {{ $contactInfo->email ?? $schoolInfo->email ?? 'info@sirisaacnewton.ac.ke' }}
                                        </a>
                                    </p>
                                    <p class="footer-info">
                                        <i class="fas fa-mobile-alt"></i>Phone: 
                                        <a href="tel:{{ $contactInfo->phone ?? $schoolInfo->phone ?? '' }}">
                                            {{ $contactInfo->phone ?? $schoolInfo->phone ?? '' }}
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Quick Links</h3>
                            <div class="menu-all-pages-container footer-menu">
                                <ul class="menu">
                                    <li class="{{ request()->routeIs('website.homepage') ? 'active' : '' }}"><a href="{{ route('website.homepage') }}">Home</a></li>
                                    <li class="{{ request()->routeIs('website.about') ? 'active' : '' }}"><a href="{{ route('website.about') }}">About Us</a></li>
                                    <li class="{{ request()->routeIs('website.classes') ? 'active' : '' }}"><a href="{{ route('website.classes') }}">Classes</a></li>
                                    <li class="{{ request()->routeIs('website.gallery') ? 'active' : '' }}"><a href="{{ route('website.gallery') }}">Gallery</a></li>
                                    <li class="{{ request()->routeIs('website.clubs') ? 'active' : '' }}"><a href="{{ route('website.clubs') }}">Clubs</a></li>
                                    <li class="{{ request()->routeIs('website.contact') ? 'active' : '' }}"><a href="{{ route('website.contact') }}">Contact Us</a></li>
                                    <li class="{{ request()->routeIs('website.enroll') ? 'active' : '' }}"><a href="{{ route('website.enroll') }}">Enroll</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row flex-row-reverse gy-3 justify-content-between align-items-center">
                    <div class="col-lg-auto">
                        <div class="footer-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-auto">
                        <p class="copyright-text">
                            Copyright &copy; {{ date('Y') }} <a href="{{ route('website.homepage') }}">Sir Isaac Newton School</a>. All Rights Reserved. | Powered By <a href="https://designekta.com" target="_blank">Designekta Studios</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Nav -->
    <div class="vs-bottom-nav d-block d-lg-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="vs-bottom-nav-inner">
                        <a href="{{ route('website.homepage') }}" class="vs-bottom-nav-item {{ request()->routeIs('website.homepage') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>
                        <a href="{{ route('website.classes') }}" class="vs-bottom-nav-item {{ request()->routeIs('website.classes') ? 'active' : '' }}">
                            <i class="fas fa-book-open"></i>
                            <span>Classes</span>
                        </a>
                        <a href="{{ route('website.enroll') }}" class="vs-bottom-nav-item vs-bottom-nav-item-center {{ request()->routeIs('website.enroll') ? 'active' : '' }}">
                            <i class="fas fa-user-plus"></i>
                            <span>Enroll</span>
                        </a>
                        <a href="{{ route('website.gallery') }}" class="vs-bottom-nav-item {{ request()->routeIs('website.gallery') ? 'active' : '' }}">
                            <i class="fas fa-images"></i>
                            <span>Gallery</span>
                        </a>
                        <a href="{{ route('website.contact') }}" class="vs-bottom-nav-item {{ request()->routeIs('website.contact') ? 'active' : '' }}">
                            <i class="fas fa-phone-alt"></i>
                            <span>Contact</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll To Top -->
    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

    <!-- JavaScript Files -->
    <script src="{{ asset('selected/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('selected/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('selected/assets/js/layerslider.utils.js') }}"></script>
    <script src="{{ asset('selected/assets/js/layerslider.transitions.js') }}"></script>
    <script src="{{ asset('selected/assets/js/layerslider.kreaturamedia.jquery.js') }}"></script>
    <script src="{{ asset('selected/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('selected/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('selected/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('selected/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('selected/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('selected/assets/js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>