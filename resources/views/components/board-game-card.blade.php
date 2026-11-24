@props([
    'item' => null,
])

@php
    $id = $item['id'] ?? 'BG-001';
    $code = $item['code'] ?? 'BG-014';
    $title = $item['title'] ?? 'Catan: Edisi Bahasa';
    $genre = $item['genre'] ?? 'Strategi & Perdagangan';
    $players = $item['players'] ?? '3-4 Pemain';
    $duration = $item['duration'] ?? '60-90 Mnt';
    $age = $item['age'] ?? '10+ Thn';
    $pieces = $item['pieces'] ?? '96 Kartu, 16 Kota, 2 Dadu';
    $rate = $item['daily_rate'] ?? 15000;
    $deposit = $item['deposit'] ?? 50000;
    $owner = $item['owner'] ?? 'Mas Dimas';
    $location = $item['location'] ?? 'Blok C-12 • 250m';
    $status = $item['status'] ?? 'TERSEDIA';
    $coverBg = $item['cover_bg'] ?? '#E09F3E';
    $thumbnail = $item['thumbnail'] ?? null;
@endphp

<div 
    x-data="{ hovered: false }"
    @mouseenter="hovered = true"
    @mouseleave="hovered = false"
    class="relative bg-[#FFFDF9] border-2 border-[#2C241E] rounded-none shadow-[4px_4px_0px_#2C241E] hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[6px_6px_0px_#2C241E] transition-all duration-150 flex flex-col justify-between overflow-hidden group"
>
    <!-- Top Box Lip / Lid Header -->
    <div class="border-b-[1.5px] border-[#2C241E] bg-[#EFE7D8] px-3.5 py-2 flex items-center justify-between text-xs font-mono">
        <div class="flex items-center gap-1.5 font-bold text-[#2C241E]">
            <span class="w-2 h-2 bg-[#D95D39] border border-[#2C241E] inline-block"></span>
            <span>{{ $code }}</span>
            <span class="text-[#6E6259] font-normal">• BOARD GAME BOX</span>
        </div>
        <x-stamp-badge :status="$status" size="sm" rotate="-rotate-2" />
    </div>

    <!-- Box Cover Artwork / Visual Container -->
    <div class="relative p-4 pb-2 bg-[#FFFDF9]">
        <!-- Tabletop Box Illustration Area -->
        <div class="h-44 w-full border-[1.5px] border-[#2C241E] relative flex flex-col items-center justify-center p-4 text-center overflow-hidden" style="background-color: {{ $coverBg }};">
            <!-- Diagonal Box Sheen Pattern -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#2C241E_1px,transparent_1px)] [background-size:8px_8px]"></div>

            <!-- Vintage Badge on Box Top -->
            <div class="relative z-10 bg-[#FFFDF9] border border-[#2C241E] px-2.5 py-1 text-[10px] font-mono uppercase tracking-wider text-[#2C241E] font-bold shadow-[2px_2px_0px_#2C241E] mb-2">
                {{ $genre }}
            </div>

            <!-- Title on Board Game Box -->
            <h3 class="relative z-10 font-serif font-black text-xl text-[#2C241E] leading-tight max-w-[220px]">
                {{ $title }}
            </h3>

            <!-- Board Game Box Quick Spec Tokens -->
            <div class="relative z-10 mt-3 flex items-center justify-center gap-2 text-[11px] font-mono text-[#2C241E]">
                <span class="bg-[#FFFDF9]/90 border border-[#2C241E] px-1.5 py-0.5 font-semibold">👥 {{ $players }}</span>
                <span class="bg-[#FFFDF9]/90 border border-[#2C241E] px-1.5 py-0.5 font-semibold">⏱ {{ $duration }}</span>
            </div>

            <!-- Box Corner Bumpers (Reinforced Tabletop Box Aesthetic) -->
            <div class="absolute top-1 left-1 w-3 h-3 border-t-2 border-l-2 border-[#2C241E]"></div>
            <div class="absolute top-1 right-1 w-3 h-3 border-t-2 border-r-2 border-[#2C241E]"></div>
            <div class="absolute bottom-1 left-1 w-3 h-3 border-b-2 border-l-2 border-[#2C241E]"></div>
            <div class="absolute bottom-1 right-1 w-3 h-3 border-b-2 border-r-2 border-[#2C241E]"></div>
        </div>

        <!-- Alpine.js Hover Box-Contents Peek Drawer -->
        <div 
            x-show="hovered"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
            class="mt-2 bg-[#EAF2EE] border-[1.5px] border-[#3A6B56] p-2 text-xs font-mono text-[#2E5544] flex items-center justify-between shadow-[2px_2px_0px_#3A6B56]"
        >
            <div class="flex items-center gap-1.5">
                <span class="text-sm">🎲</span>
                <span class="font-bold">Isi Kotak:</span>
                <span class="truncate max-w-[170px] text-[11px]">{{ $pieces }}</span>
            </div>
            <button 
                type="button"
                @click="$dispatch('open-checklist', {{ json_encode($item) }})"
                class="text-[10px] uppercase font-bold underline hover:text-[#D95D39] whitespace-nowrap ml-1"
            >
                Cek Fisik →
            </button>
        </div>
    </div>

    <!-- Metadata & Price Stamp Card Section -->
    <div class="p-4 pt-1 flex flex-col gap-3">
        
        <!-- Owner & Neighborhood Location -->
        <div class="flex items-center justify-between text-xs text-[#6E6259] pt-2 border-t border-[#D8CFC0]">
            <div class="flex items-center gap-1.5">
                <span class="w-5 h-5 rounded-full bg-[#EFE7D8] border border-[#2C241E] flex items-center justify-center font-bold text-[10px] text-[#2C241E]">
                    {{ substr($owner, 0, 1) }}
                </span>
                <span class="font-medium text-[#2C241E]">{{ $owner }}</span>
            </div>
            <span class="font-mono text-[11px] bg-[#F6F1E7] px-1.5 py-0.5 border border-[#D8CFC0]">
                📍 {{ $location }}
            </span>
        </div>

        <!-- Price Rate & CTA Bar -->
        <div class="flex items-center justify-between gap-2 pt-1">
            <div>
                <div class="text-[10px] font-mono uppercase text-[#6E6259]">Tarif Komunitas:</div>
                <div class="font-mono text-base font-bold text-[#2C241E] leading-tight">
                    Rp {{ number_format($rate, 0, ',', '.') }}<span class="text-xs font-normal text-[#6E6259]">/hari</span>
                </div>
            </div>

            <div class="flex items-center gap-1.5">
                <!-- Checklist Trigger Button -->
                <button 
                    type="button"
                    @click="$dispatch('open-checklist', {{ json_encode($item) }})"
                    title="Cek Kelengkapan Dadu & Komponen"
                    class="p-2 bg-[#FFFDF9] text-[#2C241E] border-[1.5px] border-[#2C241E] shadow-[2px_2px_0px_#2C241E] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all text-xs"
                >
                    🔍 Cek
                </button>

                <!-- Rent / Checkout Modal Button -->
                <button 
                    type="button"
                    @if($status === 'TERSEDIA')
                        @click="$dispatch('open-checkout', {{ json_encode($item) }})"
                        class="px-3.5 py-2 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-xs border-[1.5px] border-[#2C241E] shadow-[3px_3px_0px_#2C241E] hover:bg-[#C24D2B] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all"
                    @else
                        disabled
                        class="px-3 py-2 bg-[#EFE7D8] text-[#6E6259] font-sans font-bold text-xs border-[1.5px] border-[#6E6259] shadow-[2px_2px_0px_#6E6259] cursor-not-allowed opacity-75"
                    @endif
                >
                    @if($status === 'TERSEDIA')
                        Pinjam Game
                    @elseif($status === 'DIPINJAM')
                        Masuk Antrian
                    @else
                        Booking
                    @endif
                </button>
            </div>
        </div>

    </div>
</div>

