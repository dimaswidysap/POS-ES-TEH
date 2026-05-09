@extends('components.master')

@section('content')
    <section class="w-full min-h-screen bg-forest-950 font-Montserrat text-white px-[5%] md:px-8 pb-10">
        @include('components.sidebarAdmin')

        {{-- Margin top menyesuaikan header fixed --}}
        <section class="w-full pt-[6rem]">

            {{-- Flash Message (Opsional, untuk notifikasi sukses tambah/edit/hapus) --}}
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

            {{-- Header Halaman & Tombol Tambah --}}
            <div class="w-full mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="font-black text-2xl text-white">Data Produk</h1>
                    <p class="text-sm text-tea-100/60 mt-1">Kelola menu, harga, dan deskripsi produk Anda</p>
                </div>

                <a href="{{ route('admin.menu.tambahProduk') }}"
                    class="group inline-flex items-center gap-2 py-2.5 px-5 rounded-xl bg-tea-500 hover:bg-tea-400 text-[var(--color-font)] font-bold transition-all duration-300 shadow-[0_0_15px_rgba(232,184,48,0.2)] hover:shadow-[0_0_20px_rgba(232,184,48,0.4)]">
                    <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Produk</span>
                </a>
            </div>

            {{-- Container Tabel dengan Glassmorphism --}}
            <div
                class="w-full bg-forest-900/60 backdrop-blur-md border border-forest-700 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-forest-800/50 border-b border-forest-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 font-bold text-tea-100/70 tracking-wider uppercase text-xs">Nama Produk
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 font-bold text-tea-100/70 tracking-wider uppercase text-xs">Harga</th>
                                <th scope="col"
                                    class="px-6 py-4 font-bold text-tea-100/70 tracking-wider uppercase text-xs">Deskripsi
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 font-bold text-tea-100/70 tracking-wider uppercase text-xs text-right">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-forest-800/50">
                            @forelse ($produk as $item)
                                <tr class="group hover:bg-forest-800/30 transition-colors duration-200 text-white">
                                    <td class="px-6 py-4">
                                        <div
                                            class="font-bold text-base text-white group-hover:text-tea-300 transition-colors">
                                            {{ $item->nama_produk }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-tea-400">
                                        Rp {{ number_format($item->harga_produk, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-tea-100/60 text-sm whitespace-normal max-w-xs">
                                        {{ Str::limit($item->deskripsi, 50) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('admin.menu.detail', $item->id_produk) }}"
                                                class="p-2 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white border border-blue-500/20 hover:border-blue-500 transition-all duration-300"
                                                title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </a>

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('admin.menu.editProduk', $item->id_produk) }}"
                                                class="p-2 rounded-lg bg-tea-500/10 text-tea-400 hover:bg-tea-500 hover:text-[var(--color-font)] border border-tea-500/20 hover:border-tea-500 transition-all duration-300"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form method="POST"
                                                action="{{ route('admin.menu.hapusProduk', $item->id_produk) }}"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                                    class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white border border-red-500/20 hover:border-red-500 transition-all duration-300"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-forest-600 mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                            <p class="text-tea-100/60 font-medium">Belum ada produk yang ditambahkan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </section>
@endsection
