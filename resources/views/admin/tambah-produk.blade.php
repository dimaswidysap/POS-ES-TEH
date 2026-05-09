@extends('components.master')

@section('content')
    <section class="w-full min-h-screen bg-tea-100 font-Montserrat flex justify-center items-center py-12 px-[5%] md:px-8">

        {{-- Card Container dengan efek Light Glassmorphism --}}
        <div
            class="bg-white/60 backdrop-blur-xl border border-white/80 shadow-[0_8px_30px_rgba(32,41,64,0.05)] rounded-3xl p-6 md:p-10 w-full max-w-4xl relative">

            {{-- Header Form & Tombol Kembali --}}
            <div class="flex items-center gap-4 mb-8 border-b border-tea-300/50 pb-5">
                <a href="/admin/menu"
                    class="group flex justify-center items-center w-10 h-10 rounded-full bg-white hover:bg-forest-800 border border-tea-300 hover:border-forest-800 shadow-sm transition-all duration-300">
                    <svg class="w-5 h-5 text-forest-800 group-hover:text-tea-100 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="font-black text-2xl text-[var(--color-font)]">Tambah Produk Baru</h1>
                    <p class="text-sm text-forest-700/70 font-medium">Lengkapi detail informasi untuk menu es teh Anda.</p>
                </div>
            </div>

            <form action="/admin/menu/simpan-produk" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="flex flex-col md:flex-row gap-8">

                    {{-- KIRI: Area Upload Gambar --}}
                    <div class="w-full md:w-[40%] flex flex-col">
                        <label class="font-black text-[var(--color-font)] mb-2 block text-sm">Foto Produk</label>
                        <label for="gambar"
                            class="relative flex flex-col items-center justify-center w-full aspect-[3/4] md:aspect-[10/16] border-2 border-dashed border-tea-400 bg-white/50 hover:bg-tea-50/50 rounded-2xl cursor-pointer transition-all duration-300 overflow-hidden group">

                            {{-- State sebelum ada gambar --}}
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                <div
                                    class="w-16 h-16 mb-4 rounded-full bg-tea-300/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-forest-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="mb-2 text-sm text-forest-800 font-bold">Klik untuk unggah foto</p>
                                <p class="text-xs text-forest-700/60 font-medium">PNG, JPG, atau JPEG (Maks. 2MB)</p>
                            </div>

                            {{-- Input File Asli (Disembunyikan) --}}
                            <input type="file" name="foto_produk" id="gambar" class="hidden"
                                accept=".jpg, .jpeg, .png">
                        </label>

                        @error('foto_produk')
                            <span class="text-red-500 text-sm mt-2 font-semibold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- KANAN: Form Input Data --}}
                    <div class="flex flex-col flex-1 gap-5">

                        {{-- Input Nama Produk --}}
                        <div class="flex flex-col">
                            <label class="font-black text-[var(--color-font)] mb-2 block text-sm">Nama Produk</label>
                            <input name="nama_produk" type="text" placeholder="Contoh: Es Teh Leci"
                                value="{{ old('nama_produk') }}"
                                class="bg-white/80 border border-tea-300 focus:border-forest-500 focus:ring-4 focus:ring-forest-500/10 rounded-xl py-3 px-4 text-[var(--color-font)] font-bold outline-none transition-all placeholder:text-forest-800/30">
                            @error('nama_produk')
                                <span class="text-red-500 text-sm mt-1 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Input Harga Produk --}}
                        <div class="flex flex-col">
                            <label class="font-black text-[var(--color-font)] mb-2 block text-sm">Harga Produk (Rp)</label>
                            <input name="harga_produk" type="number" min="0" placeholder="Contoh: 15000"
                                value="{{ old('harga_produk') }}"
                                class="bg-white/80 border border-tea-300 focus:border-forest-500 focus:ring-4 focus:ring-forest-500/10 rounded-xl py-3 px-4 text-[var(--color-font)] font-bold outline-none transition-all placeholder:text-forest-800/30">
                            @error('harga_produk')
                                <span class="text-red-500 text-sm mt-1 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Input Deskripsi Produk --}}
                        <div class="flex flex-col flex-1">
                            <label class="font-black text-[var(--color-font)] mb-2 block text-sm">Deskripsi Produk</label>
                            <textarea name="deskripsi_produk" rows="4" placeholder="Jelaskan detail varian rasa atau komposisi..."
                                class="bg-white/80 border border-tea-300 focus:border-forest-500 focus:ring-4 focus:ring-forest-500/10 rounded-xl py-3 px-4 text-[var(--color-font)] font-bold outline-none transition-all resize-none placeholder:text-forest-800/30 h-full">{{ old('deskripsi_produk') }}</textarea>
                            @error('deskripsi_produk')
                                <span class="text-red-500 text-sm mt-1 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="pt-2 mt-auto">
                            <button type="submit"
                                class="w-full flex justify-center items-center gap-2 py-3.5 bg-forest-800 hover:bg-forest-900 rounded-xl cursor-pointer text-tea-100 font-black shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                    </path>
                                </svg>
                                Simpan Produk
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection
