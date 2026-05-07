@extends('components.master')


@section('content')
    <section class="w-full h-screen flex justify-center items-center">
        <form action="/admin/menu/update-produk/{{ $produk->id_produk }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex gap-4 relative">
                {{-- btn kembali --}}
                <a href="/admin/menu"
                    class="inline-flex h-[3rem] aspect-square absolute left-full bottom-full shadow-xl justify-center items-center rounded-full bg-forest-950">
                    <span class="inline-flex w-[60%] h-2 bg-tea-100 absolute rounded-xl rotate-45"></span>
                    <span class="inline-flex w-[60%] h-2 bg-tea-100 absolute rounded-xl -rotate-45"></span>
                </a>
                {{-- foto --}}
                <div class="">
                    <figure class=" w-[15rem] lg:w-[20rem] aspect-10/16 shadow-xl bg-forest-950/80 rounded-xl p-1">
                        <div class="relative w-full h-full bg-tea-100 rounded-[9px] overflow-hidden">
                            <div class="absolute h-full w-full inset-0">
                                <span class="absolute inline-flex inset-0 h-full w-full bg-forest-950/80"></span>
                                <img class="w-full h-full object-cover"
                                    src="{{ asset('foto_produk/' . $produk->foto_produk) }}" alt="">
                            </div>
                            <input type="file" name="foto_produk_update" id="gambar"
                                class="w-full h-full relative z-2 font-black text-tea-100">
                            <small
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-tea-100 font-black">Format:
                                jpg, jpeg,
                                png. Maks: 2MB</small>
                        </div>
                    </figure>
                    @error('foto_produk_update')
                        <span class="text-red-500 text-xs mt-1 font-semibold">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                {{--  --}}
                {{-- nama_produk --}}
                <div class="flex flex-col flex-1 w-[15rem] lg:w-[20rem] justify-between">
                    <div>
                        <div class="flex flex-col gap-2">
                            <label for="" class="font-black text-font">Masukan Nama Produk</label>
                            <input value="{{ $produk->nama_produk }}" name="nama_produk_update" type="text"
                                class=" bg-tea-500 rounded-md  py-2  w-full px-1 text-font font-black">
                            @error('nama_produk_update')
                                <span class="text-red-500 text-xs mt-1 font-semibold">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2 mt-4">
                            <label for="" class="font-black text-font">Masukan Harga Produk</label>
                            <input value="{{ $produk->harga_produk }}" name="harga_produk_update" type="number"
                                min="0" class=" bg-tea-500 rounded-md  py-2  w-full px-1 text-font font-black">
                            @error('harga_produk_update')
                                <span class="text-red-500 text-xs mt-1 font-semibold">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-2 mt-4">
                            <label for="" class="font-black text-font">Masukan Deskripsi Produk</label>
                            <textarea name="deskripsi_produk_update" id=""
                                class=" bg-tea-500 rounded-md  py-2 max-h-[10rem] w-full px-1 text-font font-black">{{ $produk->deskripsi }}</textarea>
                            @error('deskripsi_produk_update')
                                <span class="text-red-500 text-xs mt-1 font-semibold">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full inline-flex justify-center py-3 bg-forest-950/80 outline-1 outline-forest-950 rounded-md cursor-pointer text-tea-100 font-black">Simpan
                        Produk</button>
                </div>
                {{--  --}}
            </div>
        </form>
    </section>
@endsection
