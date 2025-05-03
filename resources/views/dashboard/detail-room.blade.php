<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANAYA KOST - Detail Kamar</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <style>
        .chat-sidebar {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .chat-sidebar.open {
            transform: translateX(0);
        }

        .sticky-sidebar {
            position: sticky;
            top: 1rem;
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

<body class="bg-gray-50" x-data="roomDetail()">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- Back Button - Left Side -->
                <div class="flex-1">
                    <a href="{{ route('listroom') }}" class="inline-flex items-center group transition-all duration-200 hover:bg-amber-700/30 rounded-lg px-3 py-2">
                        <div class="w-8 h-8 flex items-center justify-center bg-white/20 rounded-full mr-2 group-hover:bg-white/30 transition-colors duration-200">
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
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center transform translate-x-1 -translate-y-1">3</span>
                        </button>

                        <!-- Message Button -->
                        <button @click="chatOpen = !chatOpen" class="p-2 rounded-full hover:bg-white/10 relative transition-colors duration-200">
                            <i class="fas fa-envelope text-lg text-white"></i>
                            <span x-show="unreadMessages > 0" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center transform translate-x-1 -translate-y-1" x-text="unreadMessages"></span>
                        </button>

                        <!-- User Profile -->
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
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Room Detail Content -->
            <div class="w-full lg:w-2/3">
                <!-- Room Images Gallery -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="relative h-64 md:h-80 overflow-hidden">
                        <img :src="room.mainImage" alt="Kamar" class="w-full h-full object-cover">
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                            <template x-for="(img, index) in room.images" :key="index">
                                <button @click="room.mainImage = img"
                                    class="w-12 h-12 rounded overflow-hidden border-2"
                                    :class="{'border-amber-500': room.mainImage === img, 'border-transparent': room.mainImage !== img}">
                                    <img :src="img" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Room Details -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <h1 class="text-2xl font-bold text-gray-800" x-text="room.name"></h1>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                <template x-for="i in 5" :key="i">
                                    <i :class="i <= room.rating ? 'fas fa-star' : 'far fa-star'"></i>
                                </template>
                            </div>
                            <span class="text-gray-600" x-text="room.reviews + ' reviews'"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi Kamar</h2>
                            <p class="text-gray-600" x-text="room.description"></p>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-3">Spesifikasi</h2>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-center">
                                    <i class="fas fa-ruler-combined text-amber-500 w-6"></i>
                                    <span x-text="room.size + ' m²'"></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-bed text-amber-500 w-6"></i>
                                    <span x-text="room.bedType"></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-bath text-amber-500 w-6"></i>
                                    <span x-text="room.bathroom"></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-door-open text-amber-500 w-6"></i>
                                    <span x-text="room.available + ' kamar tersedia'"></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">Fasilitas Kamar</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <template x-for="(facility, index) in room.facilities" :key="index">
                                <div class="flex items-center bg-gray-50 p-3 rounded-lg">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span x-text="facility"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">Lokasi</h2>
                        <p class="text-gray-600 mb-4" x-text="room.location"></p>
                        <div class="w-full h-64 bg-gray-200 rounded-lg overflow-hidden">
                            <!-- Ganti dengan API Maps yang sesungguhnya -->
                            <img src="https://maps.googleapis.com/maps/api/staticmap?center=-6.2088,106.8456&zoom=16&size=800x400&maptype=roadmap&markers=color:red%7C-6.2088,106.8456&key=YOUR_API_KEY"
                                alt="Location Map" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="sticky-sidebar">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Pesan Kamar Ini</h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Harga per bulan:</span>
                                <span class="font-semibold" x-text="'Rp ' + room.price.toLocaleString('id-ID')"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durasi sewa:</span>
                                <div class="flex items-center space-x-2">
                                    <button @click="duration > 1 ? duration-- : duration" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center">
                                        <i class="fas fa-minus text-gray-500"></i>
                                    </button>
                                    <span x-text="duration + ' bulan'"></span>
                                    <button @click="duration++" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center">
                                        <i class="fas fa-plus text-gray-500"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="border-t border-gray-200 pt-2"></div>
                            <div class="flex justify-between font-semibold text-lg">
                                <span>Total:</span>
                                <span x-text="'Rp ' + (room.price * duration).toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <button @click="openChatWithAdmin" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition duration-300">
                            Pesan Sekarang
                        </button>

                        <div class="mt-4 text-center text-sm text-gray-500">
                            <p>Anda akan dihubungi admin untuk konfirmasi pemesanan</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Kontak Admin</h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-user text-amber-500 w-6"></i>
                                <span x-text="room.admin.name"></span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-amber-500 w-6"></i>
                                <a :href="'tel:' + room.admin.phone" x-text="room.admin.phone" class="hover:text-amber-600"></a>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-amber-500 w-6"></i>
                                <a :href="'mailto:' + room.admin.email" x-text="room.admin.email" class="hover:text-amber-600"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Sidebar -->
    <div x-show="chatOpen"
        @click.away="chatOpen = false"
        class="chat-sidebar fixed top-0 right-0 w-full md:w-96 h-full bg-white shadow-lg z-50 p-4"
        :class="{'open': chatOpen}">
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
            <h3 class="text-lg font-semibold flex items-center">
                <img :src="room.admin.avatar" class="w-8 h-8 rounded-full mr-2">
                <span x-text="room.admin.name"></span>
                <span class="ml-2 w-2 h-2 bg-green-500 rounded-full"></span>
            </h3>
            <button @click="chatOpen = false" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="chat-messages h-[calc(100%-120px)] overflow-y-auto mb-4 space-y-4">
            <template x-for="(message, index) in messages" :key="index">
                <div :class="{'flex justify-end': message.sender === 'user', 'flex': message.sender === 'admin'}">
                    <div :class="{'bg-amber-600 text-white': message.sender === 'user', 'bg-gray-100': message.sender === 'admin'}"
                        class="max-w-xs md:max-w-md rounded-lg p-3">
                        <p x-text="message.text"></p>
                        <p class="text-xs mt-1" :class="{'text-amber-200': message.sender === 'user', 'text-gray-500': message.sender === 'admin'}"
                            x-text="message.time"></p>
                    </div>
                </div>
            </template>
        </div>

        <div class="chat-input border-t border-gray-200">
            <form @submit.prevent="sendMessage" class="flex">
                <input x-model="newMessage" type="text" placeholder="Ketik pesan..."
                    class="flex-1 border border-gray-300 rounded-l-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
                <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-r-lg hover:bg-amber-700">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Loading Kanaya Kost...</div>
    </div>
    <script>
        function roomDetail() {
            return {
                chatOpen: false,
                unreadMessages: 2,
                duration: 1,
                newMessage: '',
                messages: [{
                        sender: 'admin',
                        text: 'Halo, ada yang bisa saya bantu?',
                        time: '10:30 AM'
                    },
                    {
                        sender: 'user',
                        text: 'Saya tertarik dengan kamar Executive, apakah masih tersedia untuk bulan depan?',
                        time: '10:32 AM'
                    },
                    {
                        sender: 'admin',
                        text: 'Masih tersedia 2 kamar untuk bulan depan. Untuk pemesanan bisa datang langsung atau via WhatsApp',
                        time: '10:35 AM'
                    }
                ],
                room: {
                    id: 3,
                    name: "Kamar Executive",
                    price: 3500000,
                    rating: 5,
                    reviews: 5,
                    size: 25,
                    type: "Executive",
                    available: 2,
                    description: "Kamar mewah dengan tempat tidur king size, ruang kerja terpisah, kamar mandi mewah, dan balkon pribadi dengan pemandangan kota. Kamar ini sangat cocok untuk profesional yang menginginkan kenyamanan maksimal.",
                    mainImage: "img/ph3.jpg",
                    images: ["img/ph3.jpg", "img/ph3-2.jpg", "img/ph3-3.jpg", "img/ph3-4.jpg"],
                    bedType: "King Size Bed",
                    bathroom: "Kamar mandi mewah dengan bathtub",
                    facilities: ["AC", "WiFi Gratis", "Kamar Mandi Mewah", "Ruang Kerja", "TV 32 inch", "Balkon Pribadi", "Kulkas Mini", "Lemari Besar", "Meja Rias", "Parkir Mobil"],
                    location: "Jl. Garuda No. 123, Lantai 3, Blok C, Jakarta Pusat",
                    admin: {
                        name: "Ibu Siti",
                        phone: "081234567890",
                        email: "admin@kostgaruda.com",
                        avatar: "https://randomuser.me/api/portraits/women/68.jpg"
                    }
                },
                openChatWithAdmin() {
                    this.chatOpen = true;
                    this.unreadMessages = 0;

                    // Auto reply from admin after 2 seconds
                    setTimeout(() => {
                        this.messages.push({
                            sender: 'admin',
                            text: 'Terima kasih atas minat Anda pada Kamar Executive. Berapa lama Anda ingin menyewa?',
                            time: new Date().toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            })
                        });

                        // Scroll to bottom
                        const chatContainer = document.querySelector('.chat-messages');
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    }, 2000);
                },
                sendMessage() {
                    if (this.newMessage.trim() === '') return;

                    this.messages.push({
                        sender: 'user',
                        text: this.newMessage,
                        time: new Date().toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        })
                    });

                    this.newMessage = '';

                    // Scroll to bottom
                    setTimeout(() => {
                        const chatContainer = document.querySelector('.chat-messages');
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    }, 100);
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