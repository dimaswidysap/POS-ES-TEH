@extends('components.master')

@section('content')
    <section class="w-full">
        @include('components.sidebarAdmin')


        <section class="w-full  pt-[5rem]">
            <div class="w-full p-6">
                <div class="overflow-hidden ">
                    <table class="w-full border-collapse text-left text-sm text-gray-500">
                        <thead class="bg-forest-950/90">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-black text-tea-100 rounded-l-xl">Nama</th>
                                <th scope="col" class="px-6 py-4 font-black text-tea-100 ">Harga</th>
                                <th scope="col" class="px-6 py-4 font-black text-tea-100 ">Deskripsi</th>
                                <th scope="col" class="py-4 font-black text-tea-100 rounded-r-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($produk as $item)
                                <tr class="">
                                    <td class="px-6 py-4 font-black text-font ">{{ $item->nama_produk }}</td>
                                    <td class="px-6 py-4 text-font font-black">Rp
                                        {{ number_format($item->harga_produk, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-font">{{ Str::limit($item->deskripsi, 50) }}</td>
                                    <td class="">
                                        <div class="flex justify-start gap-3">
                                            <a
                                                class="inline-flex h-8 border border-forest-300 shadow-xl aspect-square bg-tea-600/50 rounded-full"></a>
                                            <a
                                                class="inline-flex h-8 border border-forest-300 shadow-xl aspect-square bg-tea-600/50 rounded-full"></a>
                                            <a
                                                class="inline-flex h-8 border border-forest-300 shadow-xl aspect-square bg-tea-600/50 rounded-full"></a>
                                            {{-- <a href="{{ route('admin.menu.delete', $item->id) }}"
                                                class="text-red-600 hover:text-red-900 font-medium"
                                                onclick="return confirm('Yakin ingin menghapus?')">Delete</a> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </section>
@endsection
