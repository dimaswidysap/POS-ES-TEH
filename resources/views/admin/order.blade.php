@extends('components.master')

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');

    // Ambil tanggal dari URL, jika tidak ada default ke hari ini
    $selectedDate = request('date', Carbon::now()->toDateString());
@endphp

@section('content')
    <section class="w-full min-h-screen  font-Montserrat text-white px-[5%] md:px-8 pb-10">
        @include('components.sidebarAdmin')

        {{-- Menyesuaikan margin top agar tidak tertutup header fixed (h-20 = 5rem) --}}
        <div class="pt-[6rem]">

            {{-- Flash Message --}}
            @if (session('success'))
                <div
                    class="mb-5 flex items-center gap-3 bg-forest-600/20 border border-forest-500 text-tea-100 px-5 py-4 rounded-xl backdrop-blur-sm animate-fade-in-down">
                    <svg class="w-6 h-6 text-tea-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Header Filter Tanggal --}}
            <header
                class="w-full bg-forest-900/60 backdrop-blur-md border border-forest-700 rounded-2xl shadow-lg p-4 mb-8 flex flex-col md:flex-row justify-between md:items-center gap-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-tea-500/20 flex items-center justify-center border border-tea-500/30">
                        <svg class="w-5 h-5 text-tea-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-black text-xl text-font">Riwayat Pesanan</h1>
                        <p class="text-sm text-font">Kelola transaksi harian Anda</p>
                    </div>
                </div>

                {{-- Scrollable Date Pills --}}
                <div class="overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
                    <ul class="flex gap-3 min-w-max">
                        {{-- Tombol Hari Ini --}}
                        @php $today = Carbon::now()->toDateString(); @endphp
                        <li>
                            <a href="?date={{ $today }}"
                                class="inline-flex items-center font-bold px-5 py-2.5 rounded-xl transition-all duration-300 border 
                                {{ $selectedDate == $today
                                    ? 'bg-tea-500 text-forest-950 border-tea-400 shadow-[0_0_15px_rgba(232,184,48,0.3)]'
                                    : 'bg-forest-800/50 text-tea-100 border-forest-700 hover:bg-forest-700 hover:border-forest-600' }}">
                                Hari Ini
                            </a>
                        </li>

                        {{-- Tombol 4 Hari Sebelumnya --}}
                        @for ($i = 1; $i < 5; $i++)
                            @php $dateString = Carbon::now()->subDays($i)->toDateString(); @endphp
                            <li>
                                <a href="?date={{ $dateString }}"
                                    class="inline-flex items-center font-bold px-5 py-2.5 rounded-xl transition-all duration-300 border 
                                    {{ $selectedDate == $dateString
                                        ? 'bg-tea-500 text-forest-950 border-tea-400 shadow-[0_0_15px_rgba(232,184,48,0.3)]'
                                        : 'bg-forest-800/50 text-tea-100 border-forest-700 hover:bg-forest-700 hover:border-forest-600' }}">
                                    {{ Carbon::now()->subDays($i)->translatedFormat('d M Y') }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </header>

            {{-- Container List Transaksi --}}
            <div class="flex flex-wrap gap-5">
                @forelse ($transaksi as $trx)
                    @include('admin.components.detail-transaksi', ['trx' => $trx])
                @empty
                    {{-- Empty State --}}
                    <div
                        class="w-full flex flex-col items-center justify-center py-20 px-5 bg-forest-900/30 border border-forest-800 border-dashed rounded-2xl">
                        <div class="w-24 h-24 mb-6 rounded-full bg-forest-800/50 flex items-center justify-center relative">
                            <span class="absolute w-full h-full rounded-full bg-tea-500/10 animate-ping"></span>
                            <svg class="w-12 h-12 text-forest-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-black text-2xl text-white mb-2">Belum Ada Transaksi</h3>
                        <p class="text-center text-tea-100/60 font-medium max-w-md">
                            Tidak ada data transaksi yang tercatat pada <span
                                class="text-tea-400">{{ Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span>.
                        </p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    {{-- Tambahan CSS khusus untuk menyembunyikan scrollbar bawaan browser di deretan tanggal --}}
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.4s ease-out forwards;
        }
    </style>
@endsection
