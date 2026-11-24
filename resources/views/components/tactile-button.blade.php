@props([
    'variant' => 'terracotta', // terracotta, cardstock, sage, ochre
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'disabled' => false,
])

@php
    $baseStyles = "inline-flex items-center justify-center font-sans font-bold border-[1.5px] border-[#2C241E] transition-all duration-100 select-none cursor-pointer";
    
    $variants = [
        'terracotta' => "bg-[#D95D39] text-[#FFFDF9] hover:bg-[#C24D2B] shadow-[3px_3px_0px_#2C241E] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none",
        'cardstock' => "bg-[#FFFDF9] text-[#2C241E] hover:bg-[#F6F1E7] shadow-[3px_3px_0px_#2C241E] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none",
        'sage' => "bg-[#3A6B56] text-[#FFFDF9] hover:bg-[#2E5544] shadow-[3px_3px_0px_#2C241E] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none",
        'ochre' => "bg-[#E09F3E] text-[#2C241E] hover:bg-[#D48F2A] shadow-[3px_3px_0px_#2C241E] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none",
    ];

    $sizes = [
        'sm' => "px-2.5 py-1.5 text-xs gap-1",
        'md' => "px-4 py-2 text-sm gap-2",
        'lg' => "px-5 py-3 text-base gap-2.5",
    ];

    $disabledStyles = "opacity-50 cursor-not-allowed bg-[#EFE7D8] text-[#6E6259] shadow-[2px_2px_0px_#6E6259] hover:translate-x-0 hover:translate-y-0 hover:shadow-[2px_2px_0px_#6E6259]";
@endphp

<button 
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => "$baseStyles " . ($disabled ? $disabledStyles : $variants[$variant]) . " " . $sizes[$size]]) }}
>
    {{ $slot }}
</button>

