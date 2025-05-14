<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - KANAYA KOST</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <style>
        .profile-nav-item.active {
            background-color: #f3f4f6;
            border-left: 4px solid #f6da3b;
            color: #f6d43b;
        }
        .profile-nav-item:hover:not(.active) {
            background-color: #f9fafb;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
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
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-amber-500 to-amber-400 text-white shadow-lg">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- Back Button - Left Side -->
                <div class="flex-1">
                    <a href="{{ route($previous_url) }}" class="inline-flex items-center group transition-all duration-200 hover:bg-amber-700/30 rounded-lg px-3 py-2">
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
                            <h2 class="text-xl font-bold text-gray-800">John Doe</h2>
                            <p class="text-gray-600">Member sejak Jan 2023</p>
                        </div>
                        
                        <nav class="space-y-1">
                            <a href="#" data-section="profile-info" class="profile-nav-item active flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-user-circle mr-3 text-amber-500"></i>
                                Informasi Profil
                            </a>
                            <a href="#" data-section="rental-history" class="profile-nav-item flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-history mr-3 text-gray-500"></i>
                                Riwayat Penyewaan
                            </a>
                            <a href="#" data-section="payment-billing" class="profile-nav-item flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-credit-card mr-3 text-gray-500"></i>
                                Pembayaran & Tagihan
                            </a>
                            <a href="#" data-section="account-security" class="profile-nav-item flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-lock mr-3 text-gray-500"></i>
                                Keamanan Akun
                            </a>
                            <a href="#" data-section="settings" class="profile-nav-item flex items-center px-4 py-3 text-gray-700">
                                <i class="fas fa-cog mr-3 text-gray-500"></i>
                                Pengaturan
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
                        <button class="text-amber-600 hover:text-amber-800 flex items-center">
                            <i class="fas fa-pencil-alt mr-2"></i>
                            Edit Profil
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi Pribadi</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                                    <p class="font-medium">John Doe</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium">john.doe@example.com</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nomor Telepon</p>
                                    <p class="font-medium">+62 812 3456 7890</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Lahir</p>
                                    <p class="font-medium">15 Januari 1990</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi Kost</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Kamar Saat Ini</p>
                                    <p class="font-medium">Kamar Deluxe No. 12</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Masuk</p>
                                    <p class="font-medium">1 Februari 2023</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Durasi Sewa</p>
                                    <p class="font-medium">12 Bulan</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status Pembayaran</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Terbayar
                                    </span>
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
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg">Kamar Deluxe No. 12</h3>
                                    <p class="text-gray-600">1 Februari 2023 - 31 Januari 2024</p>
                                </div>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    Selesai
                                </span>
                            </div>
                            <div class="mt-3 flex items-center text-sm text-gray-500">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                Rp 2.500.000/bulan
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg">Kamar Standard No. 5</h3>
                                    <p class="text-gray-600">1 Maret 2022 - 28 Februari 2023</p>
                                </div>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    Selesai
                                </span>
                            </div>
                            <div class="mt-3 flex items-center text-sm text-gray-500">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                Rp 1.800.000/bulan
                            </div>
                        </div>
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Bayar</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Januari 2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 2.500.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25 Desember 2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="#" class="text-amber-600 hover:text-amber-900">Unduh Bukti</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Desember 2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 2.500.000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25 November 2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="#" class="text-amber-600 hover:text-amber-900">Unduh Bukti</a>
                                    </td>
                                </tr>
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
                                    <p class="text-gray-600">Terakhir diubah 3 bulan lalu</p>
                                </div>
                                <button class="text-amber-600 hover:text-amber-800 flex items-center">
                                    <i class="fas fa-pencil-alt mr-2"></i>
                                    Ubah
                                </button>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg">Verifikasi Email</h3>
                                    <p class="text-gray-600">Email terverifikasi</p>
                                </div>
                                <span class="text-green-600">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-bold text-lg">Verifikasi Telepon</h3>
                                    <p class="text-gray-600">Nomor telepon terverifikasi</p>
                                </div>
                                <span class="text-green-600">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengaturan -->
                <div id="settings" class="content-section bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-bold text-lg mb-3">Notifikasi</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span>Email Notifikasi</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>SMS Notifikasi</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Notifikasi Aplikasi</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-bold text-lg mb-3">Tema Aplikasi</h3>
                            <div class="flex space-x-4">
                                <button class="p-2 border-2 border-amber-500 rounded-lg">
                                    <div class="w-12 h-8 bg-amber-500 rounded"></div>
                                    <p class="text-xs mt-1">Terang</p>
                                </button>
                                <button class="p-2 border-2 border-gray-200 rounded-lg">
                                    <div class="w-12 h-8 bg-gray-800 rounded"></div>
                                    <p class="text-xs mt-1">Gelap</p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Sidebar (Hidden by default) -->
    <div x-show="chatOpen" class="fixed inset-0 overflow-hidden z-50" style="display: none;">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="chatOpen = false"></div>
            <div class="fixed inset-y-0 right-0 max-w-full flex">
                <div class="relative w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-xl">
                        <div class="flex-1 overflow-y-auto">
                            <!-- Chat header -->
                            <div class="bg-amber-600 px-4 py-6 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white">Chat dengan Admin</h2>
                                    <button @click="chatOpen = false" class="text-amber-200 hover:text-white">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Chat messages -->
                            <div class="p-4 space-y-4">
                                <!-- Chat messages would go here -->
                            </div>
                        </div>
                        <!-- Chat input -->
                        <div class="border-t border-gray-200 p-4">
                            <div class="flex items-center">
                                <input type="text" placeholder="Ketik pesan..." class="flex-1 border border-gray-300 rounded-l-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <button class="bg-amber-600 text-white px-4 py-2 rounded-r-lg hover:bg-amber-700">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Loading Kanaya Kost...</div>
    </div>
    <script>
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
            
            // Inisialisasi Alpine.js untuk chat
            document.addEventListener('alpine:init', () => {
                Alpine.data('profile', () => ({
                    chatOpen: false,
                    unreadMessages: 2,
                }))
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