@props([
    'status' => 'TERSEDIA', // TERSEDIA, DIPINJAM, ANTRIAN, VERIFIKASI
    'rotate' => '-rotate-2',
    'size' => 'normal',
])

@php
    $statusMap = [
        'TERSEDIA' => [
            'border' => 'border-[#3A6B56]',
            'text' => 'text-[#3A6B56]',
            'bg' => 'bg-[#EAF2EE]',
            'label' => 'TERSEDIA',
            'dot' => 'bg-[#3A6B56]',
        ],
        'DIPINJAM' => [
            'border' => 'border-[#D95D39]',
            'text' => 'text-[#D95D39]',
            'bg' => 'bg-[#FDF0EC]',
            'label' => 'DIPINJAM',
            'dot' => 'bg-[#D95D39]',
        ],
        'ANTRIAN' => [
            'border' => 'border-[#E09F3E]',
            'text' => 'text-[#BF8228]',
            'bg' => 'bg-[#FDF5E8]',
            'label' => 'ANTRIAN (2)',
            'dot' => 'bg-[#E09F3E]',
        ],
        'VERIFIKASI' => [
            'border' => 'border-[#2C241E]',
            'text' => 'text-[#2C241E]',
            'bg' => 'bg-[#EFE7D8]',
            'label' => 'KOMPONEN LENGKAP',
            'dot' => 'bg-[#3A6B56]',
        ],
    ];

    $current = $statusMap[strtoupper($status)] ?? $statusMap['TERSEDIA'];
    $pad = $size === 'sm' ? 'px-1.5 py-0.5 text-[10px]' : 'px-2 py-1 text-xs';
@endphp

<div class="inline-flex items-center gap-1.5 font-mono font-bold uppercase tracking-widest border-2 border-dashed {{ $current['border'] }} {{ $current['text'] }} {{ $current['bg'] }} {{ $pad }} {{ $rotate }} select-none shadow-[1px_1px_0px_#2C241E] transition-transform duration-150 hover:rotate-0">
    <span class="w-1.5 h-1.5 rounded-full {{ $current['dot'] }}"></span>
    <span>{{ $current['label'] }}</span>
</div>

