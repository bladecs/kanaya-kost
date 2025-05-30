<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - KANAYA KOST</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <style>
        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

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

<body class="bg-gray-50" x-data="chatDetail()">
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

    @if (session('success') || session('error') || $errors->any())
        <div class="fixed top-4 right-4 z-50 space-y-3 notification-container">
            @if (session('success'))
                <div
                    class="notification-alert bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-start animate-fade-in">
                    <i class="fas fa-check-circle mr-3 text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    <button class="ml-4 text-white hover:text-green-100 focus:outline-none notification-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="notification-alert bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-start animate-fade-in">
                    <i class="fas fa-exclamation-circle mr-3 text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                    <button class="ml-4 text-white hover:text-red-100 focus:outline-none notification-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="notification-alert bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-start animate-fade-in">
                    <i class="fas fa-exclamation-triangle mr-3 text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="font-medium mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="ml-4 text-white hover:text-red-100 focus:outline-none notification-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Profile Sidebar -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-amber-500 h-20"></div>
                    <div class="px-4 pb-6 relative">
                        <div class="flex justify-center -mt-12 mb-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg"
                                class="w-24 h-24 rounded-full border-4 border-white object-cover shadow-md"
                                alt="Profile photo">
                        </div>
                        <div class="text-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                            <p class="text-gray-600">Member sejak {{ $user->created_at->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <nav class="space-y-1">
                            <a href="#" data-section="profile-info"
                                class="profile-nav-item active flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-user-circle mr-3 text-amber-500"></i>
                                Informasi Profil
                            </a>
                            <a href="#" data-section="rental-history"
                                class="profile-nav-item flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-history mr-3 text-gray-500"></i>
                                Riwayat Penyewaan
                            </a>
                            <a href="#" data-section="payment-billing"
                                class="profile-nav-item flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-credit-card mr-3 text-gray-500"></i>
                                Pembayaran & Tagihan
                            </a>
                            <a href="#" data-section="account-security"
                                class="profile-nav-item flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-lock mr-3 text-gray-500"></i>
                                Keamanan Akun
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="w-full lg:w-3/4">
                <!-- Informasi Profil -->
                <div id="profile-info" class="content-section active bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Informasi Profil</h1>
                        <button onclick="openEditModal()"
                            class="text-amber-600 hover:text-amber-800 flex items-center">
                            <i class="fas fa-pencil-alt mr-2"></i>
                            Edit Profil
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi
                                Pribadi</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                                    <p class="font-medium">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nomor Telepon</p>
                                    <p class="font-medium">{{ $user->phone }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi
                                Kost</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Kamar Saat Ini</p>
                                    <p class="font-medium">{{ $room->nama ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Masuk</p>
                                    <p class="font-medium"> @isset($room->updated_at)
                                            {{ $room->updated_at->translatedFormat('d F Y') }}
                                        @else
                                            -
                                        @endisset
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Durasi Sewa</p>
                                    @php
                                        $start =
                                            $room && $room->created_at
                                                ? \Carbon\Carbon::parse($room->created_at)
                                                : null;
                                        $end =
                                            $room && $room->updated_at
                                                ? \Carbon\Carbon::parse($room->updated_at)
                                                : null;
                                        $months = $start && $end ? $start->diffInMonths($end) : null;
                                        $months = $months && $months < 1 ? 1 : $months;
                                    @endphp
                                    <p class="font-medium">{{ $months !== null ? $months . ' bulan' : '-' }}</p>
                                </div>
                                @php
                                    $paymentStatus = $payment->status ?? null;
                                @endphp
                                <div>
                                    <p class="text-sm text-gray-500">Status Pembayaran</p>
                                    @if ($paymentStatus === 'pending')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($paymentStatus === 'verification')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-hourglass-half mr-1"></i>
                                            Verifikasi
                                        </span>
                                    @elseif($paymentStatus === 'done' || $paymentStatus === 'terbayar')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Terbayar
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-question-circle mr-1"></i>
                                            Tidak Diketahui
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                <div class="bg-amber-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-file-contract text-amber-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Kontrak Sewa</p>
                                    <p class="text-sm text-gray-500">1.2 MB • PDF</p>
                                </div>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-id-card text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">KTP</p>
                                    <p class="text-sm text-gray-500">0.8 MB • JPG</p>
                                </div>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4 flex items-center">
                                <div class="bg-purple-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-receipt text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Bukti Pembayaran</p>
                                    <p class="text-sm text-gray-500">1.5 MB • PDF</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Penyewaan -->
                <div id="rental-history" class="content-section bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Riwayat Penyewaan</h1>
                    </div>

                    <div class="space-y-4">
                        @foreach ($rooms as $item)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-lg">{{ $item->nama }}</h3>
                                        @php
                                            $startDate = \Carbon\Carbon::parse($item->created_at);
                                            $endDate = \Carbon\Carbon::parse($item->periode);
                                        @endphp
                                        <p class="text-gray-600">{{ $startDate->translatedFormat('d F Y') }} -
                                            {{ $endDate->translatedFormat('d F Y') }}</p>
                                    </div>
                                    @if ($item->nama == $room->nama && $item->tenant == $user->id)
                                        <span
                                            class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                            Masih Digunakan
                                        </span>
                                    @else
                                        <span
                                            class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-3 flex items-center text-sm text-gray-500">
                                    <i class="fas fa-money-bill-wave mr-2"></i>
                                    Rp {{ $payment->amount ?? '-' }}/bulan
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pembayaran & Tagihan -->
                <div id="payment-billing" class="content-section bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Pembayaran & Tagihan</h1>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bulan</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Bayar</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($payments as $item)
                                    <tr>
                                        @php
                                            $periode = \Carbon\Carbon::parse($item->periode);
                                        @endphp
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $periode->translatedFormat('F Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                            {{ $item->amount }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->updated_at->translatedFormat('d F Y') }}</td>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($item->status === 'pending')
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Menunggu Pembayaran
                                                </span>
                                            @elseif($item->status === 'pending_verification')
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-hourglass-half mr-1"></i>
                                                    Verifikasi
                                                </span>
                                            @elseif($item->status === 'paid')
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Terbayar
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-question-circle mr-1"></i>
                                                    Tidak Diketahui
                                                </span>
                                            @endif
                                        </td>
                                        @if ($item->status === 'paid')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <a href="#"
                                                    class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700 transition">Terbayar</a>
                                            </td>
                                        @elseif($item->status === 'pending_verification')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <button
                                                    class="bg-gray-600 text-white px-4 py-2 rounded cursor-not-allowed"
                                                    disabled>
                                                    Menunggu Verifikasi
                                                </button>
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <button
                                                    class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700 transition"
                                                    onclick="openVerifikasiModal('{{ $item->id }}')">
                                                    Lakukan Pembayaran
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Keamanan Akun -->
                <div id="account-security" class="content-section bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Keamanan Akun</h1>
                    </div>

                    <div class="space-y-6">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg">Kata Sandi</h3>
                                </div>
                                <button class="text-amber-600 hover:text-amber-800 flex items-center">
                                    <i class="fas fa-pencil-alt mr-2"></i>
                                    Ubah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Sidebar (Hidden by default) -->
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
    <!-- Modal Edit Profil -->
    <div id="editProfileModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75"></div>
            </div>

            <!-- Modal container -->
            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <!-- Header -->
                <div class="bg-amber-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">
                            <i class="fas fa-user-edit mr-2"></i>Edit Profil
                        </h3>
                        <button onclick="closeEditModal()" class="text-white hover:text-gray-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Foto Profil -->
                <div class="flex flex-col items-center py-6 px-6 border-b border-gray-200">
                    <div class="relative group">
                        <img id="profileImagePreview" src="https://randomuser.me/api/portraits/men/32.jpg"
                            class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg">
                        <div
                            class="absolute inset-0 bg-black bg-opacity-30 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button type="button" onclick="document.getElementById('profileImage').click()"
                                class="bg-white bg-opacity-80 hover:bg-opacity-100 p-2 rounded-full text-amber-600">
                                <i class="fas fa-camera text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <input type="file" id="profileImage" name="profileImage" accept="image/*" class="hidden">
                    <p class="mt-3 text-sm text-gray-500">Klik foto untuk mengubah</p>
                </div>

                <!-- Form -->
                <form method="post" action="{{ route('update.profile') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-4 space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                Lengkap</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="name" id="name" value="{{ $user->name }}"
                                    class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 py-3 sm:text-sm border-gray-300 rounded-md border">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ $user->email }}"
                                    class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 py-3 sm:text-sm border-gray-300 rounded-md border">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                                Telepon</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" name="phone" id="phone" value="{{ $user->phone }}"
                                    class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 py-3 sm:text-sm border-gray-300 rounded-md border">
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Password -->
    <div id="editPasswordModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75"></div>
            </div>

            <!-- Modal container -->
            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <!-- Header -->
                <div class="bg-amber-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">
                            <i class="fas fa-lock mr-2"></i>Ubah Password
                        </h3>
                        <button onclick="closePasswordModal()" class="text-white hover:text-gray-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Form -->
                <form action="" method="post">
                    @csrf
                    <div class="px-6 py-6 space-y-5">
                        <div>
                            <label for="current_password"
                                class="block text-sm font-medium text-gray-700 mb-1">Password
                                Saat Ini</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input type="password" name="current_password" id="current_password"
                                    class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 pr-10 py-3 sm:text-sm border-gray-300 rounded-md border">
                                <button type="button" onclick="togglePasswordVisibility('current_password')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="far fa-eye" id="current_password_toggle"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Password
                                Baru</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="new_password" id="new_password"
                                    class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 pr-10 py-3 sm:text-sm border-gray-300 rounded-md border">
                                <button type="button" onclick="togglePasswordVisibility('new_password')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="far fa-eye" id="new_password_toggle"></i>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                        </div>

                        <div>
                            <label for="new_password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="new_password_confirmation"
                                    id="new_password_confirmation"
                                    class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 pr-10 py-3 sm:text-sm border-gray-300 rounded-md border">
                                <button type="button" onclick="togglePasswordVisibility('new_password_confirmation')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="far fa-eye" id="new_password_confirmation_toggle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <button type="button" onclick="closePasswordModal()"
                            class="px-4 py-2.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Batal
                        </button>
                        <button type="button" onclick="savePassword()"
                            class="px-4 py-2.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi Pembayaran -->
    <div id="verifiksiPembayaran" class="fixed inset-0 z-50 overflow-y-auto hidden animate-fadeIn">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Background overlay with subtle animation -->
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity duration-300"
                aria-hidden="true"></div>

            <!-- Modal container with slide-up animation -->
            <div class="relative transform transition-all duration-300 ease-out sm:scale-100 w-full max-w-md">
                <!-- Gradient header with icon -->
                <div class="relative bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-5 rounded-t-xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-white/20 backdrop-blur-sm">
                                <i class="fas fa-receipt text-white text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                Verifikasi Pembayaran
                            </h3>
                        </div>
                        <button onclick="document.getElementById('verifiksiPembayaran').classList.add('hidden')"
                            class="py-1.5 px-3.5 rounded-full hover:bg-white/10 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white/50">
                            <i class="fas fa-times text-white text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Form container with subtle shadow -->
                <form action="{{ route('payment.verify.submit') }}" method="post" enctype="multipart/form-data"
                    class="bg-white rounded-b-xl shadow-xl">
                    @csrf
                    <input type="hidden" name="payment_id" id="payment_id_input">
                    <div class="px-6 py-6 space-y-6">
                        <!-- Upload area with hover effects -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                            <label for="bukti_pembayaran" class="group relative block w-full cursor-pointer">
                                <div
                                    class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-amber-300 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 hover:from-amber-100 hover:to-amber-50 transition-all duration-300 group-hover:border-amber-400 group-hover:shadow-sm">
                                    <div
                                        class="p-3 mb-3 rounded-full bg-amber-200/70 text-amber-600 group-hover:bg-amber-300/70 group-hover:text-amber-700 transition-colors duration-300">
                                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                    </div>
                                    <span class="text-amber-700 font-medium text-sm mb-1">Klik untuk upload</span>
                                    <span class="text-xs text-amber-600/80">Format JPG, PNG, atau PDF (Maks.
                                        2MB)</span>
                                </div>
                                <input type="file" id="bukti_pembayaran" name="bukti_pembayaran"
                                    accept="image/*" class="hidden" required>
                            </label>

                            <!-- Preview container (will be shown after file selection) -->
                            <div id="file-preview" class="hidden mt-4">
                                <div class="flex items-center p-3 bg-green-50 rounded-lg border border-green-200">
                                    <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-green-800 truncate" id="file-name">
                                            filename.jpg</p>
                                        <p class="text-xs text-green-600" id="file-size">1.2MB</p>
                                    </div>
                                    <button type="button" class="text-green-600 hover:text-green-800"
                                        id="remove-file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Notes with floating label -->
                        <div class="relative">
                            <textarea name="catatan" id="catatan" rows="3"
                                class="peer pt-3 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 placeholder-transparent"
                                placeholder=" "></textarea>
                            <label for="catatan"
                                class="absolute left-3 -top-2.5 bg-white px-1.5 text-sm text-gray-500 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:left-3 peer-focus:-top-2.5 peer-focus:left-3 peer-focus:text-sm peer-focus:text-amber-600">
                                Catatan (Opsional)
                            </label>
                        </div>
                    </div>

                    <!-- Footer with button animation -->
                    <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end space-x-3">
                        <button type="button"
                            onclick="document.getElementById('verifiksiPembayaran').classList.add('hidden')"
                            class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-md active:translate-y-0">
                            <span class="flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Verifikasi
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Preview gambar bukti pembayaran
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('bukti_pembayaran');
            if (input) {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            document.getElementById('buktiPembayaranPreview').src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        document.getElementById('buktiPembayaranPreview').src =
                            "{{ asset('img/placeholder-payment.png') }}";
                    }
                });
            }
        });
    </script>

    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Loading Kanaya Kost...</div>
    </div>
    <script>
        console.log('data user:', @json($user));
        console.log('data payment:', @json($payment));
        document.addEventListener('DOMContentLoaded', function() {
            // Tangani klik pada menu sidebar
            const navItems = document.querySelectorAll('.profile-nav-item');
            const contentSections = document.querySelectorAll('.content-section');

            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Hapus kelas active dari semua nav item
                    navItems.forEach(navItem => {
                        navItem.classList.remove('active');
                        navItem.querySelector('i').classList.remove('text-amber-500');
                        navItem.querySelector('i').classList.add('text-gray-500');
                    });

                    // Tambahkan kelas active ke nav item yang diklik
                    this.classList.add('active');
                    this.querySelector('i').classList.remove('text-gray-500');
                    this.querySelector('i').classList.add('text-amber-500');

                    // Dapatkan section yang sesuai
                    const targetSection = this.getAttribute('data-section');

                    // Sembunyikan semua content section
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                    });

                    // Tampilkan section yang dipilih
                    document.getElementById(targetSection).classList.add('active');
                });
            });
        });
    </script>
    <script>
        function chatDetail() {
            return {
                chatOpen: false,
                unreadMessages: 0,
                newMessage: '',
                messages: [],
                autoMessage: '',
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
    <script>
        // Fungsi untuk modal edit profil
        function openEditModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
        }

        // Fungsi untuk modal edit password
        function openPasswordModal() {
            document.getElementById('editPasswordModal').classList.remove('hidden');
        }

        function closePasswordModal() {
            document.getElementById('editPasswordModal').classList.add('hidden');
        }

        function openVerifikasiModal(paymentId) {
            const modal = document.getElementById('verifiksiPembayaran');
            document.getElementById('payment_id_input').value = paymentId;
            modal.classList.remove('hidden');
        }

        // Fungsi untuk preview gambar profil
        document.getElementById('profileImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profileImagePreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Fungsi untuk menyimpan profil
        function saveProfile() {
            const form = document.getElementById('editProfileForm');
            const formData = new FormData(form);

            // Tambahkan file gambar jika ada
            const imageInput = document.getElementById('profileImage');
            if (imageInput.files.length > 0) {
                formData.append('profile_image', imageInput.files[0]);
            }

            // Simulasi AJAX request
            console.log('Mengirim data:', Object.fromEntries(formData));

            // Tampilkan loading
            showLoading();

            // Simulasi proses async
            setTimeout(() => {
                // Update data di tampilan
                document.querySelector('#profile-info .font-medium:nth-of-type(1)').textContent =
                    document.getElementById('name').value;
                document.querySelector('#profile-info .font-medium:nth-of-type(2)').textContent =
                    document.getElementById('email').value;
                document.querySelector('#profile-info .font-medium:nth-of-type(3)').textContent =
                    document.getElementById('phone').value;

                // Tutup modal
                closeEditModal();
                hideLoading();

                // Tampilkan notifikasi sukses
                alert('Profil berhasil diperbarui!');
            }, 1500);
        }

        // Fungsi untuk menyimpan password
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(fieldId + '_toggle');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Fungsi untuk validasi dan simpan password
        function savePassword() {
            const current = document.getElementById('current_password').value;
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('new_password_confirmation').value;

            if (!current) {
                showAlert('error', 'Harap masukkan password saat ini');
                return false;
            }

            if (newPass.length < 8) {
                showAlert('error', 'Password baru harus minimal 8 karakter');
                return false;
            }

            if (newPass !== confirmPass) {
                showAlert('error', 'Konfirmasi password tidak sesuai');
                return false;
            }

            showLoading();

            // Simulasi proses async
            setTimeout(() => {
                closePasswordModal();
                hideLoading();
                showAlert('success', 'Password berhasil diubah!');

                // Reset form
                document.getElementById('current_password').value = '';
                document.getElementById('new_password').value = '';
                document.getElementById('new_password_confirmation').value = '';

                // Reset visibility icon
                document.querySelectorAll('[id$="_toggle"]').forEach(icon => {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                });
            }, 1500);
        }

        // Fungsi untuk menampilkan notifikasi
        function showAlert(type, message) {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle'
            };

            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-4 right-4 z-50`;
            alertDiv.innerHTML = `
            <div class="${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-fade-in-down">
                <i class="fas ${icons[type]} mr-2 text-xl"></i>
                <span>${message}</span>
            </div>
        `;

            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.querySelector('.animate-fade-in-down').classList.add('animate-fade-out-up');
                setTimeout(() => {
                    alertDiv.remove();
                }, 500);
            }, 3000);
        }

        // Fungsi untuk menampilkan loading
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
            setTimeout(() => {
                document.getElementById('loadingOverlay').style.opacity = '1';
            }, 10);
        }

        // Fungsi untuk menyembunyikan loading
        function hideLoading() {
            document.getElementById('loadingOverlay').style.opacity = '0';
            setTimeout(() => {
                document.getElementById('loadingOverlay').style.display = 'none';
            }, 500);
        }

        // Tambahkan event listener untuk tombol ubah password di bagian keamanan akun
        document.addEventListener('DOMContentLoaded', function() {
            const passwordEditBtn = document.querySelector('#account-security button');
            if (passwordEditBtn) {
                passwordEditBtn.addEventListener('click', openPasswordModal);
            }

            // Preview gambar saat modal dibuka
            document.getElementById('profileImage').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        document.getElementById('profileImagePreview').src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <script>
        document.getElementById('profileImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profileImagePreview').src = event.target.result;

                    // Tampilkan notifikasi kecil
                    const notification = document.createElement('div');
                    notification.className =
                        'absolute top-0 right-0 bg-green-500 text-white text-xs px-2 py-1 rounded-full animate-bounce';
                    notification.innerHTML = '<i class="fas fa-check mr-1"></i> Foto dipilih';
                    document.querySelector('.group.relative').appendChild(notification);

                    // Hilangkan notifikasi setelah 2 detik
                    setTimeout(() => {
                        notification.remove();
                    }, 2000);
                };
                reader.readAsDataURL(file);
            }
        });

        // Validasi password sebelum menyimpan
        function validatePassword() {
            const current = document.getElementById('current_password').value;
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('new_password_confirmation').value;

            if (!current) {
                alert('Harap masukkan password saat ini');
                return false;
            }

            if (newPass.length < 8) {
                alert('Password baru harus minimal 8 karakter');
                return false;
            }

            if (newPass !== confirmPass) {
                alert('Konfirmasi password tidak sesuai');
                return false;
            }

            return true;
        }

        // Fungsi savePassword yang diperbarui
        function savePassword() {
            if (!validatePassword()) return;

            showLoading();

            // Simulasi proses async
            setTimeout(() => {
                closePasswordModal();
                hideLoading();

                // Tampilkan notifikasi sukses
                const successAlert = `
                <div class="fixed top-4 right-4 z-50">
                    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-fade-in-down">
                        <i class="fas fa-check-circle mr-2 text-xl"></i>
                        <span>Password berhasil diubah!</span>
                    </div>
                </div>
            `;
                document.body.insertAdjacentHTML('beforeend', successAlert);

                // Hilangkan notifikasi setelah 3 detik
                setTimeout(() => {
                    document.querySelector('.animate-fade-in-down').classList.add('animate-fade-out-up');
                    setTimeout(() => {
                        document.querySelector('.fixed.top-4.right-4').remove();
                    }, 500);
                }, 3000);
            }, 1500);
        }

        // Fungsi saveProfile yang diperbarui
        function saveProfile() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            if (!name || !email) {
                alert('Nama dan email harus diisi');
                return;
            }

            showLoading();

            // Simulasi proses async
            setTimeout(() => {
                // Update data di tampilan
                document.querySelector('#profile-info .font-medium:nth-of-type(1)').textContent = name;
                document.querySelector('#profile-info .font-medium:nth-of-type(2)').textContent = email;
                document.querySelector('#profile-info .font-medium:nth-of-type(3)').textContent = phone;

                closeEditModal();
                hideLoading();

                const successAlert = `
                <div class="fixed top-4 right-4 z-50">
                    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-fade-in-down">
                        <i class="fas fa-check-circle mr-2 text-xl"></i>
                        <span>Profil berhasil diperbarui!</span>
                    </div>
                </div>
            `;
                document.body.insertAdjacentHTML('beforeend', successAlert);
                setTimeout(() => {
                    document.querySelector('.animate-fade-in-down').classList.add('animate-fade-out-up');
                    setTimeout(() => {
                        document.querySelector('.fixed.top-4.right-4').remove();
                    }, 500);
                }, 3000);
            }, 1500);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide notifications after 5 seconds
            const notifications = document.querySelectorAll('.notification-alert');
            notifications.forEach(notification => {
                const timer = setTimeout(() => {
                    hideNotification(notification);
                }, 5000);

                // Store timer on element so we can clear it if manually closed
                notification.dataset.timer = timer;
            });

            // Close button functionality
            document.querySelectorAll('.notification-close').forEach(button => {
                button.addEventListener('click', function() {
                    const notification = this.closest('.notification-alert');
                    clearTimeout(notification.dataset.timer);
                    hideNotification(notification);
                });
            });

            function hideNotification(notification) {
                notification.classList.remove('animate-fade-in');
                notification.classList.add('animate-fade-out');

                setTimeout(() => {
                    notification.remove();
                    if (document.querySelectorAll('.notification-alert').length === 0) {
                        document.querySelector('.notification-container').remove();
                    }
                }, 300);
            }
        });
    </script>
    <script>
        document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('file-preview');
                document.getElementById('file-name').textContent = file.name;
                document.getElementById('file-size').textContent = (file.size / (1024 * 1024)).toFixed(2) + 'MB';
                preview.classList.remove('hidden');
            }
        });

        document.getElementById('remove-file').addEventListener('click', function() {
            document.getElementById('bukti_pembayaran').value = '';
            document.getElementById('file-preview').classList.add('hidden');
        });
    </script>
</body>

</html>
