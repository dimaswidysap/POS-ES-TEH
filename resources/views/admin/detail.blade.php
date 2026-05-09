@extends('components.master')

@section('content')
    <section class="w-full min-h-screen bg-tea-100 font-Montserrat flex justify-center items-center py-12 px-[5%] md:px-8">

        {{-- Card Container dengan efek Light Glassmorphism --}}
        <div
            class="bg-white/60 backdrop-blur-xl border border-white/80 shadow-[0_8px_30px_rgba(32,41,64,0.05)] rounded-3xl p-6 md:p-10 w-full max-w-4xl relative flex flex-col md:flex-row gap-8 lg:gap-12">

            {{-- KIRI: Container Foto Produk --}}
            <div class="w-full md:w-[45%] flex flex-col justify-center relative">
                {{-- Bingkai Foto (Meniru gaya polaroid modern) --}}
                <figure
                    class="w-full aspect-[4/5] md:aspect-[10/16] bg-white p-2 rounded-2xl shadow-lg border border-tea-200 relative group overflow-hidden">
                    <img class="object-cover w-full h-full rounded-xl transition-transform duration-500 group-hover:scale-105"
                        src="{{ asset('foto_produk/' . $produk->foto_produk) }}" alt="{{ $produk->nama_produk }}">

                    {{-- Overlay Tipis saat di-hover (Opsional) --}}
                    <div
                        class="absolute inset-0 bg-forest-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl pointer-events-none">
                    </div>
                </figure>
            </div>

            {{-- KANAN: Container Detail Informasi --}}
            <div class="flex flex-col flex-1 justify-between">

                <div class="w-full">
                    {{-- Tombol Navigasi Kembali (Kecil di atas) --}}
                    <a href="/admin/menu"
                        class="inline-flex items-center gap-2 text-forest-700 hover:text-forest-900 font-bold mb-6 transition-colors group">
                        <span
                            class="bg-white group-hover:bg-tea-200 border border-tea-300 p-1.5 rounded-full transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </span>
                        Kembali ke Data Produk
                    </a>

                    {{-- Badge ID Produk --}}
                    <div class="mb-3">
                        <span
                            class="inline-flex items-center gap-1.5 bg-tea-200/70 text-forest-800 px-3 py-1 rounded-full text-xs font-black tracking-widest uppercase border border-tea-300">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            ID: {{ $produk->id_produk }}
                        </span>
                    </div>

                    {{-- Nama Produk --}}
                    <h1 class="text-3xl md:text-4xl font-black text-[var(--color-font)] leading-tight mb-4">
                        {{ $produk->nama_produk }}
                    </h1>

                    {{-- Harga Produk --}}
                    <div class="mb-8">
                        <span class="text-3xl font-black text-forest-700 flex items-center gap-2">
                            <span class="text-lg text-forest-700/60 font-bold">Rp</span>
                            {{ number_format($produk->harga_produk, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Garis Pemisah --}}
                    <hr class="border-tea-300/60 mb-6">

                    {{-- Deskripsi Produk --}}
                    <div class="w-full mb-8">
                        <h3 class="font-black text-[var(--color-font)] text-sm uppercase tracking-wider mb-3">Deskripsi
                            Produk</h3>
                        <p
                            class="text-forest-800/80 font-medium leading-relaxed bg-white/40 p-4 rounded-xl border border-white">
                            {{ $produk->deskripsi }}
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 mt-auto pt-4">
                    {{-- Tombol Kembali (Utama) --}}
                    <a href="/admin/menu"
                        class="w-full flex-1 inline-flex justify-center items-center gap-2 py-3.5 bg-forest-800 hover:bg-forest-900 rounded-xl cursor-pointer text-tea-100 font-black shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Tutup Detail
                    </a>
                </div>

            </div>
        </div>
    </section>
@endsection
