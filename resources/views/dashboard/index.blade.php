<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kanaya Kost - Premium Boarding House</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar-hidden {
            transform: translateY(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .navbar-visible {
            transform: translateY(0);
            transition: transform 0.3s ease-in-out;
        }

        #nav-img {
            z-index: 999;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #8a7a1e 0%, #ebc725 100%);
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.03);
        }

        .navbar-hidden {
            transform: translateY(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .navbar-visible {
            transform: translateY(0);
            transition: transform 0.3s ease-in-out;
        }

        #nav-img {
            z-index: 999;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #8a5b1e 0%, #ebbd25 100%);
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.03);
        }

        .dropdown-menu {
            opacity: 0;
            z-index: 60 !important;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-badge {
            position: absolute;
            top: 5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }

        .message-sidebar {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            height: calc(100vh - 4rem);
            top: 4.5rem;
        }

        .message-sidebar.open {
            transform: translateX(0);
        }

        .chat-container {
            height: calc(100% - 120px);
        }

        #message-sidebar {
            z-index: 999;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <div id="navbar"
        class="fixed top-0 left-0 w-full bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg z-50 navbar-visible">
        <div x-data="messageComponent" class="container mx-auto px-6 py-4 flex justify-between items-center" >
            <div class="flex items-center space-x-2">
                <i class="fas fa-home text-2xl"></i>
                <h1 class="text-xl font-bold">KANAYA KOST</h1>
            </div>
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="#about" class="hover:text-amber-200 transition duration-300 font-medium">About</a>
                <a href="#facilities" class="hover:text-amber-200 transition duration-300 font-medium">Facilities</a>
                <a href="#location" class="hover:text-amber-200 transition duration-300 font-medium">Location</a>
                <a href="#contact" class="hover:text-amber-200 transition duration-300 font-medium">Contact</a>
                @auth
                    <!-- Notification Icon -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="p-2 rounded-full hover:bg-amber-600 transition duration-300 relative">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <!-- Notification Dropdown -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg py-1 z-50 dropdown-menu"
                            :class="{ 'show': open }">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-amber-100 p-2 rounded-full">
                                            <i class="fas fa-calendar-check text-amber-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium">Pembayaran diterima</p>
                                            <p class="text-xs text-gray-500">2 menit yang lalu</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                            <i class="fas fa-envelope text-green-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium">Pesan baru dari admin</p>
                                            <p class="text-xs text-gray-500">1 jam yang lalu</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-yellow-100 p-2 rounded-full">
                                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium">Pembayaran jatuh tempo</p>
                                            <p class="text-xs text-gray-500">Kemarin</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="px-4 py-2 border-t border-gray-200">
                                <a href="#" class="text-xs text-amber-500 hover:text-amber-800">Lihat semua
                                    notifikasi</a>
                            </div>
                        </div>
                    </div>
                    <!-- Di navbar -->
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="p-2 rounded-full hover:bg-amber-600 transition duration-300 relative">
                            <i class="fas fa-envelope text-lg"></i>
                            <span x-show="unreadCount > 0" class="notification-badge" x-text="unreadCount"></span>
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                            class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-800">Messages</h3>
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                <a href="#" @click.prevent="dropdownOpen = false; $dispatch('open-chat'); markAsRead()"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin">
                                        <div class="ml-3">
                                            <p class="font-medium">Admin Kost</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    @auth
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="relative">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg"
                                    alt="User profile">
                            </div>
                            <span class="hidden md:inline-block">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                :class="{ 'transform rotate-180': open }"></i>
                        </button>
                    @else
                        <a href="{{ route('login.page', ['previous' => 'dashboard']) }}"
                            class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600">
                            Login
                        </a>
                    @endauth
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 dropdown-menu"
                        :class="{ 'show': open }">
                        <a href="{{ route('profileuser', ['previous' => 'dashboard']) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 cursor-pointer">
                            <i class="fas fa-user mr-2 text-gray-500"></i> Profile
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 cursor-pointer">
                            <i class="fas fa-history mr-2 text-gray-500"></i> History Penyewaan
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 cursor-pointer">
                            <i class="fas fa-credit-card mr-2 text-gray-500"></i> Payment
                        </a>
                        <a href="#" @click.prevent="open = false; $dispatch('open-messages')"
                            id="profile-messages"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 cursor-pointer">
                            <i class="fas fa-envelope mr-2 text-gray-500"></i> Messages
                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">1</span>
                        </a>
                        <div class="border-t border-gray-200"></div>
                        <a href="{{ route('logout') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 cursor-pointer">
                            <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i> Logout
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="text-white focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Content -->
    <div class="w-full max-w-screen overflow-x-hidden mt-16">
        <!-- Hero Slider -->
        <div class="relative w-full h-96 overflow-hidden">
            <!-- Single Image -->
            <img src="{{ asset('img/tampak depan.jpg') }}" class="w-full h-full object-cover"
                alt="Kanaya Kost Facilities">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-40 z-10"></div>

            <!-- Hero Content -->
            <div class="absolute inset-0 z-20 flex flex-col justify-center items-center p-4 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-md">Premium Boarding House</h1>
                <p class="text-xl text-white mb-8 max-w-2xl text-shadow">Experience comfortable living with modern
                    facilities in the heart of the city</p>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('detailroom') }}"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-lg font-medium transition duration-300 focus:outline-none focus:ring-2 focus:ring-amber-400">
                        View Rooms
                    </a>
                    <button
                        class="bg-white hover:bg-gray-100 text-amber-600 px-6 py-3 rounded-lg font-medium transition duration-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Contact Us
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-6 py-12">
            <!-- About Section -->
            <section id="about" class="mb-16 py-12 bg-gradient-to-r from-amber-50 to-white rounded-2xl">
                <div class="container mx-auto px-6">
                    <div class="flex flex-col lg:flex-row gap-12 items-center">
                        <div class="lg:w-1/2 relative">
                            <img src="{{ asset('img/tampak depan.jpg') }}" alt="Kanaya Kost Building"
                                class="w-full h-auto rounded-xl shadow-xl transform hover:scale-105 transition duration-500">
                            <div
                                class="absolute -bottom-6 -right-6 bg-amber-100 p-4 rounded-xl shadow-lg border border-amber-200 hidden md:block">
                                <div class="text-amber-800 font-bold text-center">
                                    <p class="text-4xl">5+</p>
                                    <p class="text-sm">Years of Excellence</p>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-1/2">
                            <h2 class="text-4xl font-bold text-gray-800 mb-6 relative inline-block">
                                <span class="relative z-10">Our Story at Kanaya Kost</span>
                                <span class="absolute bottom-0 left-0 w-full h-2 bg-amber-200 opacity-60 z-0"></span>
                            </h2>

                            <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                                Founded in 2018, Kanaya Kost began with a simple vision: to create living spaces that
                                combine comfort, community, and convenience. What started as a single boarding house has
                                grown into a beloved network of accommodations serving professionals, students, and
                                travelers in [Your City].
                            </p>

                            <div class="mb-8">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                                    <span class="w-4 h-4 bg-amber-400 rounded-full mr-3"></span>
                                    Why Choose Kanaya Kost?
                                </h3>
                                <p class="text-gray-600 mb-6 leading-relaxed">
                                    We go beyond just providing rooms. Our community-focused approach ensures every
                                    resident enjoys a supportive environment with premium amenities, regular social
                                    events, and personalized services tailored to modern urban living.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div
                                    class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-amber-400 hover:shadow-md transition">
                                    <div class="flex items-start">
                                        <div class="bg-amber-100 p-2 rounded-full mr-4">
                                            <i class="fas fa-shield-alt text-amber-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-800">24/7 Security</h4>
                                            <p class="text-sm text-gray-600">CCTV monitoring & security personnel for
                                                your peace of mind</p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-amber-400 hover:shadow-md transition">
                                    <div class="flex items-start">
                                        <div class="bg-amber-100 p-2 rounded-full mr-4">
                                            <i class="fas fa-wifi text-amber-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-800">High-speed WiFi</h4>
                                            <p class="text-sm text-gray-600">Fiber-optic connection perfect for work
                                                and streaming</p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-amber-400 hover:shadow-md transition">
                                    <div class="flex items-start">
                                        <div class="bg-amber-100 p-2 rounded-full mr-4">
                                            <i class="fas fa-snowflake text-amber-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-800">Air Conditioning</h4>
                                            <p class="text-sm text-gray-600">Individual climate control in every room
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-amber-400 hover:shadow-md transition">
                                    <div class="flex items-start">
                                        <div class="bg-amber-100 p-2 rounded-full mr-4">
                                            <i class="fas fa-umbrella-beach text-amber-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-800">Balcony</h4>
                                            <p class="text-sm text-gray-600">Private outdoor space in select units</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Facilities Section -->
            <section id="facilities" class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Our Facilities</h2>
                    <div class="w-20 h-1 bg-amber-500 mx-auto"></div>
                    <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                        We provide top-notch facilities to ensure your comfort and convenience during your stay
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 text-center">
                        <div class="text-amber-500 text-4xl mb-4">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">High-speed WiFi</h3>
                        <p class="text-gray-600">Unlimited high-speed internet access throughout the property</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 text-center">
                        <div class="text-amber-500 text-4xl mb-4">
                            <i class="fas fa-umbrella-beach"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Balcony</h3>
                        <p class="text-gray-600">Relaxing balcony with a scenic view</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 text-center">
                        <div class="text-amber-500 text-4xl mb-4">
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Air Conditioning</h3>
                        <p class="text-gray-600">Stay cool and comfortable with air-conditioned rooms</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 text-center">
                        <div class="text-amber-500 text-4xl mb-4">
                            <i class="fas fa-car"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Spacious Parking</h3>
                        <p class="text-gray-600">Ample parking space for your convenience</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 text-center">
                        <div class="text-amber-500 text-4xl mb-4">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">24/7 Security</h3>
                        <p class="text-gray-600">CCTV surveillance and security personnel for your safety</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 text-center">
                        <div class="text-amber-500 text-4xl mb-4">
                            <i class="fas fa-bath"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Private Bathroom</h3>
                        <p class="text-gray-600">Enjoy the convenience of a private bathroom in your room</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 text-center">
                        <div class="text-amber-500 text-4xl mb-4">
                            <i class="fas fa-bed"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Furnished Room</h3>
                        <p class="text-gray-600">Includes a comfortable bed and a wardrobe for your convenience</p>
                    </div>
                </div>
            </section>

            <!-- Location Section -->
            <section id="location" class="mb-16 bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-1/2 p-8 lg:p-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4 relative inline-block">
                            <span class="relative z-10">Strategic Location Advantages</span>
                            <span class="absolute bottom-0 left-0 w-full h-2 bg-amber-200 opacity-60 z-0"></span>
                        </h2>
                        <p class="text-gray-600 mb-6 text-lg">
                            Kanaya Kost is perfectly situated at <span class="font-medium">6째16'48.6"S
                                107째09'56.4"E</span>,
                            offering unbeatable convenience to key locations in Bekasi:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div
                                class="bg-white p-4 rounded-lg border-l-4 border-amber-400 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start">
                                    <div class="bg-amber-100 p-2 rounded-full mr-4">
                                        <i class="fas fa-shield-alt text-amber-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Polres Bekasi</h4>
                                        <p class="text-sm text-gray-600">2.1 km (5 min drive)</p>
                                        <p class="text-xs text-amber-600 mt-1">Safe neighborhood with police proximity
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-white p-4 rounded-lg border-l-4 border-amber-400 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start">
                                    <div class="bg-amber-100 p-2 rounded-full mr-4">
                                        <i class="fas fa-graduation-cap text-amber-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">President University</h4>
                                        <p class="text-sm text-gray-600">3.5 km (8 min drive)</p>
                                        <p class="text-xs text-amber-600 mt-1">Ideal for students and faculty</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-white p-4 rounded-lg border-l-4 border-amber-400 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start">
                                    <div class="bg-amber-100 p-2 rounded-full mr-4">
                                        <i class="fas fa-hospital text-amber-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Rumah Sakit Annisa</h4>
                                        <p class="text-sm text-gray-600">1.8 km (4 min drive)</p>
                                        <p class="text-xs text-amber-600 mt-1">24/7 medical access</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-white p-4 rounded-lg border-l-4 border-amber-400 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start">
                                    <div class="bg-amber-100 p-2 rounded-full mr-4">
                                        <i class="fas fa-train text-amber-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Stasiun Lemahabang</h4>
                                        <p class="text-sm text-gray-600">4.2 km (10 min drive)</p>
                                        <p class="text-xs text-amber-600 mt-1">Easy access to Jakarta</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-amber-50 p-5 rounded-xl border border-amber-200">
                            <div class="flex items-start">
                                <div class="bg-amber-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-route text-amber-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-amber-800 mb-2 text-lg">Excellent Transportation Access
                                    </h4>
                                    <p class="text-amber-700">
                                        Multiple angkot routes (K06, K50) pass nearby, and we're just 15 minutes from
                                        Bekasi Barat Toll Gate for easy access to Jakarta.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:w-1/2 h-96 relative">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2801773!2d107.163087!3d-6.2801773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTYnNDguNiJTIDEwN8KwMDknNTYuNCJF!5e0!3m2!1sen!2sid!4v1629297212920!5m2!1sen!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            class="absolute inset-0">
                        </iframe>
                        <div class="absolute bottom-4 left-4 bg-white px-3 py-2 rounded-lg shadow-md">
                            <p class="text-xs text-gray-600 font-medium">
                                <i class="fas fa-map-marker-alt text-amber-500 mr-1"></i>
                                Kanaya Kost Location: 6째16'48.6"S 107째09'56.4"E
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="contact" class="mb-16 py-12 bg-white rounded-xl shadow-xl">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-800 mb-3 relative inline-block">
                            <span class="relative z-10">Get In Touch</span>
                            <span
                                class="absolute bottom-0 left-0 w-full h-3 bg-amber-200 opacity-50 z-0 -translate-y-1"></span>
                        </h2>
                        <p class="text-gray-600 mt-6 text-lg max-w-2xl mx-auto leading-relaxed">
                            Have questions or want to schedule a viewing? Our team is ready to assist you with any
                            inquiries about Kanaya Kost.
                        </p>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Contact Form -->
                        <div class="lg:w-1/2 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-paper-plane text-amber-500 mr-3"></i>
                                Send Us a Message
                            </h3>
                            <form class="space-y-5">
                                <div>
                                    <label for="name" class="block text-gray-700 mb-2 font-medium">Full
                                        Name</label>
                                    <input type="text" id="name" placeholder="Your full name"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-300">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="email"
                                            class="block text-gray-700 mb-2 font-medium">Email</label>
                                        <input type="email" id="email" placeholder="your.email@example.com"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-300">
                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="block text-gray-700 mb-2 font-medium">Phone</label>
                                        <input type="tel" id="phone" placeholder="+62 812-3456-7890"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-300">
                                    </div>
                                </div>

                                <div>
                                    <label for="subject" class="block text-gray-700 mb-2 font-medium">Subject</label>
                                    <select id="subject"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-300">
                                        <option value="" disabled selected>Select your inquiry</option>
                                        <option value="booking">Room Booking</option>
                                        <option value="viewing">Schedule Viewing</option>
                                        <option value="question">General Question</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="message" class="block text-gray-700 mb-2 font-medium">Your
                                        Message</label>
                                    <textarea id="message" rows="4" placeholder="Type your message here..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-300"></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white py-3 rounded-lg font-semibold transition duration-300 shadow-md hover:shadow-lg">
                                    <i class="fas fa-paper-plane mr-2"></i> Send Message
                                </button>
                            </form>
                        </div>

                        <!-- Contact Information -->
                        <div class="lg:w-1/2 space-y-6">
                            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
                                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                    <i class="fas fa-info-circle text-amber-500 mr-3"></i>
                                    Contact Details
                                </h3>

                                <div class="space-y-5">
                                    <div class="flex items-start group">
                                        <div
                                            class="bg-amber-100 p-3 rounded-lg text-amber-600 mr-4 group-hover:bg-amber-200 transition">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-1">Our Location</h4>
                                            <p class="text-gray-600">Jl. Raya Lemahabang, Simpangan, Kec. Cikarang
                                                Utara, Kabupaten Bekasi</p>
                                            <p class="text-gray-600">Jawa Barat 17530</p>
                                            <a href="#location"
                                                class="inline-block mt-2 text-amber-600 hover:text-amber-700 text-sm font-medium">
                                                <i class="fas fa-map-marked-alt mr-1"></i> View on map
                                            </a>
                                        </div>
                                    </div>

                                    <div class="flex items-start group">
                                        <div
                                            class="bg-amber-100 p-3 rounded-lg text-amber-600 mr-4 group-hover:bg-amber-200 transition">
                                            <i class="fas fa-phone-alt"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-1">Phone & WhatsApp</h4>
                                            <p class="text-gray-600">+62 21 1234 5678 (Office)</p>
                                            <p class="text-gray-600">+62 812 3456 7890 (WhatsApp)</p>
                                            <a href="https://wa.me/6281234567890" target="_blank"
                                                class="inline-block mt-2 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-green-200 transition">
                                                <i class="fab fa-whatsapp mr-1"></i> Chat Now
                                            </a>
                                        </div>
                                    </div>

                                    <div class="flex items-start group">
                                        <div
                                            class="bg-amber-100 p-3 rounded-lg text-amber-600 mr-4 group-hover:bg-amber-200 transition">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-1">Email Address</h4>
                                            <p class="text-gray-600">info@kanayakost.com</p>
                                            <p class="text-gray-600">booking@kanayakost.com</p>
                                            <a href="mailto:info@kanayakost.com"
                                                class="inline-block mt-2 text-amber-600 hover:text-amber-700 text-sm font-medium">
                                                <i class="fas fa-envelope-open-text mr-1"></i> Send Email
                                            </a>
                                        </div>
                                    </div>

                                    <div class="flex items-start group">
                                        <div
                                            class="bg-amber-100 p-3 rounded-lg text-amber-600 mr-4 group-hover:bg-amber-200 transition">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 mb-1">Office Hours</h4>
                                            <p class="text-gray-600"><span class="font-medium">Weekdays:</span> 9:00
                                                AM - 5:00 PM</p>
                                            <p class="text-gray-600"><span class="font-medium">Saturday:</span> 9:00
                                                AM - 2:00 PM</p>
                                            <p class="text-gray-600"><span class="font-medium">Sunday:</span> Closed
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule Viewing -->
                            <div
                                class="bg-gradient-to-r from-amber-100 to-amber-50 p-8 rounded-xl border border-amber-200 shadow-sm">
                                <h3 class="text-2xl font-bold text-amber-800 mb-4 flex items-center">
                                    <i class="fas fa-calendar-check mr-3"></i>
                                    Schedule a Viewing
                                </h3>
                                <p class="text-amber-700 mb-6 leading-relaxed">
                                    Experience Kanaya Kost in person! Book a private tour at your convenience and see
                                    why our residents love staying with us.
                                </p>
                                <button
                                    class="w-full bg-white hover:bg-amber-500 text-amber-500 hover:text-white border-2 border-amber-500 py-3 rounded-lg font-semibold transition duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-alt mr-2"></i> Book a Viewing Appointment
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Message Sidebar -->
    <div x-data="messageComponent" x-on:open-chat.window="chatOpen = true" id="message-sidebar" x-show="chatOpen"
        x-transition class="fixed right-0 top-0 h-full w-full md:w-1/3 bg-white shadow-lg border-l border-gray-200">

        <!-- Chat Header -->
        <div class="flex justify-between items-center p-4 border-b border-gray-200 bg-amber-500 text-white">
            <div class="flex items-center">
                <img src="https://randomuser.me/api/portraits/women/32.jpg"
                    class="w-10 h-10 rounded-full object-cover mr-3" alt="Admin Kost">
                <div>
                    <h3 class="font-semibold">Admin Kost</h3>
                    <p class="text-xs text-amber-100">Online</p>
                </div>
            </div>
            <button @click="chatOpen = false" class="py-3 px-5 rounded-xl hover:bg-amber-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Chat Container -->
        <div class="chat-container overflow-y-auto p-4 h-[calc(100%-120px)]">
            <div class="space-y-4" x-ref="messagesContainer">
                <template x-for="msg in messages" :key="msg.id">
                    <div :class="msg.is_admin == 1 ? 'flex justify-start' : 'flex justify-end'">
                        <div class="flex items-end space-x-2"
                            :class="msg.is_admin == 1 ? '' : 'flex-row-reverse space-x-reverse'">
                            <img :src="msg.is_admin == 1 ?
                                'https://randomuser.me/api/portraits/men/42.jpg' :
                                (messages.find(c => c.user_id == 4)?.user?.photo ||
                                    'https://randomuser.me/api/portraits/men/1.jpg')"
                                class="w-8 h-8 rounded-full border border-amber-200 shadow">
                            <div>
                                <div :class="msg.is_admin == 1 ? 'bg-gray-100 text-gray-800' :
                                    'bg-amber-500 text-white'"
                                    class="px-4 py-2 rounded-2xl shadow max-w-xs break-words">
                                    <span x-text="msg.content"></span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1" x-text="formatTime(msg.created_at)"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Message Input -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
            <form @submit.prevent="sendMessage" class="flex items-center">
                <input type="text" x-model="newMessage" placeholder="Type your message..."
                    class="flex-1 border border-gray-300 rounded-l-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
                <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-r-lg hover:bg-amber-600">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <!-- About Column -->
                <div class="space-y-5">
                    <div class="flex items-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Kanaya Kost Logo" class="h-10 mr-3">
                        <span class="text-2xl font-bold">Kanaya Kost</span>
                    </div>
                    <p class="text-amber-100 leading-relaxed">
                        Premium boarding house accommodations with modern facilities and comfortable living spaces in
                        the heart of Jakarta.
                    </p>
                    <div class="flex items-center space-x-3">
                        <div class="bg-amber-500 text-white p-2 rounded-full">
                            <i class="fas fa-star text-xs"></i>
                        </div>
                        <span class="text-sm text-amber-100">4.9/5 (120+ Reviews)</span>
                    </div>
                </div>

                <!-- Quick Links Column -->
                <div>
                    <h4
                        class="text-lg font-bold mb-5 relative pb-2 after:absolute after:bottom-0 after:left-0 after:w-10 after:h-0.5 after:bg-amber-500">
                        Quick Links
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-amber-100 hover:text-white transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-amber-400"></i> Home</a></li>
                        <li><a href="#facilities"
                                class="text-amber-100 hover:text-white transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-amber-400"></i> Facilities</a></li>
                        <li><a href="#rooms"
                                class="text-amber-100 hover:text-white transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-amber-400"></i> Rooms</a></li>
                        <li><a href="#location"
                                class="text-amber-100 hover:text-white transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-amber-400"></i> Location</a></li>
                        <li><a href="#contact"
                                class="text-amber-100 hover:text-white transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-amber-400"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div>
                    <h4
                        class="text-lg font-bold mb-5 relative pb-2 after:absolute after:bottom-0 after:left-0 after:w-10 after:h-0.5 after:bg-amber-500">
                        Contact Us
                    </h4>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                                <i class="fas fa-map-marker-alt text-amber-400"></i>
                            </div>
                            <div>
                                <h5 class="font-medium">Address</h5>
                                <p class="text-amber-100 text-sm">Jl. Kanaya No. 123, Kemayoran<br>Jakarta Pusat 10660
                                </p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                                <i class="fas fa-phone-alt text-amber-400"></i>
                            </div>
                            <div>
                                <h5 class="font-medium">Phone</h5>
                                <p class="text-amber-100 text-sm">+62 21 1234 5678</p>
                                <a href="https://wa.me/6281234567890"
                                    class="text-amber-400 hover:text-amber-300 text-xs flex items-center mt-1">
                                    <i class="fab fa-whatsapp mr-1"></i> WhatsApp Available
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                                <i class="fas fa-envelope text-amber-400"></i>
                            </div>
                            <div>
                                <h5 class="font-medium">Email</h5>
                                <p class="text-amber-100 text-sm">info@kanayakost.com</p>
                                <p class="text-amber-100 text-sm">booking@kanayakost.com</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Social & Newsletter Column -->
                <div>
                    <h4
                        class="text-lg font-bold mb-5 relative pb-2 after:absolute after:bottom-0 after:left-0 after:w-10 after:h-0.5 after:bg-amber-500">
                        Follow Us
                    </h4>
                    <div class="flex space-x-4 mb-6">
                        <a href="#"
                            class="bg-gray-700 hover:bg-amber-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="bg-gray-700 hover:bg-amber-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="bg-gray-700 hover:bg-amber-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition duration-300">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://wa.me/6281234567890"
                            class="bg-gray-700 hover:bg-amber-500 text-white w-10 h-10 rounded-full flex items-center justify-center transition duration-300">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold mb-3">Newsletter</h4>
                        <p class="text-amber-100 text-sm mb-4">Subscribe for updates and special offers</p>
                        <form class="flex">
                            <input type="email" placeholder="Your email"
                                class="px-4 py-3 rounded-l-lg w-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <button
                                class="bg-amber-600 hover:bg-amber-500 px-4 py-3 rounded-r-lg transition duration-300">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-amber-200 text-sm mb-4 md:mb-0">
                    &copy; 2023 Kanaya Kost. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-amber-200 hover:text-white text-sm transition duration-300">Privacy
                        Policy</a>
                    <a href="#" class="text-amber-200 hover:text-white text-sm transition duration-300">Terms of
                        Service</a>
                    <a href="#"
                        class="text-amber-200 hover:text-white text-sm transition duration-300">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Loading Kanaya Kost...</div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('messageComponent', () => ({
                chatOpen: false,
                messages: [],
                newMessage: '',
                fetchInterval: null,
                unreadCount: 0,

                init() {
                    this.loadMessages();
                    this.startFetching();
                },

                startFetching() {
                    // Clear interval if already set
                    if (this.fetchInterval) clearInterval(this.fetchInterval);
                    this.fetchInterval = setInterval(() => {
                        if (this.chatOpen) {
                            this.loadMessages();
                        }
                    }, 1000);
                },

                loadMessages() {
                    console.log({{ Auth()->id() }});
                    fetch('/user/messages')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            this.messages = data.messages;
                            this.unreadCount = data.unread_count;
                            this.scrollToBottom();
                        })
                        .catch(error => {
                            console.error('Error loading messages:', error);
                            this.messages = [{
                                content: "Gagal memuat pesan. Silakan coba lagi.",
                                is_admin: true,
                                created_at: new Date().toISOString()
                            }];
                        });
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = this.$refs.messagesContainer;
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    });
                },

                sendMessage() {
                    if (!this.newMessage.trim()) return;

                    fetch('/messages', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: {{ auth()->id() }},
                                is_admin: false,
                                content: this.newMessage
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw err;
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            this.messages.push(data);
                            this.newMessage = '';
                            this.scrollToBottom();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal mengirim pesan: ' + (error.message ||
                                'Terjadi kesalahan'));
                        });
                },

                formatTime(timestamp) {
                    const date = new Date(timestamp);
                    return date.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                },
                markAsRead() {
                    fetch('/user/messages/mark-as-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then(() => {
                        this.unreadCount = 0;
                    });
                }
            }));
        });
    </script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('chat', {
                open() {
                    const component = Alpine.store('chatComponent');
                    component.chatOpen = true;
                },
                close() {
                    const component = Alpine.store('chatComponent');
                    component.chatOpen = false;
                }
            });
        });
    </script>
    <script>
        // Toggle Message Sidebar
        const messageToggle = document.getElementById('message-toggle');
        const profileMessages = document.getElementById('profile-messages');
        const messageSidebar = document.getElementById('message-sidebar');
        const closeMessages = document.getElementById('close-messages');

        // Toggle from message icon
        messageToggle.addEventListener('click', () => {
            messageSidebar.classList.toggle('open');
        });

        // Toggle from profile dropdown
        profileMessages.addEventListener('click', (e) => {
            e.preventDefault();
            messageSidebar.classList.add('open');
            // Close profile dropdown if open
            document.getElementById('profile-dropdown').classList.add('hidden');
        });

        // Close sidebar
        closeMessages.addEventListener('click', () => {
            messageSidebar.classList.remove('open');
        });

        // Profile dropdown functionality
        const profileButton = document.getElementById('profile-button');
        const profileDropdown = document.getElementById('profile-dropdown');
        const profileChevron = document.getElementById('profile-chevron');

        profileButton.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
            profileChevron.classList.toggle('transform');
            profileChevron.classList.toggle('rotate-180');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.add('hidden');
                profileChevron.classList.remove('transform', 'rotate-180');
            }
        });
    </script>
    <script>
        let lastScrollTop = 0;
        const navbar = document.getElementById('navbar');

        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                navbar.classList.remove('navbar-visible');
                navbar.classList.add('navbar-hidden');
            } else {
                // Scrolling up
                navbar.classList.remove('navbar-hidden');
                navbar.classList.add('navbar-visible');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        // Enhanced loading overlay that waits for all images to load
        document.addEventListener('DOMContentLoaded', function() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            const images = document.images;
            const totalImages = images.length;
            let loadedImages = 0;

            // Jika tidak ada gambar, langsung sembunyikan loading
            if (totalImages === 0) {
                hideLoadingOverlay();
                return;
            }

            // Tambahkan event listener untuk setiap gambar
            Array.from(images).forEach(function(img) {
                if (img.complete) {
                    imageLoaded();
                } else {
                    img.addEventListener('load', imageLoaded);
                    img.addEventListener('error', imageLoaded); // Juga tangani jika gambar gagal dimuat
                }
            });

            function imageLoaded() {
                loadedImages++;
                // Update progress jika mau
                // document.querySelector('.loading-text').textContent = `Loading (${loadedImages}/${totalImages})...`;

                if (loadedImages === totalImages) {
                    hideLoadingOverlay();
                }
            }

            function hideLoadingOverlay() {
                loadingOverlay.classList.add('hidden');
                setTimeout(function() {
                    loadingOverlay.remove();
                }, 500);
            }
            setTimeout(hideLoadingOverlay, 5000);
        });
    </script>
</body>

</html>
