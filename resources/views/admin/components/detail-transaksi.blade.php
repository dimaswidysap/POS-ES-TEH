@props(['trx'])

<div
    class="relative w-full md:w-[calc(50%-1.25rem)] lg:w-[calc(33.333%-1.66rem)] bg-forest-950/80 backdrop-blur-md border border-forest-700 rounded-2xl shadow-lg hover:shadow-[0_8px_30px_rgba(82,183,136,0.15)] transition-all duration-300 overflow-hidden flex flex-col">

    {{-- Aksen Garis Atas --}}
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-tea-600 to-tea-400"></div>

    <div class="p-5 flex-1 flex flex-col">
        {{-- Header Card --}}
        <div class="flex justify-between items-start mb-4">
            <div>
                <span class="text-xs font-bold text-tea-400 tracking-wider uppercase mb-1 block">ID Transaksi</span>
                <h2 class="font-black text-xl text-white">
                    #{{ $trx->id_transaksi }}
                </h2>
            </div>

            {{-- Tombol Hapus --}}
            <a href="/admin/hapus-transaksi/{{ $trx->id_transaksi }}"
                onclick="return confirm('Yakin ingin menghapus transaksi ini? Data yang dihapus tidak dapat dikembalikan.')"
                class="group flex items-center justify-center w-8 h-8 bg-red-500/10 hover:bg-red-500 border border-red-500/50 hover:border-red-500 rounded-lg transition-all duration-300"
                title="Hapus Transaksi">
                <svg class="w-4 h-4 text-red-500 group-hover:text-white transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </a>
        </div>

        {{-- Detail Keuangan (Grid) --}}
        <div class="grid grid-cols-2 gap-3 mb-5 bg-forest-900/50 p-4 rounded-xl border border-forest-800">
            <div class="col-span-2 flex justify-between items-center border-b border-forest-700/50 pb-2">
                <span class="text-sm font-semibold text-tea-100/60">Total Pembelian</span>
                <span class="font-black text-lg text-tea-400">Rp
                    {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xs text-tea-100/50">Tunai</span>
                <span class="font-semibold text-white text-sm">Rp
                    {{ number_format($trx->uang_pelanggan, 0, ',', '.') }}</span>
            </div>
            <div class="flex flex-col text-right">
                <span class="text-xs text-tea-100/50">Kembalian</span>
                <span class="font-semibold text-white text-sm">Rp
                    {{ number_format($trx->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Tabel Produk --}}
        <div class="mt-auto overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-forest-700 text-tea-100/50">
                        <th class="py-2 text-left font-semibold">Produk</th>
                        <th class="py-2 text-center font-semibold">Qty</th>
                        <th class="py-2 text-right font-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-forest-800/50">
                    @foreach ($trx->details as $detail)
                        <tr class="text-white/80 group hover:bg-forest-800/30 transition-colors">
                            <td class="py-2.5 font-medium">{{ $detail->produk->nama_produk }}</td>
                            <td class="py-2.5 text-center">
                                <span
                                    class="bg-forest-800 text-tea-100 text-xs py-1 px-2 rounded-md">{{ $detail->quantity }}x</span>
                            </td>
                            <td class="py-2.5 text-right font-semibold text-tea-100/90">Rp
                                {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
