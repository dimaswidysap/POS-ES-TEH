@php
    $nav = [
        [
            'name' => 'Dashboard',
            'url' => 'admin.index',
            'icon' =>
                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
        [
            'name' => 'Orders',
            'url' => 'admin.order',
            'icon' =>
                'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
        ],

        // Label diubah menjadi 'Data Produk' dan ikon diperbarui menjadi bentuk box inventaris
        [
            'name' => 'Data Produk',
            'url' => 'admin.menu',
            'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        ],

        [
            'name' => 'User',
            'url' => 'admin.user',
            'icon' =>
                'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        ],
    ];
@endphp

@vite('resources/ts/admin/nav.ts')

<div class="font-Montserrat">
    {{-- Header Utama --}}
    <header
        class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between
               px-[5%] md:px-8 h-20
               bg-forest-950/90 backdrop-blur-md border-b border-forest-800 shadow-lg transition-all">

        {{-- Kiri: Logo & Toggle --}}
        <div class="flex items-center gap-5">
            <button id="open-sidebar"
                class="text-tea-100 hover:text-tea-400 transition-colors p-2 -ml-2 rounded-lg hover:bg-forest-800/50">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            {{-- Branding Identitas (Opsional, disamakan dengan Landing Page) --}}
            <div class="hidden md:flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-full bg-forest-800 flex items-center justify-center border border-forest-600 shadow-[0_0_15px_rgba(82,183,136,0.2)]">
                    <svg class="w-5 h-5 text-tea-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                        </path>
                    </svg>
                </div>
                <span class="font-black text-xl text-white tracking-wide">Es Teh <span
                        class="text-tea-400">Segar</span></span>
            </div>
        </div>

        {{-- Kanan: Profil Admin (Meniru desain tombol "Admin" di Landing Page) --}}
        <div class="h-full flex items-center">
            <button
                class="flex items-center gap-3 bg-tea-500 hover:bg-tea-400 transition-colors px-5 py-2.5 rounded-xl shadow-lg">
                <svg class="w-5 h-5 text-[var(--color-font)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-bold text-[var(--color-font)]">Admin</span>
            </button>
        </div>
    </header>

    {{-- Overlay Background untuk Sidebar (Memberikan efek sinematik saat sidebar terbuka) --}}
    <div id="sidebar-overlay"
        class="fixed inset-0 bg-forest-950/60 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300">
    </div>

    {{-- Sidebar --}}
    <section
        class="sidebar shadow-2xl -translate-x-full transition-transform duration-500 w-[75%] md:w-1/3 lg:w-1/5 h-screen fixed left-0 top-0 z-50 flex flex-col bg-forest-950 border-r border-forest-800">

        {{-- Header Sidebar --}}
        <header class="w-full h-20 flex items-center justify-between px-6 border-b border-forest-800/50 relative z-10">
            <span class="font-black text-white text-xl md:hidden">Es Teh <span class="text-tea-400">Segar</span></span>
            <span class="font-black text-tea-100 text-xl hidden md:block">Navigasi</span>

            <button id="close-sidebar"
                class="text-tea-100 hover:text-tea-400 transition-colors p-2 bg-forest-800/50 rounded-full hover:bg-forest-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </header>

        {{-- Container Links --}}
        <nav class="w-full mt-6 px-4 gap-2 flex flex-col relative z-10 flex-1">
            @foreach ($nav as $link)
                <a href="{{ route($link['url']) }}"
                    class="group inline-flex relative items-center gap-4 py-3 px-4 rounded-xl transition-all duration-300 overflow-hidden
                    {{ request()->routeIs($link['url']) ? 'bg-forest-800/80 border border-forest-600 shadow-lg' : 'hover:bg-forest-800/40' }}">

                    {{-- Efek Glow Aktif (Kiri) --}}
                    @if (request()->routeIs($link['url']))
                        <div class="absolute left-0 top-0 w-1 h-full bg-tea-400 shadow-[0_0_10px_rgba(244,200,66,0.8)]">
                        </div>
                    @endif

                    {{-- Ikon --}}
                    <svg class="w-5 h-5 relative z-10 {{ request()->routeIs($link['url']) ? 'text-tea-400' : 'text-forest-400 group-hover:text-tea-300' }} transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}">
                        </path>
                    </svg>

                    {{-- Teks --}}
                    <span
                        class="font-bold relative z-10 {{ request()->routeIs($link['url']) ? 'text-white' : 'text-tea-100/80 group-hover:text-white' }} transition-colors">
                        {{ $link['name'] }}
                    </span>
                </a>
            @endforeach
        </nav>

        {{-- Container Hiasan Bawah (Radial Glow untuk menyamakan nuansa background) --}}
        <div class="w-full h-48 relative overflow-hidden mt-auto pointer-events-none">
            <span
                class="inline-flex h-full w-full absolute bg-forest-600/20 bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 rounded-full blur-[70px]"></span>
        </div>
    </section>
</div>
