@extends('components.master')

@section('content')
    <section class="w-full min-h-screen bg-tea-100 font-Montserrat flex justify-center items-center py-12 px-[5%] md:px-8">

        {{-- Card Container dengan efek Light Glassmorphism --}}
        <div
            class="bg-white/60 backdrop-blur-xl border border-white/80 shadow-[0_8px_30px_rgba(32,41,64,0.05)] rounded-3xl p-6 md:p-10 w-full max-w-4xl relative">

            {{-- Header Form & Tombol Kembali --}}
            <div class="flex items-center gap-4 mb-8 border-b border-tea-300/50 pb-5">
                <a href="/admin/menu"
                    class="group flex justify-center items-center w-10 h-10 rounded-full bg-white hover:bg-forest-800 border border-tea-300 hover:border-forest-800 shadow-sm transition-all duration-300"
                    title="Kembali">
                    <svg class="w-5 h-5 text-forest-800 group-hover:text-tea-100 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="font-black text-2xl text-[var(--color-font)]">Edit Data Produk</h1>
                    <p class="text-sm text-forest-700/70 font-medium">Perbarui informasi untuk menu <span
                            class="text-forest-800 font-bold">#{{ $produk->id_produk }}</span></p>
                </div>
            </div>

            <form action="/admin/menu/update-produk/{{ $produk->id_produk }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="flex flex-col md:flex-row gap-8">

                    {{-- KIRI: Area Preview & Upload Gambar Baru --}}
                    <div class="w-full md:w-[40%] flex flex-col">
                        <label class="font-black text-[var(--color-font)] mb-2 block text-sm">Foto Produk</label>

                        {{-- Interactive Image Label --}}
                        <label for="gambar"
                            class="relative block w-full aspect-[4/5] md:aspect-[10/16] bg-white p-2 rounded-2xl shadow-lg border border-tea-200 cursor-pointer overflow-hidden group">

                            {{-- Gambar Lama --}}
                            <img class="object-cover w-full h-full rounded-xl transition-transform duration-500 group-hover:scale-105"
                                src="{{ asset('foto_produk/' . $produk->foto_produk) }}" alt="Preview Foto">

                            {{-- Overlay Hover "Ganti Foto" --}}
                            <div
                                class="absolute inset-2 bg-forest-950/70 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white backdrop-blur-sm">
                                <div class="w-12 h-12 mb-2 rounded-full bg-tea-500/80 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-black text-sm tracking-wide">Ganti Foto</span>
                                <span class="text-xs text-tea-100/70 font-medium mt-1">Maks: 2MB</span>
                            </div>

                            {{-- Input File Asli (Disembunyikan) --}}
                            <input type="file" name="foto_produk_update" id="gambar" class="hidden"
                                accept=".jpg, .jpeg, .png">
                        </label>

                        <p class="text-xs text-forest-700/60 font-medium text-center mt-3">* Biarkan kosong jika tidak ingin
                            mengubah foto.</p>

                        @error('foto_produk_update')
                            <span class="text-red-500 text-sm mt-2 font-semibold flex items-center gap-1 justify-center">
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
                            <input name="nama_produk_update" type="text"
                                value="{{ old('nama_produk_update', $produk->nama_produk) }}"
                                class="bg-white/80 border border-tea-300 focus:border-forest-500 focus:ring-4 focus:ring-forest-500/10 rounded-xl py-3 px-4 text-[var(--color-font)] font-bold outline-none transition-all placeholder:text-forest-800/30">
                            @error('nama_produk_update')
                                <span class="text-red-500 text-sm mt-1 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Input Harga Produk --}}
                        <div class="flex flex-col">
                            <label class="font-black text-[var(--color-font)] mb-2 block text-sm">Harga Produk (Rp)</label>
                            <input name="harga_produk_update" type="number" min="0"
                                value="{{ old('harga_produk_update', $produk->harga_produk) }}"
                                class="bg-white/80 border border-tea-300 focus:border-forest-500 focus:ring-4 focus:ring-forest-500/10 rounded-xl py-3 px-4 text-[var(--color-font)] font-bold outline-none transition-all placeholder:text-forest-800/30">
                            @error('harga_produk_update')
                                <span class="text-red-500 text-sm mt-1 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Input Deskripsi Produk --}}
                        <div class="flex flex-col flex-1">
                            <label class="font-black text-[var(--color-font)] mb-2 block text-sm">Deskripsi Produk</label>
                            <textarea name="deskripsi_produk_update" rows="4"
                                class="bg-white/80 border border-tea-300 focus:border-forest-500 focus:ring-4 focus:ring-forest-500/10 rounded-xl py-3 px-4 text-[var(--color-font)] font-bold outline-none transition-all resize-none placeholder:text-forest-800/30 h-full">{{ old('deskripsi_produk_update', $produk->deskripsi) }}</textarea>
                            @error('deskripsi_produk_update')
                                <span class="text-red-500 text-sm mt-1 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Tombol Simpan Perubahan --}}
                        <div class="pt-2 mt-auto">
                            <button type="submit"
                                class="w-full flex justify-center items-center gap-2 py-3.5 bg-forest-800 hover:bg-forest-900 rounded-xl cursor-pointer text-tea-100 font-black shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection
