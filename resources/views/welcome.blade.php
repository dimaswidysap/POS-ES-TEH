<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Es Teh Segar — Point of Sale</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/css/landing-page.css', 'resources/js/app.js'])



</head>

<body class="font-montserrat bg-forest-800">


    <nav
        class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between 
            px-[5%]! md:px-12 h-[72px]
            bg-forest-800/85 backdrop-blur-md">

        {{-- Brand --}}
        <a href="#" class="flex items-center gap-3 no-underline" style="text-decoration:none;">
            <svg class="w-10 h-10 shrink-0" viewBox="0 0 40 40" fill="none">
                <circle cx="20" cy="20" r="19" fill="rgba(82,183,136,0.12)" stroke="rgba(82,183,136,0.4)"
                    stroke-width="1" />
                <path d="M20 8C20 8 10 14 10 22C10 28 14.5 32 20 32C25.5 32 30 28 30 22C30 14 20 8 20 8Z"
                    fill="#2d6a4f" />
                <path d="M20 8C20 8 10 14 10 22C10 28 14.5 32 20 32" fill="#52b788" opacity="0.8" />
                <path d="M20 12L20 30" stroke="rgba(255,255,255,0.3)" stroke-width="1" stroke-dasharray="2 2" />
                <path d="M20 18C20 18 15 16 13 19" stroke="rgba(255,255,255,0.25)" stroke-width="1" />
                <path d="M20 22C20 22 25 20 27 23" stroke="rgba(255,255,255,0.25)" stroke-width="1" />
            </svg>
            <span class="text-xl font-black text-white tracking-tight">
                Es Teh <span class="text-tea-400">Segar</span>
            </span>
        </a>

        {{-- Buttons --}}
        <div class="flex items-center gap-3">

            {{-- Kasir --}}
            <a style="text-decoration:none; transition: all 0.2s ease;"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                  text-[13px] font-semibold tracking-wide
                  text-forest-200 border border-forest-500/40 bg-forest-500/15
                  hover:bg-forest-500/25 hover:border-forest-500 hover:text-white
                  hover:-translate-y-0.5">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                    <path
                        d="M17 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59L5.25 14c-.16.28-.25.61-.25.96C5 16.1 5.9 17 7 17h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63H19c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0023.47 4H5.21l-.94-2H1zm6 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                </svg>
                Kasir
            </a>

            {{-- Admin --}}
            <a style="text-decoration:none; transition: all 0.2s ease;"
                class="flex items-center gap-2 px-5 py-2.5 rounded-lg
                  text-[13px] font-semibold tracking-wide
                  text-forest-800 bg-tea-600 border border-tea-600
                  hover:bg-tea-400 hover:border-tea-400 hover:-translate-y-0.5"
                onmouseover="this.style.boxShadow='0 4px 20px rgba(212,160,23,0.35)'"
                onmouseout="this.style.boxShadow='none'">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                </svg>
                Admin
            </a>
        </div>
    </nav>


    {{-- ═══════════════ HERO ═══════════════ --}}
    <section class="relative min-h-[100svh]  flex items-center overflow-hidden bg-forest-800">

        {{-- Background atmosphere --}}
        <div class="absolute inset-0 z-0 pointer-events-none">
            {{-- Light rays --}}
            <div class="light-ray animate-ray" style="left:10%; transform:rotate(-14deg); animation-delay:0s;"></div>
            <div class="light-ray animate-ray"
                style="left:20%; transform:rotate(-7deg); animation-delay:1.5s; opacity:0.55; width:1px;"></div>
            <div class="light-ray animate-ray" style="left:33%; transform:rotate(4deg); animation-delay:3s;"></div>
            <div class="light-ray animate-ray"
                style="right:30%; transform:rotate(-9deg); animation-delay:0.8s; width:3px; opacity:0.5;"></div>
            <div class="light-ray animate-ray" style="right:14%; transform:rotate(11deg); animation-delay:2.2s;"></div>

            {{-- Bokeh --}}
            <div class="bokeh-1 absolute rounded-full bg-forest-500 top-[10%] left-[4%]"
                style="width:400px; height:400px; filter:blur(70px); opacity:0.1;"></div>
            <div class="bokeh-2 absolute rounded-full bg-tea-400 top-[50%] left-[40%]"
                style="width:300px; height:300px; filter:blur(70px); opacity:0.07;"></div>
            <div class="bokeh-3 absolute rounded-full bg-forest-500 bottom-[12%] right-[8%]"
                style="width:250px; height:250px; filter:blur(60px); opacity:0.1;"></div>

            {{-- Subtle grid --}}
            <div class="absolute inset-0 opacity-[0.025]"
                style="background-image: repeating-linear-gradient(0deg, rgba(255,255,255,0.08) 0px, transparent 1px, transparent 40px), repeating-linear-gradient(90deg, rgba(255,255,255,0.08) 0px, transparent 1px, transparent 40px);">
            </div>
        </div>

        {{-- Content grid --}}
        <div
            class="relative left-1/2 -translate-x-1/2 z-10 w-full max-w-6xl 
                px-6 md:px-12 pt-24 pb-20
                grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-20 items-center">

            {{-- ── LEFT: Illustration ── --}}
            <div class="fade-up-img flex justify-center items-center relative order-2 md:order-1">

                {{-- Rings --}}
                <div class="animate-spin-slow absolute rounded-full border border-forest-500/25"
                    style="width:420px; height:420px;"></div>
                <div class="animate-spin-reverse absolute rounded-full border border-dashed border-tea-400/20"
                    style="width:330px; height:330px;"></div>

                {{-- Badge 1 --}}
                <div class="animate-float-d1 absolute z-20 flex items-center gap-2 px-4 py-2
                        rounded-full text-[12px] font-semibold text-forest-200 whitespace-nowrap
                        bg-forest-800/90 backdrop-blur-sm border border-forest-500/35"
                    style="top:10%; right:2%;">
                    <span class="w-2 h-2 rounded-full bg-forest-500 animate-blink shrink-0"></span>
                    Segar &amp; Dingin
                </div>

                {{-- Badge 2 --}}
                <div class="animate-float-d2 absolute z-20 flex items-center gap-2 px-4 py-2
                        rounded-full text-[12px] font-semibold text-forest-200 whitespace-nowrap
                        bg-forest-800/90 backdrop-blur-sm border border-forest-500/35"
                    style="bottom:18%; left:-2%;">
                    <span class="w-2 h-2 rounded-full bg-tea-400 shrink-0"></span>
                    Tanpa Pengawet
                </div>

                {{-- Badge 3 --}}
                <div class="animate-float-d3 absolute z-20 flex items-center gap-2 px-4 py-2
                        rounded-full text-[12px] font-semibold text-forest-200 whitespace-nowrap
                        bg-forest-800/90 backdrop-blur-sm border border-forest-500/35"
                    style="top:42%; left:-6%;">
                    <span class="w-2 h-2 rounded-full bg-forest-500 shrink-0"></span>
                    Varian Lengkap
                </div>

                {{-- Tea Glass SVG --}}
                <div class="animate-float relative z-10">
                    <svg viewBox="0 0 240 320" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="w-[200px] md:w-[260px]" style="filter: drop-shadow(0 28px 56px rgba(0,0,0,0.65));">

                        {{-- Glass body --}}
                        <path d="M55 60 L30 290 Q30 300 42 300 L198 300 Q210 300 210 290 L185 60 Z"
                            fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.25)" stroke-width="1.5" />

                        <clipPath id="gc">
                            <path d="M57 70 L32 285 Q32 296 43 296 L197 296 Q208 296 208 285 L183 70 Z" />
                        </clipPath>
                        <g clip-path="url(#gc)">
                            <rect x="30" y="120" width="180" height="180" fill="#3d1a00" opacity="0.9" />
                            <rect x="30" y="90" width="180" height="60" fill="#7b3d0a" opacity="0.9" />
                            <rect x="30" y="85" width="180" height="12" fill="#c87941" opacity="0.6" />

                            <rect x="65" y="130" width="36" height="36" rx="4"
                                fill="rgba(200,240,255,0.55)" stroke="rgba(255,255,255,0.6)" stroke-width="1" />
                            <rect x="62" y="127" width="36" height="36" rx="4"
                                fill="rgba(220,245,255,0.3)" stroke="rgba(255,255,255,0.35)" stroke-width="0.5" />
                            <rect x="120" y="155" width="42" height="42" rx="4"
                                fill="rgba(200,240,255,0.55)" stroke="rgba(255,255,255,0.6)" stroke-width="1" />
                            <rect x="117" y="152" width="42" height="42" rx="4"
                                fill="rgba(220,245,255,0.3)" stroke="rgba(255,255,255,0.35)" stroke-width="0.5" />
                            <rect x="80" y="190" width="30" height="30" rx="3"
                                fill="rgba(200,240,255,0.5)" stroke="rgba(255,255,255,0.5)" stroke-width="1" />
                            <rect x="145" y="210" width="34" height="34" rx="4"
                                fill="rgba(200,240,255,0.45)" stroke="rgba(255,255,255,0.5)" stroke-width="1" />

                            <line x1="72" y1="133" x2="82" y2="143"
                                stroke="rgba(255,255,255,0.6)" stroke-width="1.5" />
                            <line x1="127" y1="158" x2="137" y2="168"
                                stroke="rgba(255,255,255,0.6)" stroke-width="1.5" />
                            <line x1="86" y1="193" x2="93" y2="200"
                                stroke="rgba(255,255,255,0.5)" stroke-width="1.5" />
                        </g>

                        <path d="M55 60 L185 60" stroke="rgba(255,255,255,0.45)" stroke-width="2"
                            stroke-linecap="round" />
                        <path d="M58 70 L35 270" stroke="rgba(255,255,255,0.15)" stroke-width="3"
                            stroke-linecap="round" />

                        {{-- Straw --}}
                        <rect x="142" y="20" width="10" height="200" rx="5"
                            fill="rgba(82,183,136,0.85)" transform="rotate(-6 147 120)" />
                        <rect x="143" y="21" width="5" height="200" rx="3"
                            fill="rgba(130,220,170,0.5)" transform="rotate(-6 147 120)" />

                        {{-- Condensation --}}
                        <ellipse cx="72" cy="200" rx="3" ry="5"
                            fill="rgba(200,240,255,0.4)" />
                        <ellipse cx="175" cy="230" rx="2" ry="4"
                            fill="rgba(200,240,255,0.35)" />
                        <ellipse cx="90" cy="250" rx="2" ry="3.5"
                            fill="rgba(200,240,255,0.3)" />
                        <ellipse cx="160" cy="180" rx="2" ry="3"
                            fill="rgba(200,240,255,0.35)" />

                        {{-- Lemon --}}
                        <circle cx="92" cy="52" r="22" fill="#f4c842" opacity="0.95" />
                        <circle cx="92" cy="52" r="17" fill="#fef08a" />
                        <circle cx="92" cy="52" r="7" fill="#fde047" />
                        <line x1="92" y1="35" x2="92" y2="69"
                            stroke="rgba(255,255,255,0.6)" stroke-width="1" />
                        <line x1="75" y1="52" x2="109" y2="52"
                            stroke="rgba(255,255,255,0.6)" stroke-width="1" />
                        <line x1="80" y1="40" x2="104" y2="64"
                            stroke="rgba(255,255,255,0.4)" stroke-width="0.8" />
                        <line x1="104" y1="40" x2="80" y2="64"
                            stroke="rgba(255,255,255,0.4)" stroke-width="0.8" />

                        {{-- Mint --}}
                        <path d="M148 48C160 38 172 44 168 54C164 62 152 58 148 48Z" fill="#52b788" opacity="0.9" />
                        <path d="M158 44L158 52" stroke="rgba(255,255,255,0.5)" stroke-width="1" />
                        <path d="M155 47C158 44 162 46 158 52" stroke="rgba(255,255,255,0.3)" stroke-width="0.8"
                            fill="none" />
                        <path d="M162 40C172 32 182 40 177 50C172 58 163 52 162 40Z" fill="#3d9970" opacity="0.8" />
                        <path d="M170 37L168 48" stroke="rgba(255,255,255,0.4)" stroke-width="1" />
                    </svg>
                </div>
            </div>

            {{-- ── RIGHT: Text ── --}}
            <div class="flex flex-col gap-6 order-1 md:order-2">

                {{-- Tag --}}
                <div class="fade-up-1 flex items-center gap-2 w-fit
                        border border-forest-500/30 rounded-full px-4 py-1.5"
                    style="background: rgba(82,183,136,0.1);">
                    <span class="w-1.5 h-1.5 rounded-full bg-forest-500 animate-blink shrink-0"></span>
                    <span class="text-[11px] font-bold tracking-[1.5px] uppercase text-forest-500">
                        Point of Sale System
                    </span>
                </div>

                {{-- Headline --}}
                <h1 class="fade-up-2 text-white font-black leading-[1.05]"
                    style="font-size: clamp(36px, 4.5vw, 58px); letter-spacing: -1.5px;">
                    Kelola
                    <span class="block text-gradient">Es Teh Segar</span>
                    <span class="block font-light text-forest-200 mt-1" style="font-size: 0.6em; letter-spacing: 0;">
                        Lebih Mudah &amp; Cepat
                    </span>
                </h1>

                {{-- Divider --}}
                <div class="fade-up-3 w-12 h-0.5 rounded-full"
                    style="background: linear-gradient(to right, #d4a017, transparent);"></div>

                {{-- Description --}}
                <p class="fade-up-3 text-[15px] leading-relaxed max-w-md" style="color: rgba(183,228,199,0.72);">
                    Sistem kasir modern untuk bisnis es teh Anda. Catat transaksi,
                    kelola menu, dan pantau laporan penjualan dalam satu platform
                    yang ringan dan intuitif.
                </p>

                {{-- Stats --}}
                <div class="fade-up-4 flex gap-8 mt-1">
                    <div class="flex flex-col gap-0.5">
                        <span class="text-[28px] font-black text-white" style="letter-spacing:-0.5px;">
                            99<span class="text-tea-400">%</span>
                        </span>
                        <span class="text-[11px] font-medium tracking-[1px] uppercase"
                            style="color:rgba(183,228,199,0.5);">Uptime</span>
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <span class="text-[28px] font-black text-white" style="letter-spacing:-0.5px;">
                            <span class="text-tea-400">∞</span>
                        </span>
                        <span class="text-[11px] font-medium tracking-[1px] uppercase"
                            style="color:rgba(183,228,199,0.5);">Transaksi</span>
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <span class="text-[28px] font-black text-white" style="letter-spacing:-0.5px;">
                            24<span class="text-tea-400">/7</span>
                        </span>
                        <span class="text-[11px] font-medium tracking-[1px] uppercase"
                            style="color:rgba(183,228,199,0.5);">Tersedia</span>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="fade-up-5 flex items-center gap-4 mt-2 flex-wrap">
                    <a style="text-decoration:none; transition: all 0.2s ease;"
                        class="flex items-center gap-2.5 px-7 py-3.5 rounded-[10px]
                          bg-tea-600 text-forest-800 font-bold text-sm tracking-wide
                          hover:bg-tea-400 hover:-translate-y-0.5"
                        onmouseover="this.style.boxShadow='0 8px 28px rgba(212,160,23,0.4)'"
                        onmouseout="this.style.boxShadow='none'">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path
                                d="M17 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59L5.25 14c-.16.28-.25.61-.25.96C5 16.1 5.9 17 7 17h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63H19c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0023.47 4H5.21l-.94-2H1zm6 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                        </svg>
                        Masuk sebagai Kasir
                    </a>

                    <a style="text-decoration:none; transition: all 0.2s ease;"
                        class="flex items-center gap-2 px-6 py-3.5 rounded-[10px]
                          bg-transparent text-forest-200 font-semibold text-sm
                          border border-forest-500/35
                          hover:border-forest-500 hover:text-white hover:bg-forest-500/10">
                        Panel Admin →
                    </a>
                </div>
            </div>
        </div>

        {{-- Jungle silhouette --}}
        <div class="absolute bottom-0 left-0 right-0 z-20 pointer-events-none">
            <svg viewBox="0 0 1440 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                class="w-full block">
                <path fill="#050f09" d="M0,160 L0,90 C20,70 40,50 70,60 C90,65 100,80 120,75 C140,70 150,45 180,40
                     C210,35 230,55 250,65 C270,75 280,70 300,55 C320,40 340,20 370,30
                     C390,38 400,60 420,65 C440,70 450,60 470,45 C490,30 510,10 540,15
                     C560,18 575,40 595,50 C615,60 625,55 645,38 C665,22 680,5 710,8
                     C730,10 745,30 765,42 C785,54 795,58 815,48 C835,38 845,18 875,12
                     C900,6 920,22 940,35 C960,48 970,55 990,50 C1010,45 1020,30 1050,25
                     C1075,20 1095,35 1115,48 C1135,60 1145,65 1165,58 C1185,50 1195,30 1220,22
                     C1245,14 1265,25 1285,38 C1305,50 1315,60 1340,55
                     C1365,50 1380,35 1410,40 C1430,44 1440,55 1440,60 L1440,160 Z" />
                {{-- Tree trunks --}}
                <path fill="#040d08" d="M100 160L100 60C100 60 85 40 100 20C115 40 130 60 130 60L130 160Z" />
                <path fill="#061208" d="M88 62C88 62 68 30 100 10C132 30 112 62 112 62Z" />

                <path fill="#040d08" d="M350 160L350 50C350 50 330 25 355 5C380 25 360 50 360 50L360 160Z" />
                <path fill="#061208" d="M335 55C335 55 315 28 350 5C385 28 365 55 365 55Z" />

                <path fill="#040d08" d="M700 160L700 40C700 40 678 12 705 -8C732 12 710 40 715 40L715 160Z" />
                <path fill="#061208" d="M682 45C682 45 660 15 702 -5C744 15 720 45 722 45Z" />

                <path fill="#040d08" d="M1050 160L1050 55C1050 55 1030 28 1055 8C1080 28 1060 55 1065 55L1065 160Z" />
                <path fill="#061208" d="M1035 60C1035 60 1015 32 1052 10C1089 32 1067 60 1068 60Z" />

                <path fill="#040d08" d="M1340 160L1340 65C1340 65 1322 38 1345 18C1368 38 1352 65 1355 65L1355 160Z" />
                <path fill="#061208" d="M1325 70C1325 70 1308 42 1342 22C1376 42 1358 70 1358 70Z" />
            </svg>
        </div>

    </section>


    {{-- ═══════════════ FOOTER ═══════════════ --}}
    <footer class="bg-forest-950 py-8 px-6 md:px-12" style="border-top: 1px solid rgba(82,183,136,0.15);">
        <div class="max-w-6xl mx-auto flex items-center justify-between gap-6 flex-wrap">

            {{-- Brand --}}
            <div class="flex items-center gap-2.5">
                <svg class="w-7 h-7 shrink-0" viewBox="0 0 40 40" fill="none">
                    <circle cx="20" cy="20" r="19" fill="rgba(82,183,136,0.1)"
                        stroke="rgba(82,183,136,0.3)" stroke-width="1" />
                    <path d="M20 8C20 8 10 14 10 22C10 28 14.5 32 20 32C25.5 32 30 28 30 22C30 14 20 8 20 8Z"
                        fill="#2d6a4f" />
                    <path d="M20 8C20 8 10 14 10 22C10 28 14.5 32 20 32" fill="#52b788" opacity="0.7" />
                </svg>
                <span class="text-base font-black text-white">Es Teh <span class="text-tea-400">Segar</span></span>
            </div>

            {{-- Copyright --}}
            <span class="text-xs font-normal" style="color:rgba(183,228,199,0.35);">
                © {{ date('Y') }} Es Teh Segar. Hak cipta dilindungi.
            </span>

            {{-- Links --}}
            <div class="flex items-center gap-6">
                <a href="#" style="text-decoration:none; color:rgba(183,228,199,0.45); transition:color 0.2s;"
                    class="text-xs font-medium hover:text-forest-500">Bantuan</a>
                <a href="#" style="text-decoration:none; color:rgba(183,228,199,0.45); transition:color 0.2s;"
                    class="text-xs font-medium hover:text-forest-500">Kebijakan</a>
            </div>

            {{-- Version badge --}}
            <span class="text-[11px] font-semibold tracking-[1px] rounded-full px-3 py-1"
                style="color:rgba(82,183,136,0.5); background:rgba(82,183,136,0.08); border:1px solid rgba(82,183,136,0.15);">
                v1.0.0
            </span>
        </div>
    </footer>

</body>

</html>
