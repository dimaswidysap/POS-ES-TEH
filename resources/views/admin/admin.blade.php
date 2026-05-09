@extends('components.master')
@php
    use Carbon\Carbon;
    Carbon::setLocale('id');

    // Ambil tanggal dari URL, jika tidak ada default ke hari ini
    $selectedDate = request('date', Carbon::now()->toDateString());
@endphp
@section('content')
    <section class="w-full">
        @include('components.sidebarAdmin')

        <section class="w-full h-screen pt-[5rem] px-5">

            {{-- container penghasilan --}}
            <div
                class="bg-white/80 backdrop-blur-xl border border-white shadow-[0_8px_30px_rgba(32,41,64,0.05)] p-6 rounded-3xl w-full max-w-sm relative overflow-hidden group transition-all hover:shadow-[0_8px_30px_rgba(32,41,64,0.08)]">

                {{-- Hiasan Background (Glow halus di sudut) --}}
                <div
                    class="absolute -right-10 -top-10 w-32 h-32 bg-tea-300/30 rounded-full blur-2xl pointer-events-none group-hover:bg-tea-300/50 transition-all duration-500">
                </div>

                {{-- Header Card (Judul & Filter) --}}
                <div class="flex justify-between items-start relative z-10 gap-4">

                    {{-- Ikon & Judul --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-tea-100 text-forest-700 flex items-center justify-center shadow-inner border border-tea-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-forest-800/70 font-bold text-xs tracking-wider uppercase">Total Penghasilan</h3>
                    </div>

                    {{-- Dropdown Filter Tanggal --}}
                    <div class="relative">
                        @php
                            $today = \Carbon\Carbon::now()->toDateString();
                        @endphp

                        {{-- Menggunakan appearance-none untuk menghilangkan panah bawaan browser agar bisa dicustom --}}
                        <select onchange="location = this.value;"
                            class="appearance-none bg-tea-50/80 hover:bg-tea-100 border border-tea-200 text-forest-800 font-bold text-[11px] py-1.5 pl-3 pr-7 rounded-lg outline-none focus:ring-2 focus:ring-tea-400 cursor-pointer transition-colors shadow-sm">

                            {{-- Opsi Hari Ini --}}
                            <option value="?date={{ $today }}" {{ $selectedDate == $today ? 'selected' : '' }}>
                                Hari Ini
                            </option>

                            {{-- Opsi 4 Hari Sebelumnya --}}
                            @for ($i = 1; $i < 5; $i++)
                                @php
                                    $dateString = \Carbon\Carbon::now()->subDays($i)->toDateString();
                                    // Format bulan dipersingkat (M) agar dropdown tidak terlalu melebar
                                    $formattedDate = \Carbon\Carbon::now()->subDays($i)->translatedFormat('d M Y');
                                @endphp
                                <option value="?date={{ $dateString }}"
                                    {{ $selectedDate == $dateString ? 'selected' : '' }}>
                                    {{ $formattedDate }}
                                </option>
                            @endfor
                        </select>

                        {{-- Custom Ikon Panah Dropdown --}}
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-forest-700">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Body Card (Nominal Uang) --}}
                <div class="relative z-10 mt-5 mb-1">
                    <h1 class="text-[var(--color-font)] font-black text-3xl md:text-4xl flex items-baseline gap-1">
                        <span class="text-xl text-forest-700/50 font-bold tracking-tight">Rp</span>
                        {{-- Format angka diubah menggunakan standar Indonesia (titik untuk ribuan) --}}
                        {{ number_format($penghasilanHariIni, 0, ',', '.') }}
                    </h1>
                </div>
            </div>
        </section>
    </section>
@endsection
