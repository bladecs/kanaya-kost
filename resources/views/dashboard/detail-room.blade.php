<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    </style>
</head>

<body class="bg-gray-50" x-data="roomDetail()">
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
                        <!-- Message Button -->
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
                                    <a href="#" @click.prevent="dropdownOpen = false; $dispatch('open-chat')"
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

                        <!-- User Profile -->
                        <div x-data="{ open: false }" class="relative">
                            @auth
                                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                    <div class="relative">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://randomuser.me/api/portraits/men/32.jpg" alt="User profile">
                                    </div>
                                    <span class="hidden md:inline-block">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                        :class="{ 'transform rotate-180': open }"></i>
                                </button>
                            @else
                                <a href="{{ route('login.page') }}"
                                    class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600">
                                    Login
                                </a>
                            @endauth

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 dropdown-menu"
                                :class="{ 'show': open }">
                                <a href="{{ route('profileuser') }}?previous={{ urlencode(request()->path()) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 cursor-pointer">
                                    <i class="fas fa-user mr-2 text-gray-500"></i> Profile
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
                                    :class="{
                                        'border-amber-500': room.mainImage === img,
                                        'border-transparent': room
                                            .mainImage !== img
                                    }">
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
                                <span class="font-semibold"
                                    x-text="'Rp ' + room.price.toLocaleString('id-ID')"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durasi sewa:</span>
                                <div class="flex items-center space-x-2">
                                    <button @click="duration > 1 ? duration-- : duration"
                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center">
                                        <i class="fas fa-minus text-gray-500"></i>
                                    </button>
                                    <span x-text="duration + ' bulan'"></span>
                                    <button @click="duration++"
                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center">
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

                        @auth
                            @if ($available_rooms <= 0)
                                <button
                                    class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition duration-300"
                                    disabled>
                                    Kamar sudah penuh
                                </button>
                            @else
                                <button @click="openChatWithAdmin"
                                    class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition duration-300">
                                    Pesan Sekarang
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login.page', ['previous' => url()->current()]) }}"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-medium transition duration-300 text-center block">
                                Login untuk Pesan
                            </a>
                        @endauth

                        <div class="mt-4 text-center text-sm text-gray-500">
                            <p>Anda akan dihubungi admin untuk konfirmasi pemesanan</p>
                        </div>
                    </div>
                </div>
            </div>
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
                messages: [],
                autoMessage: '',
                room: {
                    name: "Kamar Normal",
                    price: 1500000,
                    rating: 5,
                    reviews: 5,
                    type: "Normal",
                    available: @json($available_rooms),
                    description: "Kamar dengan tempat tidur single size, kamar mandi dengan shower, dan balkon dilantai 3 dan 4 dengan pemandangan kota. Kamar ini sangat cocok untuk pekerjaa maupun mahasiswa yang menginginkan kenyamanan maksimal.",
                    mainImage: "img/isi kamar (2).jpg",
                    images: ["img/isi kamar (2).jpg", "img/isi kamar (3).jpg", "img/toilet.jpg", "img/balkon lantai 3.jpg",
                        "img/balkon lantai 4.jpg", "img/parkiran dalam (2).jpg", "img/lorong lantai 4.jpg"
                    ],
                    bedType: "Single Size Bed",
                    bathroom: "Kamar mandi dengan shower",
                    facilities: ["AC", "WiFi Gratis", "Kamar Mandi Dalam", "Balkon", "Lemari Besar", "Parkir Mobil",
                        "Wastafel"
                    ],
                    location: "Jl. Garuda No. 123, Lantai 3, Blok C, Jakarta Pusat",
                    admin: {
                        name: "Ibu Siti",
                        phone: "081234567890",
                        email: "admin@kostgaruda.com",
                        avatar: "https://randomuser.me/api/portraits/women/68.jpg"
                    }
                },
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
                openChatWithAdmin() {
                    this.chatOpen = true;
                    this.unreadMessages = 0;

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
                                content: `Halo admin, saya ingin memesan kamar ini untuk ${this.duration} bulan. Apakah kamar masih tersedia?`
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
                            this.messages.push({
                                sender: 'user',
                                text: `Halo admin, saya ingin memesan kamar ini untuk ${this.duration} bulan. Apakah kamar masih tersedia?`,
                                time: new Date().toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal mengirim pesan: ' + (error.message ||
                                'Terjadi kesalahan'));
                        });
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
