<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            top: -5px;
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
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <div id="navbar"
        class="fixed top-0 left-0 w-full bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg z-50 navbar-visible">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-home text-2xl"></i>
                <h1 class="text-xl font-bold">KANAYA KOST</h1>
            </div>
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="#" class="hover:text-amber-200 transition duration-300 font-medium">Home</a>
                <a href="#facilities" class="hover:text-amber-200 transition duration-300 font-medium">Facilities</a>
                <a href="#rooms" class="hover:text-amber-200 transition duration-300 font-medium">Rooms</a>
                <a href="#location" class="hover:text-amber-200 transition duration-300 font-medium">Location</a>
                <a href="#contact" class="hover:text-amber-200 transition duration-300 font-medium">Contact</a>

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

                <!-- Messages Icon -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="p-2 rounded-full hover:bg-amber-600 transition duration-300 relative">
                        <i class="fas fa-envelope text-lg"></i>
                        <span class="notification-badge">1</span>
                    </button>
                    <!-- Messages Dropdown -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg py-1 z-50 dropdown-menu"
                        :class="{ 'show': open }">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-800">Messages</h3>
                        </div>
                        <div class="max-h-60 overflow-y-auto">
                            <a href="#" @click.prevent="open = false; $dispatch('open-messages')"
                                id="message-toggle" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin">
                                    <div class="ml-3">
                                        <p class="font-medium">Admin Kost</p>
                                        <p class="text-xs text-gray-500">Pembayaran Anda sudah...</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="px-4 py-2 border-t border-gray-200">
                            <a href="#" class="text-xs text-amber-500 hover:text-amber-800">Lihat semua pesan</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <div class="relative">
                            <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg"
                                alt="User profile">
                        </div>
                        <span class="hidden md:inline-block">John Doe</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                            :class="{ 'transform rotate-180': open }"></i>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 dropdown-menu"
                        :class="{ 'show': open }">
                        <a href="{{ route('profileuser') }}"
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
        <div x-data="{
            currentSlide: 0,
            total: 3,
            interval: null,
            startAutoSlide() {
                this.interval = setInterval(() => {
                    this.currentSlide = (this.currentSlide + 1) % this.total;
                }, 5000); // Ganti 5000 dengan interval yang diinginkan (dalam milidetik)
            },
            stopAutoSlide() {
                clearInterval(this.interval);
            }
        }" x-init="startAutoSlide()" @mouseenter="stopAutoSlide()"
            @mouseleave="startAutoSlide()" class="relative w-full h-96 overflow-hidden">

            <!-- Slide Images -->
            <template x-for="(img, index) in ['img/ph1.jpg', 'img/ph2.jpg', 'img/ph3.jpg']" :key="index">
                <img :src="`{{ asset('${img}') }}`"
                    class="absolute top-0 left-0 w-full h-full object-cover transition-all duration-700 ease-in-out"
                    :class="{
                        'opacity-0 -translate-x-full z-0': index === (currentSlide === 0 ? total - 1 : currentSlide -
                            1),
                        'opacity-100 translate-x-0 z-10': index === currentSlide,
                        'opacity-0 translate-x-full z-0': index === (currentSlide === total - 1 ? 0 : currentSlide + 1),
                        'hidden': index !== currentSlide && index !== (currentSlide === 0 ? total - 1 : currentSlide -
                            1) && index !== (currentSlide === total - 1 ? 0 : currentSlide + 1)
                    }"
                    alt="Kanaya Kost Facilities">
            </template>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-40 z-10"></div>

            <!-- Hero Content + Navigation (Satu Container) -->
            <div class="absolute inset-0 z-20 flex flex-col justify-between items-center p-4">
                <!-- Main Content -->
                <div class="w-full h-full flex flex-row justify-between items-center">
                    <!-- Previous Button -->
                    <button
                        @click="currentSlide = (currentSlide === 0 ? total - 1 : currentSlide - 1); stopAutoSlide(); startAutoSlide();"
                        class="bg-white bg-opacity-30 hover:bg-opacity-50 text-white py-3 px-5 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50"
                        aria-label="Previous slide">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <!-- Slide Content -->
                    <div class="flex-1 flex flex-col justify-center items-center text-center mx-4">
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-md">Premium Boarding
                            House</h1>
                        <p class="text-xl text-white mb-8 max-w-2xl text-shadow">Experience comfortable living with
                            modern facilities in the heart of the city</p>
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                            <button
                                class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-lg font-medium transition duration-300 focus:outline-none focus:ring-2 focus:ring-amber-400">
                                View Rooms
                            </button>
                            <button
                                class="bg-white hover:bg-gray-100 text-amber-600 px-6 py-3 rounded-lg font-medium transition duration-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                Contact Us
                            </button>
                        </div>
                    </div>

                    <!-- Next Button -->
                    <button
                        @click="currentSlide = (currentSlide === total - 1 ? 0 : currentSlide + 1); stopAutoSlide(); startAutoSlide();"
                        class="bg-white bg-opacity-30 hover:bg-opacity-50 text-white py-3 px-5 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50"
                        aria-label="Next slide">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Navigation Controls -->
                <div class="w-full flex justify-center items-center mt-4">
                    <!-- Indicators -->
                    <div class="flex space-x-2">
                        <template x-for="i in total" :key="i">
                            <button @click="currentSlide = i-1; stopAutoSlide(); startAutoSlide();"
                                class="w-3 h-3 rounded-full transition duration-300 focus:outline-none"
                                :class="{ 'bg-white': currentSlide === i - 1, 'bg-white bg-opacity-50': currentSlide !== i - 1 }"
                                :aria-label="`Go to slide ${i}`"
                                :aria-current="currentSlide === i - 1 ? 'true' : 'false'">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-6 py-12">
            <!-- About Section -->
            <section class="mb-16">
                <div class="flex flex-col lg:flex-row gap-8 items-center">
                    <div class="lg:w-1/2">
                        <img src="{{ asset('img/ph1.jpg') }}" alt="Kanaya Kost Building"
                            class="w-full h-auto rounded-xl shadow-xl">
                    </div>
                    <div class="lg:w-1/2">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Kanaya Kost</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Kanaya Kost offers premium boarding house accommodations with modern facilities and
                            comfortable living spaces. Located in a strategic area with easy access to business
                            districts, universities, and public transportation, we provide the perfect home for
                            professionals and students alike.
                        </p>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-amber-500 mr-2"></i>
                                <span class="text-gray-700">24/7 Security</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-amber-500 mr-2"></i>
                                <span class="text-gray-700">High-speed WiFi</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-amber-500 mr-2"></i>
                                <span class="text-gray-700">Air Conditioning</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-amber-500 mr-2"></i>
                                <span class="text-gray-700">Balcony</span>
                            </div>
                        </div>
                        <button
                            class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                            Learn More About Us
                        </button>
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
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Shared Kitchen</h3>
                        <p class="text-gray-600">Fully equipped kitchen with modern appliances</p>
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

            <!-- Rooms Section -->
            <section id="rooms" class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Our Rooms</h2>
                    <div class="w-20 h-1 bg-amber-500 mx-auto"></div>
                    <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                        Choose from our variety of comfortable and well-designed rooms
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Room 1 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden room-card transition duration-300">
                        <img src="{{ asset('img/ph2.jpg') }}" alt="Standard Room" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Standard Room</h3>
                            <div class="flex items-center text-yellow-500 mb-3">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="text-gray-600 mb-4">Cozy room with single bed, wardrobe, and study table</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-amber-500">Rp 1.500.000<span
                                        class="text-sm font-normal text-gray-500">/month</span></span>
                                <button
                                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm transition duration-300">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Room 2 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden room-card transition duration-300">
                        <img src="{{ asset('img/ph3.jpg') }}" alt="Deluxe Room" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Deluxe Room</h3>
                            <div class="flex items-center text-yellow-500 mb-3">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="text-gray-600 mb-4">Spacious room with double bed, AC, and private bathroom</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-amber-500">Rp 2.500.000<span
                                        class="text-sm font-normal text-gray-500">/month</span></span>
                                <button
                                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm transition duration-300">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Room 3 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden room-card transition duration-300">
                        <img src="{{ asset('img/ph1.jpg') }}" alt="Executive Room" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Executive Room</h3>
                            <div class="flex items-center text-yellow-500 mb-3">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="text-gray-600 mb-4">Luxurious room with king-size bed, working area, and balcony
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-amber-500">Rp 3.500.000<span
                                        class="text-sm font-normal text-gray-500">/month</span></span>
                                <button
                                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm transition duration-300">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-10">
                    <a href="{{ route('listroom') }}"
                        class="border-2 border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                        View All Rooms
                    </a>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">What Our Residents Say</h2>
                    <div class="w-20 h-1 bg-amber-500 mx-auto"></div>
                    <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                        Hear from people who have experienced living at Kanaya Kost
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-md testimonial-card">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-bold">Sarah Johnson</h4>
                                <div class="flex items-center text-yellow-500 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "Living at Kanaya Kost has been wonderful. The facilities are excellent and the location is
                            perfect for my university. The management is very responsive to any issues."
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md testimonial-card">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="David"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-bold">David Wilson</h4>
                                <div class="flex items-center text-yellow-500 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "As a young professional, I appreciate the quiet environment and reliable WiFi. The shared
                            kitchen is well-maintained and I've made some good friends here."
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md testimonial-card">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Lisa"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-bold">Lisa Chen</h4>
                                <div class="flex items-center text-yellow-500 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "The security makes me feel safe as a female resident. The rooms are cleaned regularly and
                            maintenance requests are handled quickly. Highly recommend!"
                        </p>
                    </div>
                </div>
            </section>

            <!-- Location Section -->
            <section id="location" class="mb-16 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-1/2 p-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Location</h2>
                        <p class="text-gray-600 mb-6">
                            Kanaya Kost is strategically located in the city center with easy access to various
                            amenities:
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <i class="fas fa-university text-amber-500 mt-1 mr-3"></i>
                                <span class="text-gray-700">5 minutes walk to Universitas Indonesia</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-subway text-amber-500 mt-1 mr-3"></i>
                                <span class="text-gray-700">10 minutes to MRT station</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-shopping-bag text-amber-500 mt-1 mr-3"></i>
                                <span class="text-gray-700">15 minutes to Grand City Mall</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-hospital text-amber-500 mt-1 mr-3"></i>
                                <span class="text-gray-700">8 minutes to Metropolitan Hospital</span>
                            </li>
                        </ul>
                        <div class="bg-amber-50 p-4 rounded-lg">
                            <h4 class="font-bold text-amber-800 mb-2">Transportation Access</h4>
                            <p class="text-amber-700">
                                Multiple bus routes stop nearby, and we're just a short ride from the main business
                                district.
                            </p>
                        </div>
                    </div>
                    <div class="lg:w-1/2 h-96">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613507864!3d-6.194741395493371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e839560a85ab!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1629297212920!5m2!1sen!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            class="object-cover">
                        </iframe>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="contact" class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Contact Us</h2>
                    <div class="w-20 h-1 bg-amber-500 mx-auto"></div>
                    <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                        Have questions or want to schedule a viewing? Get in touch with us
                    </p>
                </div>

                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/2 bg-white p-8 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Send us a message</h3>
                        <form>
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 mb-2">Your Name</label>
                                <input type="text" id="name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 mb-2">Email Address</label>
                                <input type="email" id="email"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" id="phone"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div class="mb-4">
                                <label for="message" class="block text-gray-700 mb-2">Your Message</label>
                                <textarea id="message" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition duration-300">
                                Send Message
                            </button>
                        </form>
                    </div>

                    <div class="lg:w-1/2">
                        <div class="bg-white p-8 rounded-xl shadow-md mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Contact Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-amber-500 mt-1 mr-4"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Address</h4>
                                        <p class="text-gray-600">Jl. Kanaya No. 123, Kemayoran, Jakarta Pusat 10660</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone-alt text-amber-500 mt-1 mr-4"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Phone</h4>
                                        <p class="text-gray-600">+62 21 1234 5678</p>
                                        <p class="text-gray-600">+62 812 3456 7890 (WhatsApp)</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-envelope text-amber-500 mt-1 mr-4"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Email</h4>
                                        <p class="text-gray-600">info@kanayakost.com</p>
                                        <p class="text-gray-600">booking@kanayakost.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-clock text-amber-500 mt-1 mr-4"></i>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Office Hours</h4>
                                        <p class="text-gray-600">Monday - Friday: 9:00 AM - 5:00 PM</p>
                                        <p class="text-gray-600">Saturday: 9:00 AM - 2:00 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-amber-50 p-6 rounded-xl">
                            <h4 class="font-bold text-amber-800 mb-3">Schedule a Viewing</h4>
                            <p class="text-amber-700 mb-4">
                                Interested in seeing our rooms? Contact us to schedule a personal tour at your
                                convenience.
                            </p>
                            <button
                                class="w-full bg-white border border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-white py-2 rounded-lg font-medium transition duration-300">
                                Book a Viewing
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Message -->
    <div id="message-sidebar"
        class="message-sidebar fixed right-0 w-1/4 bg-white shadow-lg border-l border-gray-200 z-40">
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
            <button id="close-messages" class="py-3 px-5 rounded-xl hover:bg-amber-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Chat Container -->
        <div class="chat-container overflow-y-auto p-4">
            <!-- Chat Messages -->
            <div class="space-y-4">
                <!-- Admin Message -->
                <div class="flex items-start">
                    <img src="https://randomuser.me/api/portraits/women/32.jpg"
                        class="w-8 h-8 rounded-full object-cover mr-2" alt="Admin Kost">
                    <div>
                        <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                            <p class="text-sm">Selamat siang, ada yang bisa saya bantu?</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">10:30 AM</p>
                    </div>
                </div>

                <!-- User Message -->
                <div class="flex justify-end">
                    <div class="text-right">
                        <div class="bg-amber-500 text-white rounded-lg p-3 max-w-xs ml-auto">
                            <p class="text-sm">Saya mau tanya tentang pembayaran bulan depan</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">10:32 AM</p>
                    </div>
                </div>

                <!-- Admin Message -->
                <div class="flex items-start">
                    <img src="https://randomuser.me/api/portraits/women/32.jpg"
                        class="w-8 h-8 rounded-full object-cover mr-2" alt="Admin Kost">
                    <div>
                        <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                            <p class="text-sm">Pembayaran bisa dilakukan sebelum tanggal 5 setiap bulannya. Transfer ke
                                BCA 1234567890 a.n. Kanaya Kost</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">10:33 AM</p>
                    </div>
                </div>

                <!-- User Message -->
                <div class="flex justify-end">
                    <div class="text-right">
                        <div class="bg-amber-500 text-white rounded-lg p-3 max-w-xs ml-auto">
                            <p class="text-sm">Baik, terima kasih informasinya</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">10:35 AM</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
            <div class="flex items-center">
                <input type="text" placeholder="Type your message..."
                    class="flex-1 border border-gray-300 rounded-l-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
                <button class="bg-amber-500 text-white px-4 py-2 rounded-r-lg hover:bg-amber-600">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="gradient-bg text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Kanaya Kost</h3>
                    <p class="text-amber-200">
                        Premium boarding house accommodations with modern facilities and comfortable living spaces.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-amber-200 hover:text-white transition duration-300">Home</a>
                        </li>
                        <li><a href="#facilities"
                                class="text-amber-200 hover:text-white transition duration-300">Facilities</a></li>
                        <li><a href="#rooms"
                                class="text-amber-200 hover:text-white transition duration-300">Rooms</a></li>
                        <li><a href="#location"
                                class="text-amber-200 hover:text-white transition duration-300">Location</a></li>
                        <li><a href="#contact"
                                class="text-amber-200 hover:text-white transition duration-300">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact Us</h4>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-amber-300"></i>
                            <span class="text-amber-200">Jl. Kanaya No. 123, Jakarta</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-amber-300"></i>
                            <span class="text-amber-200">+62 21 1234 5678</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-amber-300"></i>
                            <span class="text-amber-200">info@kanayakost.com</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-amber-200 hover:text-white text-xl transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-amber-200 hover:text-white text-xl transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-amber-200 hover:text-white text-xl transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-amber-200 hover:text-white text-xl transition duration-300">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                    <div class="mt-6">
                        <h4 class="font-bold mb-2">Newsletter</h4>
                        <div class="flex">
                            <input type="email" placeholder="Your email"
                                class="px-4 py-2 rounded-l-lg w-full text-gray-800 focus:outline-none">
                            <button class="bg-amber-800 hover:bg-amber-600 px-4 py-2 rounded-r-lg">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-amber-700 mt-8 pt-8 text-center text-amber-300">
                <p>&copy; 2023 Kanaya Kost. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Loading Kanaya Kost...</div>
    </div>
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
