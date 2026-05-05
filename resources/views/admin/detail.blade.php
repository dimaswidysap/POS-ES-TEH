@extends('components.master')


@section('content')
    <section class="w-full h-screen flex justify-center items-center">
        <div class="flex gap-4">
            <figure class=" w-[15rem] lg:w-[20rem] aspect-10/16 shadow-xl bg-forest-950/80 rounded-xl p-1">
                <div class="w-full h-full bg-tea-100 rounded-[9px] overflow-hidden">
                    <img src="" alt="foto-produk" class="w-full h-full">
                </div>
            </figure>

            <div class="flex flex-col flex-1 justify-between">
                <div class="w-full">
                    <div class="w-[20rem]">
                        <span class="text-3xl text-font font-black">{{ $produk->id_produk }}</span>
                    </div>
                    {{-- container nama --}}
                    <div class="flex">
                        <span class="text-font mt-3 font-black">{{ $produk->nama_produk }}</span>
                    </div>

                    {{-- container deskripsi --}}
                    <div class="w-[20rem]">
                        <span>{{ $produk->deskripsi }}</span>
                    </div>
                    <div class="w-[20rem] mt-3 font-black">
                        <span>Rp. {{ number_format($produk->harga_produk, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div>
                    <a href="/admin/menu"
                        class="w-full inline-flex justify-center py-3 bg-forest-950/80 outline-1 outline-forest-950 rounded-md   text-tea-100 font-black">Kembali</a>
                </div>
            </div>


        </div>
    </section>
@endsection
