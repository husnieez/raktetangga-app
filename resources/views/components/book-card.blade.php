@props([
    'item' => null,
])

@php
    $id = $item['id'] ?? 'BK-001';
    $code = $item['code'] ?? 'BK-108';
    $title = $item['title'] ?? 'Cantik Itu Luka';
    $author = $item['author'] ?? 'Eka Kurniawan';
    $category = $item['category'] ?? 'Sastra Indonesia';
    $pages = $item['pages'] ?? '508 Hlm';
    $rate = $item['daily_rate'] ?? 3000;
    $deposit = $item['deposit'] ?? 20000;
    $owner = $item['owner'] ?? 'Mbak Maya';
    $location = $item['location'] ?? 'Blok B-08 • 180m';
    $status = $item['status'] ?? 'TERSEDIA';
    $coverTone = $item['cover_tone'] ?? '#EFE7D8';
    $spineColor = $item['spine_color'] ?? '#2C241E';
    $ribbonColor = $item['ribbon_color'] ?? '#D95D39';
@endphp

<div 
    x-data="{ showBookmark: false }"
    @mouseenter="showBookmark = true"
    @mouseleave="showBookmark = false"
    class="relative bg-[#FFFDF9] border-2 border-[#2C241E] rounded-none shadow-[4px_4px_0px_#2C241E] hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[6px_6px_0px_#2C241E] transition-all duration-150 flex flex-col justify-between overflow-hidden group"
>
    <!-- Bookmark Ribbon peeking from top of the book -->
    <div 
        class="absolute -top-1 right-6 w-3.5 h-7 z-20 transition-all duration-200 border-x border-b border-[#2C241E] shadow-[1px_1px_0px_#2C241E]"
        :class="showBookmark ? 'h-9 translate-y-1' : 'h-6'"
        style="background-color: {{ $ribbonColor }}; clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 50% 82%, 0% 100%);"
    ></div>

    <!-- Header bar with Item Call Tag -->
    <div class="border-b-[1.5px] border-[#2C241E] bg-[#EFE7D8] px-3.5 py-2 flex items-center justify-between text-xs font-mono">
        <div class="flex items-center gap-1.5 font-bold text-[#2C241E]">
            <span class="w-2 h-2 bg-[#3A6B56] border border-[#2C241E] inline-block"></span>
            <span>{{ $code }}</span>
            <span class="text-[#6E6259] font-normal">• BUKU FISIK</span>
        </div>
        <x-stamp-badge :status="$status" size="sm" rotate="rotate-2" />
    </div>

    <!-- Book Body with Spine Crease Illusion -->
    <div class="p-4 pb-2 bg-[#FFFDF9]">
        <!-- Upright Tall Book Cover with Spine Crease -->
        <div class="relative min-h-[170px] border-[1.5px] border-[#2C241E] border-l-[6px] border-l-[#2C241E] p-4 flex flex-col justify-between" style="background-color: {{ $coverTone }};">
            
            <!-- Spine Crease Shadow Gradient -->
            <div class="absolute top-0 left-0 bottom-0 w-3 bg-gradient-to-r from-[#2C241E]/25 via-[#2C241E]/05 to-transparent pointer-events-none"></div>

            <!-- Library Call Sticker at top spine -->
            <div class="flex items-start justify-between">
                <span class="bg-[#FFFDF9] border border-[#2C241E] px-1.5 py-0.5 font-mono text-[10px] font-bold text-[#2C241E] shadow-[1px_1px_0px_#2C241E]">
                    {{ $category }}
                </span>
                <span class="font-mono text-[10px] text-[#6E6259]">{{ $pages }}</span>
            </div>

            <!-- Book Title & Author -->
            <div class="my-3 pl-1">
                <h3 class="font-serif font-black text-xl text-[#2C241E] leading-snug group-hover:text-[#D95D39] transition-colors">
                    {{ $title }}
                </h3>
                <p class="font-sans text-xs text-[#6E6259] italic mt-1 font-medium">
                    oleh {{ $author }}
                </p>
            </div>

            <!-- Library Pocket / Barcode Stamp Simulation -->
            <div class="pt-2 border-t border-[#2C241E]/20 flex items-center justify-between text-[10px] font-mono text-[#6E6259]">
                <span class="tracking-widest">|||||| | |||||</span>
                <span>EDISI CETAK ASLI</span>
            </div>
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

            <button 
                type="button"
                @if($status === 'TERSEDIA')
                    @click="$dispatch('open-checkout', {{ json_encode($item) }})"
                    class="px-4 py-2 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-xs border-[1.5px] border-[#2C241E] shadow-[3px_3px_0px_#2C241E] hover:bg-[#C24D2B] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all flex items-center gap-1.5"
                @else
                    disabled
                    class="px-3.5 py-2 bg-[#EFE7D8] text-[#6E6259] font-sans font-bold text-xs border-[1.5px] border-[#6E6259] shadow-[2px_2px_0px_#6E6259] cursor-not-allowed opacity-75"
                @endif
            >
                @if($status === 'TERSEDIA')
                    <span>📖 Pinjam Buku</span>
                @else
                    <span>Antrian</span>
                @endif
            </button>
        </div>
    </div>
</div>

