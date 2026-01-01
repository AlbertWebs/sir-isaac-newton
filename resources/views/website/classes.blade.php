@extends('layouts.website')

@section('title', 'Classes')
@section('description', 'Explore our classes and programs at Sir Isaac Newton School - From PP1 to Grade 6.')

@section('content')
<!-- Breadcrumb -->
@if(isset($breadcrumb) && $breadcrumb)
<section class="breadcumb-wrapper" data-bg-src="{{ $breadcrumb['background_image'] ?? asset('selected/assets/img/breadcumb/breadcumb-bg.jpg') }}">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">{{ $breadcrumb['title'] ?? 'Classes' }}</h1>
            <p class="breadcumb-text">{{ $breadcrumb['paragraph'] ?? 'Explore our classes' }}</p>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('website.homepage') }}">Home</a></li>
                    <li>Classes</li>
                </ul>
            </div>
        </div>
    </div>
    
</section>
@endif

<!-- Classes Section -->
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="title-area text-center">
            <h2 class="sec-title text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 animate-pulse">🎓 Our Amazing Classes 🎓</h2>
            <p class="sec-text text-lg text-gray-600">Discover the perfect class for your little genius! 🚀</p>
        </div>
        <div class="row gx-50 gy-gx">
            @forelse($classes ?? [] as $class)
            <div class="col-md-6 col-lg-4">
                <div class="class-card bg-gradient-to-br from-white via-blue-50 to-purple-50 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:scale-105 hover:rotate-1 border-4 border-transparent hover:border-yellow-300 min-h-[650px] flex flex-col">
                    <div class="p-8 flex-grow flex flex-col">
                        <div class="class-image mb-6 relative">
                            <img src="{{ $class['image'] ?? 'https://via.placeholder.com/400x300?text=Class+Image' }}" alt="{{ $class['name'] }}" class="w-full h-56 object-cover rounded-xl shadow-md">
                            <div class="absolute top-2 right-2 bg-yellow-400 text-black px-2 py-1 rounded-full text-xs font-bold animate-bounce">⭐</div>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-3 text-center">{{ $class['name'] }} 🎉</h3>
                        <p class="text-base text-gray-600 mb-6 text-center italic" style="min-height:120px;">{{ $class['description'] ?? 'A fun and exciting learning adventure awaits!' }}</p>

                        <!-- <div class="grid grid-cols-2 gap-2 text-sm mb-6">
                            <div class="flex items-center text-gray-700 bg-blue-100 p-3 rounded-lg">
                                <i class="fas fa-users mr-2 text-blue-500"></i>
                                <span>Level: {{ ucfirst($class['level']) }} 🌟</span>
                            </div>
                            <div class="flex items-center text-gray-700 bg-green-100 p-3 rounded-lg">
                                <i class="fas fa-birthday-cake mr-2 text-green-500"></i>
                                <span>Age: {{ $class['age_range'] }} 🎂</span>
                            </div>
                            <div class="flex items-center text-gray-700 bg-purple-100 p-3 rounded-lg">
                                <i class="fas fa-tag mr-2 text-purple-500"></i>
                                <span>Code: {{ $class['code'] }} 🏷️</span>
                            </div>
                            <div class="flex items-center text-gray-700 bg-orange-100 p-3 rounded-lg">
                                <i class="fas fa-calendar mr-2 text-orange-500"></i>
                                <span>Year: {{ $class['academic_year'] }} 📅</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-6 bg-yellow-100 p-4 rounded-xl">
                            <p class="text-xl font-bold text-blue-600">
                                @if($class['price'] ?? null)
                                    💰 KES {{ number_format($class['price'], 2) }} <span class="text-sm font-normal text-gray-500">/ term</span>
                                @else
                                    Price: N/A 😊
                                @endif
                            </p>
                            <span class="text-sm font-semibold text-gray-600 bg-white px-3 py-1 rounded-full shadow">
                                Available: {{ ($class['capacity'] ?? 0) - ($class['current_enrollment'] ?? 0) }} Seats 🪑
                            </span>
                        </div> -->

                        <div class="text-center mt-auto p-3">
                            <a href="{{ route('website.enroll') }}" class="vs-btn" style="background-color: #4F46E5;">
                                Enroll Now! 
                            </a>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No classes available at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

