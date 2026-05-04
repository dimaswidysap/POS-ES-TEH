@php
    $nav = [
        ['name' => 'Dashboard', 'url' => 'admin.index'],
        ['name' => 'Order', 'url' => 'admin.order'], // Ganti dengan nama route order Anda
        ['name' => 'Menu', 'url' => 'admin.menu'],
        ['name' => 'User', 'url' => 'admin.user'], // Ganti dengan nama route user Anda
    ];
@endphp

@vite('resources/ts/admin/nav.ts')

<header
    class="fixed font-Montserrat  top-0 left-0 right-0 z-50 flex items-center justify-end
            px-[5%]! md:px-12 h-16
            bg-forest-800/85 backdrop-blur-md border-b border-forest-500 shadow-2xl">
    {{-- sidebar --}}
    <div class="h-full flex items-center justify-start px-5 absolute w-1/2 md:w-1/3 lg:w-1/5  left-0">
        <button id="open-sidebar"
            class="h-[70%] aspect-square bg-tea-600 outline-1 outline-tea-300 rounded-full"></button>
    </div>

    {{-- container profil login --}}
    <div class="h-full gap-4 flex items-center">
        <figure class="h-[70%] aspect-square bg-tea-600 rounded-full"></figure>

        <span class="font-black text-tea-100">Admin 1</span>
    </div>

    {{-- side bar --}}
    <section
        class="sidebar shadow-2xl -translate-x-full transition-all duration-500 flex  flex-col w-1/2 md:w-1/3 lg:w-1/5 h-screen absolute left-0 top-0 z-50 flex bg-forest-800 backdrop-blur-md">
        {{-- container konten --}}
        <div class="absolute h-full w-full z-2">
            {{-- header sidebar --}}
            <header class="w-full h-16 flex items-center justify-start px-5 gap-4">
                <button id="close-sidebar"
                    class="h-[70%] aspect-square bg-tea-600 outline-1 outline-tea-300 rounded-full"></button>
                <span class="font-black text-tea-100 text-2xl">Navigasi</span>
            </header>
            <nav class="w-full mt-[4rem] px-5 gap-4 flex flex-col">
                @foreach ($nav as $link)
                    <a href="{{ route($link['url']) }}"
                        class="inline-flex relative items-center gap-3 text-tea-100 
   {{ request()->routeIs($link['url']) ? 'bg-forest-800 py-2 px-2 rounded-4xl border border-tea-300/40' : '' }}">

                        <figure class="h-9 relative z-2 aspect-square bg-tea-600 rounded-full"></figure>

                        <span class="font-black relative z-2">{{ $link['name'] }}</span>

                        {{-- container hiasan --}}
                        <div class="absolute h-full w-full inset-0 rounded-4xl overflow-hidden">
                            <span
                                class="h-full aspect-square rounded-full right-0 absolute bg-forest-500/60 blur-[30px] inline-flex"></span>
                        </div>
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- container hiasan --}}
        <div class="w-full h-full relative overflow-hidden">
            <span
                class="inline-flex h-1/3 absolute aspect-square bg-tea-600/60 bottom-0 -left-10 rounded-full translate-y-1/2 blur-[90px]"></span>
        </div>
    </section>


</header>
