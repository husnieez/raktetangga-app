<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'RakTetangga — Meja Buku & Board Game Komunitas' }}</title>

    <!-- Google Fonts: Fraunces (Expressive Serif), Plus Jakarta Sans (Humanist UI), JetBrains Mono (Library Stamp) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;0,9..144,800;1,9..144,400&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite / Direct) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            canvas: '#F6F1E7',
                            cardstock: '#FFFDF9',
                            espresso: '#2C241E',
                            clay: '#6E6259',
                            terracotta: {
                                DEFAULT: '#D95D39',
                                hover: '#C24D2B',
                                active: '#A94022',
                            },
                            sage: {
                                DEFAULT: '#3A6B56',
                                light: '#EAF2EE',
                                dark: '#2E5544',
                            },
                            ochre: {
                                DEFAULT: '#E09F3E',
                                light: '#FDF5E8',
                                dark: '#BF8228',
                            },
                            manila: '#EFE7D8',
                            rule: '#D8CFC0',
                        },
                        fontFamily: {
                            serif: ['Fraunces', 'serif'],
                            sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                            mono: ['"JetBrains Mono"', 'monospace'],
                        },
                        boxShadow: {
                            'hard-xs': '2px 2px 0px #2C241E',
                            'hard-sm': '3px 3px 0px #2C241E',
                            'hard': '4px 4px 0px #2C241E',
                            'hard-lg': '6px 6px 0px #2C241E',
                        }
                    }
                }
            }
        </script>
        <style>
            body {
                background-color: #F6F1E7;
                color: #2C241E;
                font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            }
            .paper-grain::before {
                content: "";
                position: fixed;
                top: 0; left: 0; width: 100vw; height: 100vh;
                pointer-events: none;
                z-index: 9999;
                opacity: 0.035;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            }
            .library-lines {
                background-image: repeating-linear-gradient(to bottom, transparent, transparent 31px, #D8CFC0 31px, #D8CFC0 32px);
            }
        </style>
    @endif

   
    @livewireStyles
</head>
<body class="bg-[#F6F1E7] text-[#2C241E] paper-grain min-h-screen flex flex-col selection:bg-[#E09F3E]/30 selection:text-[#2C241E]">

    <!-- Main Navigation Bar (Single-Row h-16, Zero Wrapping) -->
    <header x-data="{ mobileMenuOpen: false }" class="border-b-2 border-[#2C241E] bg-[#FFFDF9] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            
            <!-- Simplified Left Brand Area -->
            <div class="flex items-center gap-3 min-w-0">
                <a href="/" class="flex items-center gap-2.5 group whitespace-nowrap shrink-0">
                    <div class="w-9 h-9 bg-[#D95D39] border-[1.5px] border-[#2C241E] flex items-center justify-center text-[#FFFDF9] shadow-[2px_2px_0px_#2C241E] group-hover:-translate-x-0.5 group-hover:-translate-y-0.5 transition-all shrink-0">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M19 2H6c-1.2 0-2 .8-2 2v16c0 1.2.8 2 2 2h13c.6 0 1-.4 1-1V3c0-.6-.4-1-1-1zm-1 18H6c-.6 0-1-.4-1-1V5c.3-.3.7-.5 1-.5h12v15.5z"/>
                            <circle cx="12" cy="9" r="2.5" />
                            <path d="M9.5 16c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v1.5h-5V16z"/>
                        </svg>
                    </div>
                    <span class="font-serif text-xl font-bold tracking-tight text-[#2C241E] whitespace-nowrap">RakTetangga</span>
                </a>

                <span class="hidden sm:inline-flex items-center text-xs font-mono bg-[#EFE9DC] text-[#2C241E] px-2.5 py-1 rounded-md border border-[#2C241E]/20 whitespace-nowrap shrink-0">
                    RT 04 / RW 07 • 800m
                </span>
            </div>

            <!-- Right Navigation & Actions -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                
                <!-- Secondary Nav Links (Desktop >= md, Borderless, No Hard Shadows) -->
                <nav class="hidden md:flex items-center gap-1">
                    <button 
                        type="button"
                        @click="$dispatch('open-rulebook')"
                        class="text-sm font-medium text-[#2C241E]/80 hover:text-[#2C241E] hover:bg-[#EFE9DC]/70 px-3 py-2 rounded-lg transition whitespace-nowrap flex items-center gap-1.5 cursor-pointer"
                    >
                        <span>📖</span>
                        <span>Cara Kerja</span>
                    </button>

                    <a 
                        href="/aktivitas"
                        class="text-sm font-medium text-[#2C241E]/80 hover:text-[#2C241E] hover:bg-[#EFE9DC]/70 px-3 py-2 rounded-lg transition whitespace-nowrap flex items-center gap-1.5"
                    >
                        <span>📋</span>
                        <span>Aktivitas</span>
                        <span class="px-1.5 py-0.5 text-[10px] font-mono rounded-full bg-[#D95D39] text-[#FFFDF9] font-bold leading-none whitespace-nowrap">2</span>
                    </a>
                </nav>

            <!-- Unified Wallet & Member Profile Compact Pill -->
            <div class="hidden sm:flex items-center divide-x divide-[#2C241E]/20 border border-[#2C241E]/30 bg-[#F6F1E7] rounded-lg text-xs font-mono overflow-hidden whitespace-nowrap">
                @auth
                    <a href="/dompet" title="Dompet Warga & Daftar Antrean"
                        class="px-2.5 py-1.5 hover:bg-[#EFE9DC]/70 transition flex items-center gap-1.5 text-[#2E5544] font-bold whitespace-nowrap">
                        <span>💰</span>
                        <span>Rp {{ number_format(auth()->user()->balance / 1000, 0) }}rb</span>
                    </a>
                    <a href="/login" title="Kartu Anggota ({{ auth()->user()->name }})"
                        class="px-2.5 py-1.5 hover:bg-[#EFE9DC]/70 transition flex items-center gap-1.5 text-[#2C241E] font-bold whitespace-nowrap">
                        <span class="w-2 h-2 rounded-full bg-[#3A6B56]"></span>
                        <span>{{ auth()->user()->member_code ?? '#RT-BARU' }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" title="Keluar Akun"
                            class="px-2.5 py-1.5 hover:bg-[#D95D39]/15 text-[#D95D39] font-bold transition cursor-pointer">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="/login" title="Masuk atau Daftar Kartu Anggota"
                        class="px-3 py-1.5 hover:bg-[#EFE9DC]/70 transition flex items-center gap-1.5 text-[#2C241E] font-bold whitespace-nowrap">
                        <span class="w-2 h-2 rounded-full bg-[#D95D39]"></span>
                        <span>Masuk / Daftar Kartu</span>
                    </a>
                @endauth
            </div>

                <!-- Primary CTA (Only button with 1.5px border & hard shadow) -->
                <a href="/rak-koleksiku" class="bg-[#D95D39] text-[#FFFDF9] border-[1.5px] border-[#2C241E] px-3.5 py-2 text-xs font-sans font-bold shadow-[3px_3px_0px_#2C241E] hover:bg-[#C24D2B] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all flex items-center gap-1.5 whitespace-nowrap">
                    <span>+</span>
                    <span>Titip Koleksi</span>
                </a>

                <!-- Mobile Menu Toggle (< md) -->
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden p-2 text-[#2C241E] hover:bg-[#EFE9DC]/70 rounded-lg transition cursor-pointer whitespace-nowrap"
                    aria-label="Menu Navigasi">
                    <span class="font-mono text-base font-bold" x-text="mobileMenuOpen ? '✕' : '☰'"></span>
                </button>
            </div>

        </div>

        <!-- Clean Mobile Dropdown Menu (< md) -->
        <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden border-t border-[#D8CFC0] bg-[#FFFDF9] px-4 py-3 space-y-2">
            <div class="flex items-center justify-between text-xs font-mono text-[#6E6259] pb-2 border-b border-[#D8CFC0]/60">
                <span>Wilayah: RT 04 / RW 07 • 800m</span>
            </div>
            <button type="button" @click="$dispatch('open-rulebook'); mobileMenuOpen = false"
                class="w-full text-left text-sm font-medium text-[#2C241E] hover:bg-[#EFE9DC]/70 px-3 py-2 rounded-lg flex items-center gap-2 whitespace-nowrap">
                <span>📖</span><span>Cara Kerja</span>
            </button>
            <a href="/aktivitas"
                class="w-full text-sm font-medium text-[#2C241E] hover:bg-[#EFE9DC]/70 px-3 py-2 rounded-lg flex items-center justify-between whitespace-nowrap">
                <span class="flex items-center gap-2"><span>📋</span><span>Aktivitas Sewa</span></span>
                <span class="px-1.5 py-0.5 text-[10px] font-mono rounded-full bg-[#D95D39] text-[#FFFDF9] font-bold">2</span>
            </a>
            <div class="sm:hidden flex items-center divide-x divide-[#2C241E]/20 border border-[#2C241E]/30 bg-[#F6F1E7] rounded-lg text-xs font-mono overflow-hidden">
                @auth
                    <a href="/dompet" class="flex-1 py-2 text-center font-bold text-[#2E5544] whitespace-nowrap">
                        💰 Rp {{ number_format(auth()->user()->balance / 1000, 0) }}rb
                    </a>
                    <a href="/login" class="flex-1 py-2 text-center font-bold text-[#2C241E] whitespace-nowrap">
                        ● {{ auth()->user()->member_code ?? '#RT-BARU' }}
                    </a>
                @else
                    <a href="/login" class="flex-1 py-2 text-center font-bold text-[#2C241E] whitespace-nowrap">
                        ● Masuk / Daftar Kartu
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Cozy Analog Footer -->
    <footer class="border-t-2 border-[#2C241E] bg-[#FFFDF9] mt-16 pt-10 pb-8 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 pb-8 border-b border-[#D8CFC0]">
                
                <!-- Col 1: About RakTetangga -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="font-serif font-bold text-xl text-[#2C241E]">RakTetangga</span>
                        <span class="font-mono text-xs text-[#6E6259]">/ Inisiatif Rukun Warga</span>
                    </div>
                    <p class="text-[#6E6259] text-xs leading-relaxed max-w-md mb-4 font-sans">
                        Gerakan gotong-royong membaca dan bermain bersama tetangga sekitar. Menghidupkan kembali buku di rak berdebu dan board game di dalam lemari agar bisa dinikmati bersama di teras sore hari.
                    </p>
                    <div class="inline-flex items-center gap-2 text-xs font-mono bg-[#F6F1E7] border border-[#2C241E] px-2.5 py-1.5 shadow-[2px_2px_0px_#2C241E]">
                        <span>📜 Filosofi:</span>
                        <span class="font-bold">Rawat Seperti Milik Sendiri, Kembalikan Tepat Janji</span>
                    </div>
                </div>

                <!-- Col 2: Aturan Main Tetangga -->
                <div>
                    <h4 class="font-serif font-bold text-sm text-[#2C241E] mb-3 uppercase tracking-wider">Aturan Peminjaman</h4>
                    <ul class="text-xs text-[#6E6259] space-y-2 font-mono">
                        <li class="flex items-start gap-1.5">
                            <span class="text-[#3A6B56] font-bold">✓</span>
                            <span>Cek kartu komponen saat serah terima</span>
                        </li>
                        <li class="flex items-start gap-1.5">
                            <span class="text-[#3A6B56] font-bold">✓</span>
                            <span>Jaga dari tumpahan kopi & teh hangat</span>
                        </li>
                        <li class="flex items-start gap-1.5">
                            <span class="text-[#3A6B56] font-bold">✓</span>
                            <span>Uang jaminan otomatis kembali 100%</span>
                        </li>
                        <li class="flex items-start gap-1.5">
                            <span class="text-[#E09F3E] font-bold">✓</span>
                            <span>Telat? Cukup chat pemilik & traktir gorengan</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Titik Drop Point -->
                <div>
                    <h4 class="font-serif font-bold text-sm text-[#2C241E] mb-3 uppercase tracking-wider">Titik Serah Terima</h4>
                    <ul class="text-xs text-[#6E6259] space-y-2">
                        <li class="flex items-center justify-between border-b border-[#D8CFC0]/60 pb-1">
                            <span>Pos Satpam Blok C</span>
                            <span class="font-mono text-[#3A6B56] text-[11px]">24 Jam</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-[#D8CFC0]/60 pb-1">
                            <span>Warung Kopi Bu RT</span>
                            <span class="font-mono text-[#6E6259] text-[11px]">07.00 - 21.00</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Teras Rumah Pemilik</span>
                            <span class="font-mono text-[#D95D39] text-[11px]">Janji Temu</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright & Analog Stamp -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-[#6E6259] font-mono">
                <p>© 2026 RakTetangga • Dibangun dengan cinta, kayu kopi, dan kertas buram.</p>
                <div class="flex items-center gap-3">
                    <span class="stamp-badge border-[#3A6B56] text-[#3A6B56] text-[10px]">TERVERIFIKASI WARGA</span>
                    <span>Kode Wilayah: BT-04-07</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Panduan Warga / Rulebook Modal -->
    <x-rulebook-modal />

    @livewireScripts
</body>
</html>

