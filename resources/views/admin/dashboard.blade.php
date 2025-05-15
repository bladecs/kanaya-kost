<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Kost Garuda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .payment-status.pending {
            background-color: #fef3c7;
            color: #d97706;
        }

        .payment-status.paid {
            background-color: #d1fae5;
            color: #059669;
        }

        .payment-status.late {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .sidebar-item.active {
            background-color: #e0f2fe;
            border-left: 4px solid #e2b34c;
            color: #e6c018;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                transition: left 0.3s ease;
                z-index: 50;
            }

            .sidebar.open {
                left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }

            .overlay.open {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-gray-100" x-data="adminApp()">
    <!-- Admin Layout -->
    <div class="flex h-screen">
        <!-- Mobile Overlay -->
        <div class="overlay" :class="{ 'open': mobileSidebarOpen }" @click="mobileSidebarOpen = false"></div>

        <!-- Sidebar -->
        <div class="sidebar w-64 bg-amber-500 text-white shadow-lg" :class="{ 'open': mobileSidebarOpen }">
            <div class="p-4 flex items-center justify-between border-b border-amber-600">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-home text-2xl"></i>
                    <h1 class="text-xl font-bold">Kost Garuda</h1>
                </div>
                <button @click="mobileSidebarOpen = false" class="md:hidden text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="p-4 space-y-1">
                <a href="#" @click="activeTab = 'dashboard'; mobileSidebarOpen = false"
                    class="sidebar-item flex items-center px-4 py-3 rounded-lg"
                    :class="{ 'active': activeTab === 'dashboard' }">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="#" @click="activeTab = 'message'; mobileSidebarOpen = false"
                    class="sidebar-item flex items-center px-4 py-3 rounded-lg"
                    :class="{ 'active': activeTab === 'message' }">
                    <i class="fas fa-envelope mr-3"></i>
                    Message
                </a>
                <a href="#" @click="activeTab = 'payments'; mobileSidebarOpen = false"
                    class="sidebar-item flex items-center px-4 py-3 rounded-lg"
                    :class="{ 'active': activeTab === 'payments' }">
                    <i class="fas fa-money-bill-wave mr-3"></i>
                    Verifikasi Pembayaran
                </a>
                <a href="#" @click="activeTab = 'tenants'; mobileSidebarOpen = false"
                    class="sidebar-item flex items-center px-4 py-3 rounded-lg"
                    :class="{ 'active': activeTab === 'tenants' }">
                    <i class="fas fa-users mr-3"></i>
                    Data Penghuni
                </a>
                <a href="#" @click="activeTab = 'rooms'; mobileSidebarOpen = false"
                    class="sidebar-item flex items-center px-4 py-3 rounded-lg"
                    :class="{ 'active': activeTab === 'rooms' }">
                    <i class="fas fa-door-open mr-3"></i>
                    Manajemen Kamar
                </a>
                <a href="#" @click="activeTab = 'reports'; mobileSidebarOpen = false"
                    class="sidebar-item flex items-center px-4 py-3 rounded-lg"
                    :class="{ 'active': activeTab === 'reports' }">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Laporan
                </a>
            </nav>

            <!-- Logout Button -->
            <div class="relative left-0 right-0 p-4 border-t border-amber-600">
                <button @click="logout()"
                    class="w-full flex items-center px-4 py-3 rounded-lg text-red-200 hover:bg-amber-600 hover:text-white">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Keluar
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center">
                        <button @click="mobileSidebarOpen = true" class="mr-4 md:hidden text-gray-600">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800"
                            x-text="
                            activeTab === 'dashboard' ? 'Dashboard' : 
                            activeTab === 'message' ? 'Message' :
                            activeTab === 'payments' ? 'Verifikasi Pembayaran' :
                            activeTab === 'tenants' ? 'Data Penghuni' :
                            activeTab === 'rooms' ? 'Manajemen Kamar' : 'Laporan'
                        ">
                        </h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="p-2 rounded-full hover:bg-gray-100">
                                <i class="fas fa-bell text-gray-600"></i>
                                <span
                                    class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        <div class="relative">
                            <button @click="profileDropdownOpen = !profileDropdownOpen"
                                class="flex items-center space-x-2">
                                <img src="https://randomuser.me/api/portraits/men/42.jpg" class="w-8 h-8 rounded-full">
                                <span class="hidden md:inline-block">Admin</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="profileDropdownOpen" @click.outside="profileDropdownOpen = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                                style="display: none;">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil
                                    Saya</a>
                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div x-data="{ showNotification: @json(session('notification') ? true : false) }" x-init="if (showNotification) {
                setTimeout(() => showNotification = false, 10000)
            }">
                <!-- Notifikasi -->
                <div x-show="showNotification" x-transition class="fixed top-4 right-4 z-50">
                    <div x-show="showNotification" x-transition
                        class="flex items-center p-4 w-full max-w-xs rounded-lg shadow
                   @if (session('notification.type') === 'success') bg-green-100 text-green-800
                   @else bg-red-100 text-red-800 @endif">
                        <div class="ml-3 text-sm font-normal">
                            {{ session('notification.message') }}
                        </div>
                        <button @click="showNotification = false"
                            class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8
                          @if (session('notification.type') === 'success') hover:bg-green-200
                          @else hover:bg-red-200 @endif">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Dashboard Content -->
                <div x-show="activeTab === 'dashboard'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <!-- Stat Cards -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-amber-100 text-amber-500 mr-4">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500">Total Penghuni</p>
                                    <h3 class="text-2xl font-bold" x-text="stats.totalTenants"></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                    <i class="fas fa-door-open text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500">Kamar Terisi</p>
                                    <h3 class="text-2xl font-bold"
                                        x-text="`${stats.occupiedRooms}/${stats.totalRooms}`"></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                                    <i class="fas fa-money-bill-wave text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500">Pembayaran Bulan Ini</p>
                                    <h3 class="text-2xl font-bold"
                                        x-text="`${stats.paidThisMonth}/${stats.totalPayments}`"></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                                    <i class="fas fa-exclamation-triangle text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500">Pembayaran Telat</p>
                                    <h3 class="text-2xl font-bold" x-text="stats.latePayments"></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Recent Payments -->
                        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold mb-4">Pembayaran Terbaru</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                ID</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Penghuni</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Jumlah</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="payment in recentPayments" :key="payment.id">
                                            <tr class="hover:bg-gray-50 cursor-pointer"
                                                @click="viewPayment(payment.id)">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                                    x-text="payment.id"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                                    x-text="payment.tenant.name"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                                    x-text="'Rp ' + payment.amount.toLocaleString('id-ID')"></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full payment-status"
                                                        :class="payment.status"
                                                        x-text="payment.status === 'pending' ? 'Menunggu' : payment.status === 'paid' ? 'Lunas' : 'Terlambat'"></span>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Occupancy Rate -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold mb-4">Tingkat Hunian</h3>
                            <div class="flex justify-center">
                                <div class="relative w-48 h-48">
                                    <svg class="w-full h-full" viewBox="0 0 36 36">
                                        <path d="M18 2.0845
                                          a 15.9155 15.9155 0 0 1 0 31.831
                                          a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e6e6e6"
                                            stroke-width="3" stroke-dasharray="100, 100" />
                                        <path d="M18 2.0845
                                          a 15.9155 15.9155 0 0 1 0 31.831
                                          a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#3b82f6"
                                            stroke-width="3" :stroke-dasharray="`${stats.occupancyRate}, 100`" />
                                        <text x="18" y="20.5" text-anchor="middle" font-size="6" fill="#3b82f6"
                                            x-text="`${stats.occupancyRate}%`"></text>
                                        <text x="18" y="25" text-anchor="middle" font-size="3"
                                            fill="#6b7280">Hunian</text>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 text-center text-sm text-gray-500">
                                <p x-text="`${stats.occupiedRooms} dari ${stats.totalRooms} kamar terisi`"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Chart -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Statistik Pembayaran 6 Bulan Terakhir</h3>
                        <div class="h-64">
                            <!-- Chart placeholder - you would integrate a real chart library here -->
                            <div class="flex items-end h-48 border-b border-l border-gray-200">
                                <template x-for="month in paymentStats">
                                    <div class="flex-1 flex flex-col items-center px-2">
                                        <div class="w-8 bg-amber-500 rounded-t"
                                            :style="`height: ${month.paid/200000}%`" title="Lunas"></div>
                                        <div class="w-8 bg-yellow-500" :style="`height: ${month.pending/200000}%`"
                                            title="Menunggu"></div>
                                        <div class="w-8 bg-red-500 rounded-b" :style="`height: ${month.late/200000}%`"
                                            title="Terlambat"></div>
                                        <p class="text-xs mt-2" x-text="month.month"></p>
                                    </div>
                                </template>
                            </div>
                            <div class="flex justify-center mt-4 space-x-4">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-amber-500 rounded mr-1"></div>
                                    <span class="text-xs">Lunas</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded mr-1"></div>
                                    <span class="text-xs">Menunggu</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded mr-1"></div>
                                    <span class="text-xs">Terlambat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Content -->
                <div x-show="activeTab === 'message'" x-transition>
                    <div class="flex h-[70vh] bg-white shadow rounded-lg overflow-hidden">
                        <!-- Sidebar: List of Chats -->
                        <div class="w-72 border-r bg-amber-50 flex flex-col">
                            <div class="p-4 border-b flex items-center space-x-2">
                                <i class="fas fa-comments text-2xl text-amber-500"></i>
                                <span class="font-semibold text-gray-800">Daftar Chat</span>
                            </div>
                            <div class="p-2 relative">
                                <input type="text" placeholder="Cari user..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-search absolute left-5 top-5 text-gray-400"></i>
                            </div>
                            <div class="flex-1 overflow-y-auto">
                                <template x-for="chatItem in messages_list" :key="chatItem.user_id">
                                    <div @click="chatOpen = chatItem.user_id"
                                        :class="chatOpen === chatItem.user_id ? 'bg-amber-100' : 'hover:bg-amber-200'"
                                        class="flex items-center px-4 py-3 cursor-pointer border-b space-x-3 transition">
                                        <img :src="chatItem.user && chatItem.user.photo ? chatItem.user.photo :
                                            'https://randomuser.me/api/portraits/men/1.jpg'"
                                            class="w-10 h-10 rounded-full border border-amber-200 shadow">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-800"
                                                x-text="chatItem.user ? chatItem.user.name : 'User'"></div>
                                            <div class="text-xs text-gray-500 truncate"
                                                x-text="chatItem.last_message"></div>
                                        </div>
                                        <span class="text-xs text-gray-400"
                                            x-text="formatTime(chatItem.updated_at)"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <!-- Chat Body -->
                        <div class="flex-1 flex flex-col">
                            <template x-if="chatOpen">
                                <div class="flex flex-col h-full">
                                    <!-- Chat Header -->
                                    <div class="flex items-center px-6 py-4 border-b bg-amber-50">
                                        <img :src="messages_list.find(c => c.user_id === chatOpen)?.user?.photo ||
                                            'https://randomuser.me/api/portraits/men/1.jpg'"
                                            class="w-10 h-10 rounded-full border border-amber-200 shadow mr-3">
                                        <div>
                                            <div class="font-semibold text-gray-800"
                                                x-text="messages_list.find(c => c.user_id === chatOpen)?.user?.name || 'User'">
                                            </div>
                                            <div class="text-xs text-gray-500"
                                                x-text="messages_list.find(c => c.user_id === chatOpen)?.user?.phone || ''">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Messages -->
                                    <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4" x-ref="messagesContainer">
                                        <template x-for="msg in chat.filter(m => m.user_id === chatOpen)"
                                            :key="msg.id">
                                            <div :class="msg.is_admin ? 'flex justify-end' : 'flex justify-start'">
                                                <div class="flex items-end space-x-2"
                                                    :class="msg.is_admin ? 'flex-row-reverse space-x-reverse' : ''">
                                                    <img :src="msg.is_admin ?
                                                        'https://randomuser.me/api/portraits/men/42.jpg' :
                                                        (messages_list.find(c => c.user_id === chatOpen)?.user?.photo ||
                                                            'https://randomuser.me/api/portraits/women/1.jpg')"
                                                        class="w-8 h-8 rounded-full border border-amber-200 shadow">
                                                    <div>
                                                        <div :class="msg.is_admin ? 'bg-amber-500 text-white' :
                                                            'bg-gray-100 text-gray-800'"
                                                            class="px-4 py-2 rounded-2xl shadow max-w-xs break-words">
                                                            <span x-text="msg.content"></span>
                                                        </div>
                                                        <div class="text-xs text-gray-400 mt-1"
                                                            x-text="formatTime(msg.created_at)"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <!-- Chat Input -->
                                    <div class="px-6 py-4 border-t bg-gray-50">
                                        <form @submit.prevent="sendMessage" class="flex items-center space-x-2">
                                            <input type="text" x-model="newMessage" placeholder="Ketik pesan..."
                                                class="flex-1 px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-amber-500"
                                                autocomplete="off">
                                            <button type="submit"
                                                class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-full shadow transition">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </template>
                            <template x-if="!chatOpen">
                                <div class="flex flex-1 items-center justify-center text-gray-400">
                                    <span>Pilih chat di sebelah kiri untuk mulai percakapan</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Payment Verification Content -->
                <div x-show="activeTab === 'payments'" x-transition>
                    <!-- Existing payment verification content -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Pembayaran</h3>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <input type="text" placeholder="Cari penghuni..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            <select x-model="paymentFilter"
                                class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <option value="all">Semua Status</option>
                                <option value="pending">Menunggu Verifikasi</option>
                                <option value="paid">Terverifikasi</option>
                                <option value="late">Terlambat</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID Pembayaran
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Penghuni
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kamar
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Periode
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="payment in filteredPayments" :key="payment.id">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                            x-text="payment.id"></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" :src="payment.tenant.photo"
                                                        :alt="payment.tenant.name">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"
                                                        x-text="payment.tenant.name"></div>
                                                    <div class="text-sm text-gray-500" x-text="payment.tenant.phone">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            x-text="payment.room"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            x-text="payment.period"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            x-text="'Rp ' + payment.amount.toLocaleString('id-ID')"></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full payment-status"
                                                :class="payment.status">
                                                <span
                                                    x-text="payment.status === 'pending' ? 'Menunggu' : 
                                                       payment.status === 'paid' ? 'Lunas' : 'Terlambat'"></span>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <template x-if="payment.status === 'pending'">
                                                <div class="flex space-x-2">
                                                    <button @click="verifyPayment(payment.id)"
                                                        class="text-green-600 hover:text-green-900">
                                                        <i class="fas fa-check-circle mr-1"></i> Verifikasi
                                                    </button>
                                                    <button @click="rejectPayment(payment.id)"
                                                        class="text-red-600 hover:text-red-900">
                                                        <i class="fas fa-times-circle mr-1"></i> Tolak
                                                    </button>
                                                    <button @click="viewPayment(payment.id)"
                                                        class="text-amber-500 hover:text-amber-900">
                                                        <i class="fas fa-eye mr-1"></i> Lihat
                                                    </button>
                                                </div>
                                            </template>
                                            <template x-if="payment.status !== 'pending'">
                                                <button @click="viewPayment(payment.id)"
                                                    class="text-amber-500 hover:text-amber-900">
                                                    <i class="fas fa-eye mr-1"></i> Detail
                                                </button>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Menampilkan <span x-text="filteredPayments.length"></span> dari <span
                                x-text="payments.length"></span> pembayaran
                        </div>
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Sebelumnya
                            </button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Selanjutnya
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tenants Content -->
                <div x-show="activeTab === 'tenants'" x-transition>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Data Penghuni</h3>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <input type="text" placeholder="Cari penghuni..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            <button @click="showAddTenantModal = true"
                                class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-plus mr-2"></i>Tambah Penghuni
                            </button>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kamar
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kontak
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Masuk
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="tenant in tenants" :key="tenant.id">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" :src="tenant.photo"
                                                        :alt="tenant.name">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"
                                                        x-text="tenant.name"></div>
                                                    <div class="text-sm text-gray-500" x-text="tenant.idNumber"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            x-text="tenant.room"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div x-text="tenant.phone"></div>
                                            <div x-text="tenant.email"></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            x-text="new Date(tenant.created_at).toISOString().split('T')[0]"></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="tenant.status === 1 ? 'bg-green-100 text-green-800' :
                                                    'bg-red-100 text-red-800'"
                                                x-text="tenant.status === 1 ? 'Aktif' : 'Nonaktif'"></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button @click="viewTenant(tenant.id)"
                                                    class="text-amber-500 hover:text-amber-900">
                                                    <i class="fas fa-eye mr-1"></i> Lihat
                                                </button>
                                                <button @click="editTenant(tenant.id)"
                                                    class="text-yellow-600 hover:text-yellow-900">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </button>
                                                <button @click="confirmDeleteTenant(tenant.id)"
                                                    class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Menampilkan <span x-text="tenants.length"></span> penghuni
                        </div>
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Sebelumnya
                            </button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Selanjutnya
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rooms Content -->
                <div x-show="activeTab === 'rooms'" x-transition>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Manajemen Kamar</h3>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <input type="text" placeholder="Cari kamar..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            <button @click="showAddRoomModal = true"
                                class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-plus mr-2"></i>Tambah Kamar
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="room in rooms" :key="room.nama">
                            <div class="bg-white shadow rounded-lg overflow-hidden">
                                <div class="p-4 border-b">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-lg font-semibold" x-text="'Kamar ' + room.nama"></h4>
                                        <span class="px-2 py-1 text-xs rounded-full"
                                            :class="room.available === 1 ? 'bg-green-100 text-green-800' :
                                                'bg-amber-100 text-amber-500'"
                                            x-text="room.available === 1 ? 'Terisi' : 'Kosong'"></span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Harga Sewa</span>
                                        <span class="font-medium"
                                            x-text="'Rp ' + room.price.toLocaleString('id-ID') + '/bulan'"></span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Fasilitas</span>
                                        <div class="flex flex-wrap justify-end gap-1">
                                            <template x-for="facility in room.facilities" :key="facility.id">
                                                <span class="text-xs bg-gray-100 px-2 py-1 rounded"
                                                    x-text="facility.name"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="flex justify-between py-2" x-show="room.available === true">
                                        <span class="text-gray-600">Penghuni</span>
                                        <span x-text="room.tenant || '-'"></span>
                                    </div>
                                </div>
                                <div class="px-4 py-3 flex justify-end space-x-2">
                                    <button @click="showUpdateRoomModal = true; selectedRoom = room"
                                        class="text-yellow-600 hover:text-yellow-800">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                    <button @click="showDeleteRoomModal = true; selectedRoom = room"
                                        class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Reports Content -->
                <div x-show="activeTab === 'reports'" x-transition>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Laporan</h3>
                        <div class="flex space-x-2">
                            <select
                                class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <option>Pilih Laporan</option>
                                <option>Laporan Pembayaran</option>
                                <option>Laporan Penghuni</option>
                                <option>Laporan Keuangan</option>
                            </select>
                            <select
                                class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <option>Bulan Ini</option>
                                <option>3 Bulan Terakhir</option>
                                <option>6 Bulan Terakhir</option>
                                <option>Tahun Ini</option>
                            </select>
                            <button
                                class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <i class="fas fa-download mr-2"></i>Unduh
                            </button>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6 mb-6">
                        <h4 class="text-lg font-semibold mb-4">Ringkasan Keuangan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="border rounded-lg p-4">
                                <h5 class="text-gray-500 mb-2">Pendapatan Bulan Ini</h5>
                                <p class="text-2xl font-bold text-green-600"
                                    x-text="'Rp ' + financialSummary.currentMonth.toLocaleString('id-ID')"></p>
                                <p class="text-sm text-gray-500 mt-1"
                                    x-text="'± ' + financialSummary.percentageChange + '% dari bulan lalu'"></p>
                            </div>
                            <div class="border rounded-lg p-4">
                                <h5 class="text-gray-500 mb-2">Pendapatan Tahun Ini</h5>
                                <p class="text-2xl font-bold text-amber-500"
                                    x-text="'Rp ' + financialSummary.yearToDate.toLocaleString('id-ID')"></p>
                                <p class="text-sm text-gray-500 mt-1"
                                    x-text="'± ' + financialSummary.yearPercentageChange + '% dari tahun lalu'"></p>
                            </div>
                            <div class="border rounded-lg p-4">
                                <h5 class="text-gray-500 mb-2">Pembayaran Tertunda</h5>
                                <p class="text-2xl font-bold text-red-600" x-text="financialSummary.pendingPayments">
                                </p>
                                <p class="text-sm text-gray-500 mt-1">Total Rp <span
                                        x-text="financialSummary.pendingAmount.toLocaleString('id-ID')"></span></p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h5 class="text-gray-500 mb-4">Grafik Pendapatan Tahunan</h5>
                            <div class="h-64">
                                <!-- Chart placeholder -->
                                <div class="flex items-end h-48 border-b border-l border-gray-200">
                                    <template x-for="month in annualRevenue">
                                        <div class="flex-1 flex flex-col items-center px-1">
                                            <div class="w-6 bg-amber-500 rounded-t"
                                                :style="`height: ${month.revenue/500000}%`"
                                                :title="'Rp ' + month.revenue.toLocaleString('id-ID')"></div>
                                            <p class="text-xs mt-1" x-text="month.month.substring(0,3)"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white shadow rounded-lg p-6">
                            <h4 class="text-lg font-semibold mb-4">Pembayaran Terakhir</h4>
                            <div class="space-y-4">
                                <template x-for="payment in recentPayments.slice(0,5)" :key="payment.id">
                                    <div class="flex items-start">
                                        <div class="p-2 rounded-full bg-amber-100 text-amber-500 mr-3">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between">
                                                <h5 class="font-medium" x-text="payment.tenant.name"></h5>
                                                <span class="text-sm font-medium"
                                                    x-text="'Rp ' + payment.amount.toLocaleString('id-ID')"></span>
                                            </div>
                                            <p class="text-sm text-gray-500" x-text="payment.period"></p>
                                            <p class="text-xs mt-1">
                                                <span class="px-2 inline-flex leading-5 font-semibold rounded-full"
                                                    :class="payment.status === 'paid' ? 'bg-green-100 text-green-800' :
                                                        payment.status === 'pending' ?
                                                        'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'"
                                                    x-text="payment.status === 'paid' ? 'Lunas' : 
                                                             payment.status === 'pending' ? 'Menunggu' : 'Terlambat'"></span>
                                            </p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="bg-white shadow rounded-lg p-6">
                            <h4 class="text-lg font-semibold mb-4">Kamar Kosong</h4>
                            <div class="space-y-3">
                                <template x-for="room in emptyRooms" :key="room.number">
                                    <div class="flex justify-between items-center p-3 border rounded-lg">
                                        <div>
                                            <h5 class="font-medium" x-text="'Kamar ' + room.number"></h5>
                                            <p class="text-sm text-gray-500" x-text="room.type"></p>
                                        </div>
                                        <div>
                                            <span class="font-medium"
                                                x-text="'Rp ' + room.price.toLocaleString('id-ID')"></span>
                                            <button class="ml-2 text-amber-500 hover:text-amber-500 text-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Detail Modal -->
                <div x-show="showPaymentDetail" x-transition class="fixed inset-0 overflow-y-auto z-50"
                    style="display: none;">
                    <!-- Existing payment detail modal -->
                </div>

                <!-- Add Tenant Modal -->
                <div x-show="showAddTenantModal" x-transition class="fixed inset-0 overflow-y-auto z-50"
                    style="display: none;">
                    <div
                        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75" @click="showAddTenantModal = false">
                            </div>
                        </div>

                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                            Tambah Penghuni Baru
                                        </h3>

                                        <form class="space-y-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nama
                                                        Lengkap</label>
                                                    <input type="text"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nomor
                                                        KTP</label>
                                                    <input type="text"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nomor
                                                        Telepon</label>
                                                    <input type="tel"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700">Email</label>
                                                    <input type="email"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Tanggal
                                                        Masuk</label>
                                                    <input type="date"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700">Kamar</label>
                                                    <select
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                                                        <option>Pilih Kamar</option>
                                                        <option>A-101</option>
                                                        <option>A-102</option>
                                                        <option>B-201</option>
                                                        <option>B-202</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                                <textarea rows="3"
                                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"></textarea>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Foto</label>
                                                <div class="mt-1 flex items-center">
                                                    <span
                                                        class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                                        <svg class="h-full w-full text-gray-300" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                        </svg>
                                                    </span>
                                                    <button type="button"
                                                        class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                                        Unggah
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Simpan
                                </button>
                                <button type="button" @click="showAddTenantModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Room Modal -->
                <div x-show="showAddRoomModal" x-transition class="fixed inset-0 overflow-y-auto z-50"
                    style="display: none;">
                    <div
                        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75" @click="showAddRoomModal = false">
                            </div>
                        </div>

                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                            Tambah Kamar Baru
                                        </h3>

                                        <form class="space-y-4" method="post" action="{{ route('room.store') }}">
                                            @csrf
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nomor
                                                        Kamar</label>
                                                    <input type="text"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"
                                                        name="room_name">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Harga
                                                        Sewa</label>
                                                    <input type="text"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"
                                                        name="room_price">
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700">Status</label>
                                                    <select
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"
                                                        name="room_status">
                                                        <option :value="false">Kosong</option>
                                                        <option :value="true">Terisi</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700">Fasilitas</label>
                                                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                            class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded"
                                                            name="facilities[]" value="ac">
                                                        <label class="ml-2 block text-sm text-gray-700">AC</label>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                            class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded"
                                                            name="facilities[]" value="kamar_mandi">
                                                        <label class="ml-2 block text-sm text-gray-700">Kamar
                                                            Mandi</label>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                            class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded"
                                                            name="facilities[]" value="tv">
                                                        <label class="ml-2 block text-sm text-gray-700">TV</label>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                            class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded"
                                                            name="facilities[]" value="lemari">
                                                        <label class="ml-2 block text-sm text-gray-700">Lemari</label>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                            class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded"
                                                            name="facilities[]" value="kursi">
                                                        <label class="ml-2 block text-sm text-gray-700">Kursi</label>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input type="checkbox"
                                                            class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded"
                                                            name="facilities[]" value="meja">
                                                        <label class="ml-2 block text-sm text-gray-700">Meja</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700">Keterangan</label>
                                                <textarea rows="3" name="description"
                                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"></textarea>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Simpan
                                                </button>
                                                <button type="button" @click="showAddRoomModal = false"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Room Modal -->
                <div x-show="showUpdateRoomModal" x-transition class="fixed inset-0 overflow-y-auto z-50"
                    style="display: none;">
                    <div
                        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75" @click="showUpdateRoomModal = false">
                            </div>
                        </div>

                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                            Update Kamar
                                        </h3>

                                        <form class="space-y-4" method="post" action="{{ route('room.update') }}">
                                            @csrf
                                            <input type="hidden" name="room_id" x-model="selectedRoom.id">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nomor
                                                        Kamar</label>
                                                    <input type="text" x-model="selectedRoom.nama"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"
                                                        name="room_name">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Harga
                                                        Sewa</label>
                                                    <input type="text" x-model="selectedRoom.price"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"
                                                        name="room_price">
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700">Status</label>
                                                    <select x-model="selectedRoom.available"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"
                                                        name="room_status">
                                                        <option :value="false">Kosong</option>
                                                        <option :value="true">Terisi</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700">Fasilitas</label>
                                                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                                    <template x-for="facility in allFacilities"
                                                        :key="facility.id">
                                                        <div class="flex items-center">
                                                            <input type="checkbox"
                                                                class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-300 rounded"
                                                                name="facilities[]" :value="facility.id"
                                                                :checked="selectedRoom.facilities.some(f => f.id === facility.id)">
                                                            <label class="ml-2 block text-sm text-gray-700"
                                                                x-text="facility.name"></label>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700">Keterangan</label>
                                                <textarea rows="3"
                                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500"
                                                    name="description" x-text="selectedRoom.description"></textarea>
                                            </div>
                                            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Simpan
                                                </button>
                                                <button type="button" @click="showUpdateRoomModal = false"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Room Modal -->
                <div x-show="showDeleteRoomModal" x-transition class="fixed inset-0 overflow-y-auto z-50"
                    style="display: none;">
                    <div
                        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75" @click="showDeleteRoomModal = false">
                            </div>
                        </div>

                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                            Hapus Kamar
                                        </h3>
                                        <form class="space-y-4" method="post" action="{{ route('room.delete') }}">
                                            @csrf
                                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Apa anda ingin
                                                menghapus kamar ini ?</h3>
                                            <input type="hidden" name="room_id" x-model="selectedRoom.id">
                                            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    delete
                                                </button>
                                                <button type="button" @click="showDeleteRoomModal = false"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function adminApp() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('activeTab') || 'dashboard';
            console.log('ActiveTab from URL:', activeTab); // Debug di console
            return {
                activeTab: activeTab,
                mobileSidebarOpen: false,
                profileDropdownOpen: false,
                paymentFilter: 'all',
                showPaymentDetail: false,
                showAddTenantModal: false,
                showAddRoomModal: false,
                showUpdateRoomModal: false,
                showDeleteRoomModal: false,
                selectedPayment: null,
                stats: {
                    totalTenants: 24,
                    totalRooms: 30,
                    occupiedRooms: 24,
                    occupancyRate: 80,
                    paidThisMonth: 18,
                    totalPayments: 24,
                    latePayments: 6
                },
                paymentStats: [{
                        month: 'Jan 2023',
                        paid: 4500000,
                        pending: 500000,
                        late: 1000000
                    },
                    {
                        month: 'Feb 2023',
                        paid: 5000000,
                        pending: 300000,
                        late: 700000
                    },
                    {
                        month: 'Mar 2023',
                        paid: 4800000,
                        pending: 200000,
                        late: 1000000
                    },
                    {
                        month: 'Apr 2023',
                        paid: 5200000,
                        pending: 800000,
                        late: 0
                    },
                    {
                        month: 'Mei 2023',
                        paid: 5500000,
                        pending: 500000,
                        late: 0
                    },
                    {
                        month: 'Jun 2023',
                        paid: 4800000,
                        pending: 1200000,
                        late: 0
                    }
                ],
                financialSummary: {
                    currentMonth: 4800000,
                    percentageChange: 12.5,
                    yearToDate: 29800000,
                    yearPercentageChange: 8.3,
                    pendingPayments: 6,
                    pendingAmount: 9000000
                },
                annualRevenue: [{
                        month: 'Januari',
                        revenue: 4500000
                    },
                    {
                        month: 'Februari',
                        revenue: 5000000
                    },
                    {
                        month: 'Maret',
                        revenue: 4800000
                    },
                    {
                        month: 'April',
                        revenue: 5200000
                    },
                    {
                        month: 'Mei',
                        revenue: 5500000
                    },
                    {
                        month: 'Juni',
                        revenue: 4800000
                    },
                    {
                        month: 'Juli',
                        revenue: 5100000
                    },
                    {
                        month: 'Agustus',
                        revenue: 4900000
                    },
                    {
                        month: 'September',
                        revenue: 5300000
                    },
                    {
                        month: 'Oktober',
                        revenue: 5600000
                    },
                    {
                        month: 'November',
                        revenue: 5400000
                    },
                    {
                        month: 'Desember',
                        revenue: 5800000
                    }
                ],
                payments: [{
                        id: 'INV-2023-06-001',
                        tenant: {
                            name: 'Budi Santoso',
                            phone: '081234567890',
                            photo: 'https://randomuser.me/api/portraits/men/1.jpg'
                        },
                        room: 'A-101',
                        period: 'Juni 2023',
                        amount: 1500000,
                        method: 'Transfer Bank - BCA',
                        status: 'pending',
                        date: '2023-06-01',
                        proof: 'https://via.placeholder.com/400x200?text=Bukti+Transfer'
                    },
                    {
                        id: 'INV-2023-06-002',
                        tenant: {
                            name: 'Ani Wijaya',
                            phone: '081298765432',
                            photo: 'https://randomuser.me/api/portraits/women/2.jpg'
                        },
                        room: 'B-205',
                        period: 'Juni 2023',
                        amount: 1800000,
                        method: 'Transfer Bank - Mandiri',
                        status: 'paid',
                        date: '2023-06-02',
                        proof: 'https://via.placeholder.com/400x200?text=Bukti+Transfer'
                    },
                    {
                        id: 'INV-2023-06-003',
                        tenant: {
                            name: 'Cahyo Pratama',
                            phone: '081223344556',
                            photo: 'https://randomuser.me/api/portraits/men/3.jpg'
                        },
                        room: 'C-304',
                        period: 'Juni 2023',
                        amount: 2000000,
                        method: 'Dana',
                        status: 'late',
                        date: '2023-06-10',
                        proof: 'https://via.placeholder.com/400x200?text=Bukti+Transfer'
                    },
                    {
                        id: 'INV-2023-05-001',
                        tenant: {
                            name: 'Dewi Lestari',
                            phone: '081112223334',
                            photo: 'https://randomuser.me/api/portraits/women/4.jpg'
                        },
                        room: 'A-102',
                        period: 'Mei 2023',
                        amount: 1500000,
                        method: 'Transfer Bank - BNI',
                        status: 'paid',
                        date: '2023-05-01',
                        proof: 'https://via.placeholder.com/400x200?text=Bukti+Transfer'
                    },
                    {
                        id: 'INV-2023-05-002',
                        tenant: {
                            name: 'Eko Prasetyo',
                            phone: '081334455667',
                            photo: 'https://randomuser.me/api/portraits/men/5.jpg'
                        },
                        room: 'B-201',
                        period: 'Mei 2023',
                        amount: 1800000,
                        method: 'Gopay',
                        status: 'paid',
                        date: '2023-05-03',
                        proof: 'https://via.placeholder.com/400x200?text=Bukti+Transfer'
                    }
                ],
                tenants: @json($customer),
                messages_list: [],
                chat: [],
                rooms: @json($rooms),
                selectedRoom: {},
                chatOpen: '',
                messages: [],
                newMessage: '',
                fetchInterval: null,
                allFacilities: [{
                        id: 1,
                        name: "AC"
                    },
                    {
                        id: 2,
                        name: "Kamar Mandi"
                    },
                    {
                        id: 3,
                        name: "TV"
                    },
                    {
                        id: 4,
                        name: "Lemari"
                    },
                    {
                        id: 5,
                        name: "Kursi"
                    },
                    {
                        id: 6,
                        name: "Meja"
                    },
                ],
                get filteredPayments() {
                    if (this.paymentFilter === 'all') return this.payments;
                    return this.payments.filter(p => p.status === this.paymentFilter);
                },
                get recentPayments() {
                    return [...this.payments].sort((a, b) => new Date(b.date) - new Date(a.date));
                },
                get emptyRooms() {
                    return this.rooms.filter(room => room.status === 'empty');
                },
                viewPayment(id) {
                    this.selectedPayment = this.payments.find(p => p.id === id);
                    this.showPaymentDetail = true;
                },
                verifyPayment(id) {
                    const payment = this.payments.find(p => p.id === id);
                    payment.status = 'paid';
                    this.showPaymentDetail = false;
                    alert(`Pembayaran ${id} telah diverifikasi!`);
                },
                rejectPayment(id) {
                    const payment = this.payments.find(p => p.id === id);
                    payment.status = 'late';
                    this.showPaymentDetail = false;
                    alert(`Pembayaran ${id} telah ditolak!`);
                },
                viewTenant(id) {
                    // Implement view tenant detail
                    alert(`View tenant ${id}`);
                },
                editTenant(id) {
                    // Implement edit tenant
                    alert(`Edit tenant ${id}`);
                },
                confirmDeleteTenant(id) {
                    if (confirm(`Apakah Anda yakin ingin menghapus penghuni ini?`)) {
                        // Implement delete tenant
                        alert(`Tenant ${id} deleted`);
                    }
                },
                editRoom(number) {
                    // Implement edit room
                    alert(`Edit room ${number}`);
                },
                deleteRoom(number) {
                    if (confirm(`Apakah Anda yakin ingin menghapus kamar ${number}?`)) {
                        // Implement delete room
                        alert(`Room ${number} deleted`);
                    }
                },
                init() {
                    this.loadMessages();
                    this.startFetching();
                },

                startFetching() {
                    if (this.fetchInterval) clearInterval(this.fetchInterval);
                    this.fetchInterval = setInterval(() => {
                        if (this.chatOpen) {
                            this.loadMessages();
                        }
                    }, 1000);
                },

                loadMessages() {
                    fetch('/messages')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            this.messages_list = data.messages;
                            this.chat = data.chat;
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
                    if (!this.newMessage || !this.chatOpen) return;
                    fetch('/messages', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: this.chatOpen,
                                content: this.newMessage,
                                is_admin: true
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
                            this.chat.push(data);
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
                }
            }
        }
    </script>
</body>

</html>
