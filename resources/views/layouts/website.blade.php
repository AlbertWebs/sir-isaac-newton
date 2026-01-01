<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>@yield('title', 'Sir Isaac Newton School') - {{ config('app.name', 'School Management') }}</title>
    
    @section('meta')
    <meta name="description" content="@yield('description', 'Sir Isaac Newton School - Creating World Changers')">
    <meta name="keywords" content="@yield('keywords', 'school, education, kindergarten, primary, Sir Isaac Newton')">
    <meta name="robots" content="INDEX,FOLLOW">
    @show
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Sir Isaac Newton School')">
    <meta property="og:description" content="@yield('description', 'Sir Isaac Newton School - Creating World Changers')">
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('selected/assets/img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('selected/assets/img/favicon.ico') }}" type="image/x-icon">
    
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
                <a href="{{ route('website.homepage') }}"><img src="{{ asset('selected/assets/img/logo.svg') }}" alt="Sir Isaac Newton School"></a>
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
                    <div class="footer-logo"><img src="{{ asset('selected/assets/img/logo.svg') }}" alt="Sir Isaac Newton School"></div>
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
                    <div class="col-lg-auto text-center">
                        <div class="header-links style2 style-white">
                            <ul>
                                @if($contactInfo || $schoolInfo)
                                    <li>
                                        <i class="fas fa-envelope"></i>Email: 
                                        <a href="mailto:{{ $contactInfo->email ?? $schoolInfo->email ?? 'info@sirisaacnewton.ac.ke' }}">
                                            {{ $contactInfo->email ?? $schoolInfo->email ?? 'info@sirisaacnewton.ac.ke' }}
                                        </a>
                                    </li>
                                    <li>
                                        <i class="fas fa-mobile-alt"></i>Phone: 
                                        <a href="tel:{{ $contactInfo->phone ?? $schoolInfo->phone ?? '' }}">
                                            {{ $contactInfo->phone ?? $schoolInfo->phone ?? '' }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
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
                                    <img src="{{ asset('selected/assets/img/logo.svg') }}" alt="Sir Isaac Newton School">
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
                            <img src="{{ asset('selected/assets/img/logo-2.svg') }}" alt="Sir Isaac Newton School">
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

