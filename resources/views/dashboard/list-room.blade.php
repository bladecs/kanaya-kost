<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANAYA KOST - Room List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .room-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .selected-room {
            border-left: 4px solid #ebc725;
            background-color: #f8fafc;
        }

        .sidebar-details {
            transition: all 0.3s ease;
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
    </style>
</head>

<body class="bg-gray-50" x-data="app()">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- Back Button - Left Side -->
                <div class="flex-1">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center group transition-all duration-200 hover:bg-amber-700/30 rounded-lg px-3 py-2">
                        <div
                            class="w-8 h-8 flex items-center justify-center bg-white/20 rounded-full mr-2 group-hover:bg-white/30 transition-colors duration-200">
                            <i class="fas fa-arrow-left text-white group-hover:text-amber-100"></i>
                        </div>
                        <span class="text-white group-hover:text-amber-100 font-medium">
                            Kembali
                        </span>
                    </a>
                </div>

                <!-- Logo/Center -->
                <div class="flex-1 flex justify-center">
                    <div class="flex items-center space-x-3 bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm">
                        <i class="fas fa-home text-xl text-white"></i>
                        <h1 class="text-xl font-bold tracking-tight text-white">KANAYA KOST</h1>
                    </div>
                </div>

                <!-- Actions - Right Side -->
                <div class="flex-1 flex justify-end">
                    <div class="flex items-center space-x-3">
                        <!-- Notification Bell -->
                        <button class="p-2 rounded-full hover:bg-white/10 relative transition-colors duration-200">
                            <i class="fas fa-bell text-lg text-white"></i>
                            <span
                                class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center transform translate-x-1 -translate-y-1">3</span>
                        </button>

                        <!-- Message Button -->
                        <button @click="chatOpen = !chatOpen"
                            class="p-2 rounded-full hover:bg-white/10 relative transition-colors duration-200">
                            <i class="fas fa-envelope text-lg text-white"></i>
                            <span x-show="unreadMessages > 0"
                                class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center transform translate-x-1 -translate-y-1"
                                x-text="unreadMessages"></span>
                        </button>

                        <!-- User Profile -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <div class="relative">
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://randomuser.me/api/portraits/men/32.jpg" alt="User profile">
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
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Room List (Left Side) -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Kamar Tersedia</h2>

                    <!-- Search and Filter -->
                    <div class="mb-6 flex flex-col md:flex-row gap-4">
                        <div class="relative flex-1">
                            <input type="text" placeholder="Cari kamar..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            <option>Semua Tipe</option>
                            <option>Standard</option>
                            <option>Deluxe</option>
                            <option>Executive</option>
                        </select>
                    </div>

                    <!-- Room List -->
                    <div class="space-y-4">
                        <template x-for="room in rooms" :key="room.id">
                            <div @click="selectRoom(room)"
                                :class="{ 'selected-room': selectedRoom && selectedRoom.id === room.id }"
                                class="room-item bg-white border border-gray-200 rounded-lg p-4 cursor-pointer transition-all duration-200">
                                <div class="flex flex-col md:flex-row gap-4">
                                    <div class="w-full md:w-1/3">
                                        <img :src="room.image" alt="Room Image"
                                            class="w-full h-40 object-cover rounded-lg">
                                    </div>
                                    <div class="w-full md:w-2/3">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-semibold text-gray-800" x-text="room.name"></h3>
                                            <span class="text-lg font-bold text-amber-600"
                                                x-text="'Rp ' + room.price.toLocaleString('id-ID') + '/bulan'"></span>
                                        </div>
                                        <div class="flex items-center mt-2 mb-3">
                                            <div class="flex text-yellow-400">
                                                <template x-for="i in 5" :key="i">
                                                    <i :class="i <= room.rating ? 'fas fa-star' : 'far fa-star'"
                                                        class="text-sm"></i>
                                                </template>
                                            </div>
                                            <span class="text-sm text-gray-500 ml-2"
                                                x-text="room.reviews + ' reviews'"></span>
                                        </div>
                                        <p class="text-gray-600 mb-3"
                                            x-text="room.description.substring(0, 100) + '...'"></p>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded"
                                                x-text="room.size + ' m²'"></span>
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded"
                                                x-text="room.type"></span>
                                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded"
                                                x-text="room.available + ' tersedia'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Room Details Sidebar (Right Side) -->
            <div class="w-full lg:w-1/3">
                <div x-show="selectedRoom" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-10"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-10"
                    class="sidebar-details bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4" x-text="selectedRoom.name"></h2>
                    <img :src="selectedRoom.image" alt="Room Image" class="w-full h-48 object-cover rounded-lg mb-4">

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-2xl font-bold text-amber-600"
                            x-text="'Rp ' + selectedRoom.price.toLocaleString('id-ID') + '/bulan'"></span>
                        <a href="{{ route('detailroom') }}"
                            class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg">
                            Detail
                        </a>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-2">Deskripsi Kamar</h3>
                        <p class="text-gray-600" x-text="selectedRoom.description"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Spesifikasi</h3>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-center">
                                    <i class="fas fa-ruler-combined text-amber-500 mr-2"></i>
                                    <span x-text="selectedRoom.size + ' m²'"></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-bed text-amber-500 mr-2"></i>
                                    <span x-text="selectedRoom.bedType"></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-bath text-amber-500 mr-2"></i>
                                    <span x-text="selectedRoom.bathroom"></span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Fasilitas</h3>
                            <ul class="space-y-2 text-gray-600">
                                <template x-for="(facility, index) in selectedRoom.facilities" :key="index">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span x-text="facility"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Lokasi</h3>
                        <p class="text-gray-600 mb-2" x-text="selectedRoom.location"></p>
                        <div class="w-full h-40 bg-gray-200 rounded-lg overflow-hidden">
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div x-show="!selectedRoom" x-transition
                    class="sidebar-details bg-white rounded-lg shadow-md p-6 sticky top-4 text-center py-8">
                    <i class="fas fa-door-open text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Pilih kamar untuk melihat detail</p>
                </div>
            </div>
        </div>
    </div>
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Loading Kanaya Kost...</div>
    </div>
    <script>
        function app() {
            return {
                rooms: [{
                        id: 1,
                        name: "Kamar Standard",
                        price: 1500000,
                        rating: 4,
                        reviews: 12,
                        size: 16,
                        type: "Standard",
                        available: 3,
                        description: "Kamar nyaman dengan tempat tidur single, lemari pakaian, dan meja belajar. Termasuk akses WiFi gratis dan kamar mandi dalam.",
                        image: "img/ph1.jpg",
                        bedType: "Single Bed",
                        bathroom: "Kamar mandi dalam",
                        facilities: ["AC", "WiFi Gratis", "Kamar Mandi Dalam", "Meja Belajar"],
                        location: "Lantai 1, Blok A"
                    },
                    {
                        id: 2,
                        name: "Kamar Deluxe",
                        price: 2500000,
                        rating: 5,
                        reviews: 8,
                        size: 20,
                        type: "Deluxe",
                        available: 1,
                        description: "Kamar luas dengan tempat tidur double, lemari pakaian besar, meja kerja, dan kamar mandi pribadi dengan shower air panas.",
                        image: "img/ph2.jpg",
                        bedType: "Double Bed",
                        bathroom: "Kamar mandi dengan shower",
                        facilities: ["AC", "WiFi Gratis", "Kamar Mandi Pribadi", "Meja Kerja", "TV"],
                        location: "Lantai 2, Blok B"
                    },
                    {
                        id: 3,
                        name: "Kamar Executive",
                        price: 3500000,
                        rating: 5,
                        reviews: 5,
                        size: 25,
                        type: "Executive",
                        available: 2,
                        description: "Kamar mewah dengan tempat tidur king size, ruang kerja terpisah, kamar mandi mewah, dan balkon pribadi dengan pemandangan kota.",
                        image: "img/ph3.jpg",
                        bedType: "King Size Bed",
                        bathroom: "Kamar mandi mewah",
                        facilities: ["AC", "WiFi Gratis", "Kamar Mandi Mewah", "Ruang Kerja", "TV", "Balkon",
                            "Kulkas Mini"
                        ],
                        location: "Lantai 3, Blok C"
                    }
                ],
                selectedRoom: null,
                unreadMessages: 3,
                chatOpen: false,
                selectRoom(room) {
                    this.selectedRoom = room;
                },
                init() {
                    this.selectedRoom = this.rooms[0];
                }
            }
        }
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
        document.addEventListener('DOMContentLoaded', function() {
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Fungsi untuk menyembunyikan loading
            function hideLoading() {
                loadingOverlay.style.opacity = '0';
                setTimeout(() => {
                    loadingOverlay.remove();
                }, 500); // Sesuaikan dengan durasi transisi CSS
            }

            // Event ketika semua konten selesai dimuat
            window.addEventListener('load', hideLoading);

            // Fallback timeout
            setTimeout(hideLoading, 3000);
        });
    </script>
</body>

</html>
