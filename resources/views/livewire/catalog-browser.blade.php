<div 
    x-data="{
        category: @entangle('category').live,
        search: @entangle('search').live,
        maxDistance: @entangle('maxDistance').live,
        statusFilter: @entangle('statusFilter').live,

        // Mystery Pick / Kocok Dadu State
        isRolling: false,
        diceFace: '🎲',
        mysteryResult: null,
        showMysteryModal: false,
        diceFaces: ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅'],

        rollDice(availableItems) {
            this.isRolling = true;
            this.showMysteryModal = true;
            this.mysteryResult = null;

            let counter = 0;
            let interval = setInterval(() => {
                this.diceFace = this.diceFaces[Math.floor(Math.random() * this.diceFaces.length)];
                counter++;
                if (counter > 12) {
                    clearInterval(interval);
                    this.isRolling = false;
                    // Pick random item from available list
                    const pool = availableItems.filter(i => i.status === 'TERSEDIA');
                    const target = pool.length > 0 ? pool : availableItems;
                    this.mysteryResult = target[Math.floor(Math.random() * target.length)];
                }
            }, 90);
        }
    }"
    class="max-w-7xl mx-auto px-4 sm:px-6 py-8"
>
    <!-- Cozy Community Welcome Hero & Notice Board -->
    <div class="mb-10 bg-[#FFFDF9] border-2 border-[#2C241E] p-6 sm:p-8 shadow-[6px_6px_0px_#2C241E] relative overflow-hidden">
        
        <!-- Pinned Paper Corner Tape / Tack Decor -->
        <div class="absolute -top-3 left-10 w-16 h-7 bg-[#E09F3E]/40 border border-[#2C241E] -rotate-3 z-10 shadow-[1px_1px_0px_#2C241E]"></div>
        <div class="absolute -top-3 right-10 w-16 h-7 bg-[#3A6B56]/30 border border-[#2C241E] rotate-6 z-10 shadow-[1px_1px_0px_#2C241E]"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Hero Text -->
            <div class="lg:col-span-8">
                <div class="inline-flex items-center gap-2 mb-3 bg-[#EAF2EE] border border-[#3A6B56] px-2.5 py-1 text-xs font-mono text-[#2E5544] font-bold">
                    <span>☕</span>
                    <span>SUASANA TERAS SORE • RUKUN WARGA 07</span>
                </div>

                <h1 class="font-serif font-black text-3xl sm:text-4xl text-[#2C241E] tracking-tight leading-tight">
                    Pinjam Buku & Board Game dari Tetangga Sebelah Rumah.
                </h1>

                <p class="font-sans text-sm sm:text-base text-[#6E6259] mt-3 leading-relaxed max-w-2xl">
                    Daripada tersimpan rapi berdebu di lemari, mari saling pinjamkan novel kesayangan, komik kenangan masa kecil, dan kotak board game akhir pekan. Rawat seperti milik sendiri, jalin silaturahmi tanpa sekat.
                </p>

                <!-- Hero Micro Metrics / Community Stats -->
                <div class="mt-6 flex flex-wrap items-center gap-3 text-xs font-mono">
                    <div class="bg-[#F6F1E7] border border-[#2C241E] px-3 py-1.5 shadow-[2px_2px_0px_#2C241E] flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#3A6B56]"></span>
                        <span><strong>28</strong> Koleksi Tersedia</span>
                    </div>
                    <div class="bg-[#F6F1E7] border border-[#2C241E] px-3 py-1.5 shadow-[2px_2px_0px_#2C241E] flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#D95D39]"></span>
                        <span><strong>14</strong> Sedang Dipinjam</span>
                    </div>
                    <div class="bg-[#F6F1E7] border border-[#2C241E] px-3 py-1.5 shadow-[2px_2px_0px_#2C241E] flex items-center gap-2">
                        <span>🛡️</span>
                        <span><strong>100%</strong> Jaminan Aman</span>
                    </div>
                </div>
            </div>

            <!-- Right Hero Card: Mystery Pick / Kocok Dadu Feature Trigger -->
            <div class="lg:col-span-4 bg-[#F6F1E7] border-2 border-[#2C241E] p-5 shadow-[4px_4px_0px_#2C241E] relative">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-mono text-[10px] font-bold uppercase tracking-wider text-[#D95D39] bg-[#FDF0EC] px-1.5 py-0.5 border border-[#D95D39]">
                        FITUR SERU WARGA
                    </span>
                    <span class="text-xl">🎲</span>
                </div>

                <h3 class="font-serif font-bold text-lg text-[#2C241E] leading-snug">
                    Bingung Mau Main atau Baca Apa?
                </h3>
                <p class="text-xs text-[#6E6259] font-sans mt-1 mb-4 leading-normal">
                    Biarkan kocokan dadu analog menentukan petualangan mejamu sore ini!
                </p>

                <!-- Mystery Dice Button with Tactile Press Mechanics -->
                <button 
                    type="button"
                    @click="rollDice({{ json_encode($items) }})"
                    class="w-full py-3 px-4 bg-[#E09F3E] text-[#2C241E] font-serif font-black text-sm border-2 border-[#2C241E] shadow-[3px_3px_0px_#2C241E] hover:bg-[#D48F2A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4.5px_4.5px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all flex items-center justify-center gap-2.5"
                >
                    <span class="text-xl">🎲</span>
                    <span>Kocok Rekomendasi Dadu!</span>
                </button>
            </div>

        </div>
    </div>

    <!-- Filter & Shelf Navigation Bar -->
    <div class="mb-8 bg-[#FFFDF9] border-2 border-[#2C241E] p-4 shadow-[4px_4px_0px_#2C241E]">
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
            
            <!-- Left: Animated Category Dropdown + Quick Pills (No scrollbar cutoff!) -->
            <div class="flex items-center gap-2 flex-wrap">
                
                <!-- Animated Category Dropdown -->
                <div class="relative" x-data="{ catDropdownOpen: false }" @click.outside="catDropdownOpen = false" @keydown.escape.window="catDropdownOpen = false">
                    <button 
                        type="button" 
                        @click="catDropdownOpen = !catDropdownOpen"
                        class="flex items-center justify-between gap-3 bg-[#FFFDF9] border-[1.5px] border-[#2C241E] px-3.5 py-2 text-xs font-mono font-bold text-[#2C241E] shadow-[3px_3px_0px_#2C241E] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all cursor-pointer min-w-[210px] sm:min-w-[240px]"
                        :class="catDropdownOpen ? 'bg-[#F6F1E7]' : ''"
                    >
                        <div class="flex items-center gap-2">
                            <span class="text-base" x-text="category === 'all' ? '📚🎲' : (category === 'boardgame' ? '🎲' : (category === 'book' ? '📚' : '💭'))"></span>
                            <div class="text-left">
                                <span class="block text-[9px] uppercase tracking-wider text-[#6E6259]">Kategori Rak:</span>
                                <span class="text-xs font-serif font-black text-[#2C241E]" x-text="category === 'all' ? 'Semua Koleksi ({{ count($items) }})' : (category === 'boardgame' ? 'Board Game & Mainan' : (category === 'book' ? 'Buku & Sastra' : 'Komik Nostalgia'))"></span>
                            </div>
                        </div>
                        <span class="text-xs text-[#D95D39] font-black transition-transform duration-200" :class="catDropdownOpen ? 'rotate-180' : 'rotate-0'">▼</span>
                    </button>

                    <!-- Animated Foldout Menu -->
                    <div 
                        x-show="catDropdownOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-120"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                        class="absolute left-0 top-full mt-2 w-72 sm:w-80 bg-[#FFFDF9] border-2 border-[#2C241E] shadow-[6px_6px_0px_#2C241E] z-30 select-none overflow-hidden"
                        x-cloak
                    >
                        <div class="bg-[#EFE7D8] border-b-[1.5px] border-[#2C241E] px-3.5 py-2 flex items-center justify-between text-[10px] font-mono font-bold text-[#6E6259] uppercase tracking-wider">
                            <span>📂 PILIH RAK KOLEKSI</span>
                            <span class="text-[#3A6B56]">{{ count($items) }} Koleksi Tersedia</span>
                        </div>

                        <div class="p-1.5 space-y-1">
                            <button 
                                type="button"
                                wire:click="$set('category', 'all'); catDropdownOpen = false"
                                @click="catDropdownOpen = false"
                                class="w-full p-2.5 flex items-center justify-between border-[1.5px] transition-all text-left cursor-pointer"
                                :class="category === 'all' ? 'bg-[#2C241E] text-[#FFFDF9] border-[#2C241E] shadow-[1px_1px_0px_#D95D39]' : 'bg-[#FFFDF9] text-[#2C241E] border-transparent hover:bg-[#F6F1E7] hover:border-[#2C241E]'"
                            >
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xl">📚🎲</span>
                                    <div>
                                        <div class="font-serif font-bold text-xs" :class="category === 'all' ? 'text-[#FFFDF9]' : 'text-[#2C241E]'">Semua Koleksi</div>
                                        <div class="text-[10px] font-mono" :class="category === 'all' ? 'text-[#D8CFC0]' : 'text-[#6E6259]'">Seluruh buku, komik & board game</div>
                                    </div>
                                </div>
                                <span class="text-xs font-mono font-bold px-1.5 py-0.5 border" :class="category === 'all' ? 'bg-[#3A6B56] text-[#FFFDF9] border-[#3A6B56]' : 'bg-[#EFE7D8] text-[#2C241E] border-[#2C241E]'">{{ count($items) }}</span>
                            </button>

                            <button 
                                type="button"
                                wire:click="$set('category', 'boardgame'); catDropdownOpen = false"
                                @click="catDropdownOpen = false"
                                class="w-full p-2.5 flex items-center justify-between border-[1.5px] transition-all text-left cursor-pointer"
                                :class="category === 'boardgame' ? 'bg-[#D95D39] text-[#FFFDF9] border-[#2C241E] shadow-[2px_2px_0px_#2C241E]' : 'bg-[#FFFDF9] text-[#2C241E] border-transparent hover:bg-[#FDF0EC] hover:border-[#D95D39]'"
                            >
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xl">🎲</span>
                                    <div>
                                        <div class="font-serif font-bold text-xs" :class="category === 'boardgame' ? 'text-[#FFFDF9]' : 'text-[#2C241E]'">Board Game & Mainan Meja</div>
                                        <div class="text-[10px] font-mono" :class="category === 'boardgame' ? 'text-[#FFFDF9]/90' : 'text-[#6E6259]'">Catan, Cascadia, Splendor, Party Games</div>
                                    </div>
                                </div>
                                <span class="text-xs font-mono font-bold px-1.5 py-0.5 border" :class="category === 'boardgame' ? 'bg-[#FFFDF9] text-[#D95D39] border-[#2C241E]' : 'bg-[#EAF2EE] text-[#3A6B56] border-[#3A6B56]'">4</span>
                            </button>

                            <button 
                                type="button"
                                wire:click="$set('category', 'book'); catDropdownOpen = false"
                                @click="catDropdownOpen = false"
                                class="w-full p-2.5 flex items-center justify-between border-[1.5px] transition-all text-left cursor-pointer"
                                :class="category === 'book' ? 'bg-[#3A6B56] text-[#FFFDF9] border-[#2C241E] shadow-[2px_2px_0px_#2C241E]' : 'bg-[#FFFDF9] text-[#2C241E] border-transparent hover:bg-[#EAF2EE] hover:border-[#3A6B56]'"
                            >
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xl">📚</span>
                                    <div>
                                        <div class="font-serif font-bold text-xs" :class="category === 'book' ? 'text-[#FFFDF9]' : 'text-[#2C241E]'">Buku & Sastra</div>
                                        <div class="text-[10px] font-mono" :class="category === 'book' ? 'text-[#FFFDF9]/90' : 'text-[#6E6259]'">Novel fiksi, sastra Indonesia, roman</div>
                                    </div>
                                </div>
                                <span class="text-xs font-mono font-bold px-1.5 py-0.5 border" :class="category === 'book' ? 'bg-[#FFFDF9] text-[#3A6B56] border-[#2C241E]' : 'bg-[#EFE7D8] text-[#2C241E] border-[#2C241E]'">3</span>
                            </button>

                            <button 
                                type="button"
                                wire:click="$set('category', 'comic'); catDropdownOpen = false"
                                @click="catDropdownOpen = false"
                                class="w-full p-2.5 flex items-center justify-between border-[1.5px] transition-all text-left cursor-pointer"
                                :class="category === 'comic' ? 'bg-[#E09F3E] text-[#2C241E] border-[#2C241E] shadow-[2px_2px_0px_#2C241E]' : 'bg-[#FFFDF9] text-[#2C241E] border-transparent hover:bg-[#FDF5E8] hover:border-[#E09F3E]'"
                            >
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xl">💭</span>
                                    <div>
                                        <div class="font-serif font-bold text-xs text-[#2C241E]">Komik Nostalgia</div>
                                        <div class="text-[10px] font-mono text-[#6E6259]">Tintin, komik cetakan klasik hardcover</div>
                                    </div>
                                </div>
                                <span class="text-xs font-mono font-bold px-1.5 py-0.5 border bg-[#FFFDF9] text-[#2C241E] border-[#2C241E]">1</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Filter Pills -->
                <div class="hidden sm:flex items-center gap-1.5 text-xs font-mono">
                    <button x-show="category !== 'all'" wire:click="$set('category', 'all')" type="button" class="text-[10px] text-[#6E6259] hover:text-[#D95D39] underline font-bold cursor-pointer ml-1">
                        ✕ Reset
                    </button>
                </div>

            </div>

            <!-- Search Card Index & Radius Range -->
            <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap">
                <!-- Search Input Styled as Library Card Drawer -->
                <div class="relative w-full sm:w-72">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari judul, bidak, tetangga..."
                        class="w-full bg-[#F6F1E7] border-[1.5px] border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] placeholder-[#6E6259] focus:outline-none focus:ring-1 focus:ring-[#2C241E] shadow-[inset_1px_1px_2px_rgba(44,36,30,0.1)]"
                    >
                    <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-xs text-[#6E6259]">🔍</span>
                </div>

                <!-- Distance Filter Pill -->
                <div class="flex items-center gap-2 text-xs font-mono bg-[#EFE7D8] border border-[#2C241E] px-2.5 py-1.5 whitespace-nowrap">
                    <span class="text-[#6E6259]">Radius:</span>
                    <select wire:model.live="maxDistance" class="bg-transparent font-bold text-[#2C241E] focus:outline-none cursor-pointer">
                        <option value="500">&lt; 500m (Dekat Sekali)</option>
                        <option value="1000">&lt; 1 km (Jalan Santai)</option>
                        <option value="2000">&lt; 2 km (Komplek Sekitar)</option>
                    </select>
                </div>

                <!-- Availability Quick Toggle -->
                <button 
                    type="button"
                    wire:click="$set('statusFilter', '{{ $statusFilter === 'available' ? 'all' : 'available' }}')"
                    class="px-2.5 py-2 text-xs font-mono font-bold border border-[#2C241E] transition-all whitespace-nowrap"
                    :class="statusFilter === 'available' ? 'bg-[#3A6B56] text-[#FFFDF9] shadow-[1.5px_1.5px_0px_#2C241E]' : 'bg-[#FFFDF9] text-[#2C241E]'"
                >
                    <span x-text="statusFilter === 'available' ? '✓ Hanya Tersedia' : 'Semua Status'"></span>
                </button>
            </div>

        </div>
    </div>

    <!-- Main Tabletop Shelf / Grid Layout -->
    <div class="relative">
        
        <!-- Empty State if no items found -->
        @if(empty($items))
            <div class="bg-[#FFFDF9] border-2 border-[#2C241E] p-12 text-center shadow-[4px_4px_0px_#2C241E] my-8">
                <div class="text-4xl mb-3">📭</div>
                <h3 class="font-serif font-bold text-xl text-[#2C241E]">Belum Ada Koleksi yang Cocok</h3>
                <p class="font-sans text-xs text-[#6E6259] max-w-md mx-auto mt-1 mb-4">
                    Coba perluas jarak jangkauan tetangga atau ubah kata kunci pencarian judul buku & game.
                </p>
                <button 
                    wire:click="$set('search', ''); $set('category', 'all'); $set('maxDistance', 2000)"
                    class="px-4 py-2 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-xs border border-[#2C241E] shadow-[2.5px_2.5px_0px_#2C241E]"
                >
                    Reset Filter Rak
                </button>
            </div>
        @else
            <!-- Responsive Grid: Books as tall upright covers, Board Games as sturdy rectangular tabletop boxes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($items as $item)
                    @if(($item['type'] ?? '') === 'boardgame')
                        <x-board-game-card :item="$item" />
                    @else
                        <x-book-card :item="$item" />
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Cozy Wooden Shelf Base Bar (Analog Visual Anchor) -->
        <div class="mt-10 border-t-4 border-[#2C241E] pt-3 flex items-center justify-between text-xs font-mono text-[#6E6259]">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-[#D95D39] inline-block border border-[#2C241E]"></span>
                <span>Rak Tingkat 1 • Koleksi Terawat Warga Bintaro Asri</span>
            </div>
            <div>
                Menampilkan {{ count($items) }} Koleksi
            </div>
        </div>

    </div>

    <!-- Mystery Pick / Kocok Dadu Modal Reveal (Alpine.js Animation) -->
    <div 
        x-show="showMysteryModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-[#2C241E]/75 flex items-center justify-center p-4"
        @click.self="showMysteryModal = false"
        x-cloak
    >
        <div 
            class="relative w-full max-w-md bg-[#FFFDF9] border-[2px] border-[#2C241E] shadow-[8px_8px_0px_#2C241E] p-6 text-center"
        >
            <!-- Close -->
            <button 
                type="button"
                @click="showMysteryModal = false"
                class="absolute top-3 right-3 w-7 h-7 border border-[#2C241E] bg-[#FFFDF9] font-mono text-xs font-bold hover:bg-[#D95D39] hover:text-[#FFFDF9]"
            >
                ✕
            </button>

            <!-- Rolling Animation State -->
            <div x-show="isRolling" class="py-8">
                <div class="text-6xl animate-bounce mb-3 select-none" x-text="diceFace"></div>
                <h3 class="font-serif font-black text-xl text-[#2C241E]">Mengocok Dadu Warga...</h3>
                <p class="font-mono text-xs text-[#6E6259] mt-1">Mencari buku atau board game seru yang siap dipinjam</p>
            </div>

            <!-- Revealed Item Result -->
            <div x-show="!isRolling && mysteryResult" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                <div class="inline-block bg-[#E09F3E] text-[#2C241E] border border-[#2C241E] px-3 py-1 font-mono text-xs font-bold shadow-[2px_2px_0px_#2C241E] -rotate-2 mb-3">
                    🎲 PILIHAN DADU SORE INI!
                </div>

                <div class="bg-[#F6F1E7] border-2 border-[#2C241E] p-4 my-3 text-left shadow-[3px_3px_0px_#2C241E]">
                    <div class="flex items-center justify-between text-xs font-mono text-[#6E6259] mb-1">
                        <span class="bg-[#2C241E] text-[#FFFDF9] px-1 py-0.5 font-bold" x-text="mysteryResult?.code"></span>
                        <span x-text="mysteryResult?.type === 'boardgame' ? 'BOARD GAME' : 'BUKU FISIK'"></span>
                    </div>

                    <h4 class="font-serif font-black text-xl text-[#2C241E]" x-text="mysteryResult?.title"></h4>
                    <p class="font-sans text-xs text-[#6E6259] mt-1" x-text="'Milik ' + mysteryResult?.owner + ' (' + mysteryResult?.location + ')'"></p>

                    <div class="mt-3 pt-2 border-t border-[#D8CFC0] flex items-center justify-between font-mono text-xs">
                        <span class="text-[#6E6259]">Tarif Sewa:</span>
                        <strong class="text-[#2C241E]" x-text="'Rp ' + Number(mysteryResult?.daily_rate || 0).toLocaleString('id-ID') + '/hari'"></strong>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-3 mt-4">
                    <button 
                        type="button"
                        @click="rollDice({{ json_encode($items) }})"
                        class="px-4 py-2 bg-[#FFFDF9] text-[#2C241E] font-mono text-xs font-bold border border-[#2C241E] shadow-[2px_2px_0px_#2C241E] hover:bg-[#F6F1E7]"
                    >
                        🔄 Kocok Ulang
                    </button>

                    <button 
                        type="button"
                        @click="showMysteryModal = false; $dispatch('open-checkout', mysteryResult)"
                        class="px-5 py-2 bg-[#D95D39] text-[#FFFDF9] font-sans text-xs font-bold border border-[#2C241E] shadow-[3px_3px_0px_#2C241E] hover:bg-[#C24D2B]"
                    >
                        Pinjam Rekomendasi Ini! →
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modals Container -->
    @include('livewire.checkout-modal')
    @include('livewire.component-checklist-modal')

</div>

