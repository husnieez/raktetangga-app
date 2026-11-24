{{-- resources/views/components/rulebook-modal.blade.php --}}
<div 
    x-data="{
        isOpen: false,
        step: 1,
        otpRevealed: false,
        dontShowAgain: false,

        init() {
            // Check if user previously checked 'Jangan tampilkan lagi'
            const dismissed = localStorage.getItem('rak_rulebook_dismissed');
            if (dismissed === 'true') {
                this.dontShowAgain = true;
            }
        },
        open() {
            this.step = 1;
            this.otpRevealed = false;
            this.isOpen = true;
        },
        close() {
            if (this.dontShowAgain) {
                localStorage.setItem('rak_rulebook_dismissed', 'true');
            } else {
                localStorage.removeItem('rak_rulebook_dismissed');
            }
            this.isOpen = false;
        },
        goToStep(s) {
            this.step = s;
        },
        nextStep() {
            if (this.step < 4) {
                this.step++;
            } else {
                this.close();
            }
        },
        prevStep() {
            if (this.step > 1) {
                this.step--;
            }
        },
        revealOtp() {
            this.otpRevealed = true;
        }
    }"
    @open-rulebook.window="open()"
    @keydown.escape.window="close()"
    x-cloak
>
    <!-- Modal Backdrop -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-[#2C241E]/70 flex items-center justify-center p-3 sm:p-4 overflow-y-auto"
        @click.self="close()"
    >
        <!-- Tabletop Game Rulebook Card Container (Clean Breathing Room, single 1.5px espresso border, shadow-[4px_4px_0px_#2C241E]) -->
        <div 
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-3 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-3 scale-95"
            class="relative w-full max-w-lg bg-[#FFFDF9] border-[1.5px] border-[#2C241E] shadow-[4px_4px_0px_#2C241E] my-6 select-none overflow-hidden"
        >
            <!-- Top Rulebook Header Bar -->
            <div class="bg-[#EFE7D8] border-b-[1.5px] border-[#2C241E] px-5 py-3.5 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 bg-[#D95D39] text-[#FFFDF9] border border-[#2C241E] flex items-center justify-center font-mono font-bold text-xs shadow-[1.5px_1.5px_0px_#2C241E]">
                        📖
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-serif font-black text-base text-[#2C241E] leading-tight">
                                Buku Panduan Warga
                            </h3>
                            <span class="text-[10px] font-mono uppercase bg-[#3A6B56]/15 text-[#3A6B56] px-1.5 py-0.2 border border-[#3A6B56] font-bold">
                                ATURAN MEJA
                            </span>
                        </div>
                        <p class="text-[11px] text-[#6E6259] font-sans -mt-0.5">
                            4 Langkah Mudah Meminjam Buku & Game Tetangga
                        </p>
                    </div>
                </div>

                <button 
                    type="button" 
                    @click="close()" 
                    class="w-7 h-7 border-[1.5px] border-[#2C241E] bg-[#FFFDF9] text-[#2C241E] font-mono font-bold flex items-center justify-center shadow-[2px_2px_0px_#2C241E] hover:bg-[#D95D39] hover:text-[#FFFDF9] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all cursor-pointer"
                    title="Tutup Panduan"
                >
                    ✕
                </button>
            </div>

            <!-- Board Game Track Progress Bar (4 Connected Numbered Tokens) -->
            <div class="px-6 pt-5 pb-2">
                <div class="relative py-2">
                    <!-- Track Line Connecting Tokens -->
                    <div class="absolute top-1/2 left-4 right-4 h-[2px] -translate-y-1/2 bg-[#D8CFC0]">
                        <!-- Active Progress Fill -->
                        <div 
                            class="h-full bg-[#3A6B56] transition-all duration-300"
                            :style="'width: ' + ((step - 1) / 3 * 100) + '%'"
                        ></div>
                    </div>

                    <!-- 4 Clickable Board Game Tokens -->
                    <div class="relative flex items-center justify-between">
                        <template x-for="s in [1, 2, 3, 4]" :key="s">
                            <button 
                                type="button"
                                @click="goToStep(s)"
                                class="w-8 h-8 rounded-full border-[1.5px] border-[#2C241E] flex items-center justify-center font-mono text-xs font-bold transition-all cursor-pointer"
                                :class="{
                                    'bg-[#3A6B56] text-[#FFFDF9] shadow-[1.5px_1.5px_0px_#2C241E]': step > s,
                                    'bg-[#D95D39] text-[#FFFDF9] scale-110 -rotate-3 shadow-[2.5px_2.5px_0px_#2C241E]': step === s,
                                    'bg-[#FFFDF9] text-[#6E6259] shadow-[1px_1px_0px_#2C241E] hover:bg-[#F6F1E7]': step < s
                                }"
                                :title="'Lompat ke Langkah ' + s"
                            >
                                <span x-show="step > s">✓</span>
                                <span x-show="step <= s" x-text="s"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Step Counter Tagline -->
                <div class="flex items-center justify-between text-[11px] font-mono text-[#6E6259] mt-1">
                    <span>Langkah <strong class="text-[#2C241E]" x-text="step"></strong> dari 4</span>
                    <span class="text-[#D95D39] font-bold" x-text="['Pilih Koleksi', 'Dana di Escrow', 'Tukar Kode OTP', 'Main & Kembalikan'][step - 1]"></span>
                </div>
            </div>

            <!-- Card Deck Content Container (Smooth x-transition Slides) -->
            <div class="px-6 py-4 min-h-[260px] flex flex-col justify-center">

                <!-- STEP 1: Pilih & Pesan Koleksi -->
                <div 
                    x-show="step === 1"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4"
                    class="space-y-3"
                >
                    <div class="flex items-start gap-3">
                        <span class="text-3xl p-2 bg-[#F6F1E7] border border-[#2C241E] shadow-[2px_2px_0px_#2C241E]">
                            📚
                        </span>
                        <div>
                            <h4 class="font-serif font-bold text-lg text-[#2C241E]">
                                1. Pilih & Pesan Koleksi Tetangga
                            </h4>
                            <p class="font-sans text-xs text-[#6E6259] mt-1 leading-relaxed">
                                Jelajahi ratusan buku sastra, komik nostalgia, atau kotak board game milik tetangga di sekitar RT/RW-mu. Cek kelengkapan komponen dan tentukan tanggal peminjaman santai.
                            </p>
                        </div>
                    </div>

                    <!-- Clean Analog Highlight Box (No nested clutter) -->
                    <div class="bg-[#F6F1E7] p-3 text-xs font-mono text-[#2C241E] border-l-4 border-l-[#3A6B56] space-y-1">
                        <div class="flex items-center justify-between text-[11px] text-[#6E6259]">
                            <span>Contoh Katalog:</span>
                            <span class="stamp-badge border-[#3A6B56] text-[#3A6B56] text-[9px] -rotate-1">TERSEDIA</span>
                        </div>
                        <div class="font-bold text-sm">BG-014 • Catan: Edisi Bahasa</div>
                        <div class="text-[11px] text-[#6E6259]">
                            Tarif Sewa: <strong>Rp 15.000/hari</strong> • Jaminan: <strong>Rp 50.000</strong>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Dana Aman di Escrow -->
                <div 
                    x-show="step === 2"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4"
                    class="space-y-3"
                >
                    <div class="flex items-start gap-3">
                        <span class="text-3xl p-2 bg-[#F6F1E7] border border-[#2C241E] shadow-[2px_2px_0px_#2C241E]">
                            🛡️
                        </span>
                        <div>
                            <h4 class="font-serif font-bold text-lg text-[#2C241E]">
                                2. Dana Aman di Titipan Bersama (Escrow)
                            </h4>
                            <p class="font-sans text-xs text-[#6E6259] mt-1 leading-relaxed">
                                Biaya sewa dan uang jaminan disimpan aman di kas sistem gotong-royong. Pemilik buku/game tidak dapat menarik uang jaminan secara sepihak.
                            </p>
                        </div>
                    </div>

                    <!-- Clean Analog Highlight Box -->
                    <div class="bg-[#F6F1E7] p-3 text-xs font-mono text-[#2C241E] border-l-4 border-l-[#E09F3E] space-y-1.5">
                        <div class="flex items-center justify-between font-bold text-[11px]">
                            <span>STATUS DANA JAMINAN:</span>
                            <span class="text-[#3A6B56]">TERLINDUNGI 100%</span>
                        </div>
                        <p class="font-sans text-[11px] text-[#6E6259] leading-tight">
                            "Uang jaminan otomatis cair kembali seketika saat barang kamu kembalikan dalam kondisi utuh dan diverifikasi bersama."
                        </p>
                    </div>
                </div>

                <!-- STEP 3: Ketemuan & Tukar Kode OTP (With Playful Mini-Simulation) -->
                <div 
                    x-show="step === 3"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4"
                    class="space-y-3"
                >
                    <div class="flex items-start gap-3">
                        <span class="text-3xl p-2 bg-[#F6F1E7] border border-[#2C241E] shadow-[2px_2px_0px_#2C241E]">
                            🤝
                        </span>
                        <div>
                            <h4 class="font-serif font-bold text-lg text-[#2C241E]">
                                3. Ketemuan & Tukar Kode OTP
                            </h4>
                            <p class="font-sans text-xs text-[#6E6259] mt-1 leading-relaxed">
                                Janjian serah terima di titik kumpul (Pos Satpam Blok C, Warung Bu RT, atau teras rumah). Cocokkan 6-digit kode OTP untuk membuka segel peminjaman.
                            </p>
                        </div>
                    </div>

                    <!-- Playful Micro-Interaction Simulation Box -->
                    <div class="bg-[#F6F1E7] p-3 text-xs font-mono text-[#2C241E] border-l-4 border-l-[#D95D39]">
                        <div class="text-[11px] text-[#6E6259] mb-1.5 font-bold uppercase">
                            Simulasi Serah Terima Interaktif:
                        </div>

                        <!-- Before Click Dummy Button -->
                        <div x-show="!otpRevealed" class="flex items-center gap-2">
                            <button 
                                type="button"
                                @click="revealOtp()"
                                class="px-3 py-1.5 bg-[#FFFDF9] border border-[#2C241E] font-mono text-xs font-bold text-[#D95D39] shadow-[2px_2px_0px_#2C241E] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all cursor-pointer flex items-center gap-1.5"
                            >
                                <span>🔑</span>
                                <span>Coba Klik Kode Serah Terima</span>
                            </button>
                            <span class="text-[10px] text-[#6E6259] italic">Klik untuk tes rasa!</span>
                        </div>

                        <!-- Stamped OTP Revealed with Tactile Stamp Animation -->
                        <div 
                            x-show="otpRevealed"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-75 -rotate-12"
                            x-transition:enter-end="opacity-100 scale-100 -rotate-2"
                            class="flex items-center justify-between flex-wrap gap-2 pt-1"
                        >
                            <div class="inline-flex items-center gap-2 border-2 border-dashed border-[#D95D39] bg-[#FFFDF9] px-3 py-1 text-[#D95D39] shadow-[1.5px_1.5px_0px_#D95D39]">
                                <span class="text-xs">🏷️ OTP:</span>
                                <strong class="text-base tracking-widest font-black">482 - 910</strong>
                            </div>
                            <span class="text-[10px] text-[#3A6B56] font-bold">
                                ✓ Kode Terverifikasi! Segel Terbuka.
                            </span>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Mainkan, Kembalikan, & Titip Koleksimu -->
                <div 
                    x-show="step === 4"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4"
                    class="space-y-3"
                >
                    <div class="flex items-start gap-3">
                        <span class="text-3xl p-2 bg-[#F6F1E7] border border-[#2C241E] shadow-[2px_2px_0px_#2C241E]">
                            🎲
                        </span>
                        <div>
                            <h4 class="font-serif font-bold text-lg text-[#2C241E]">
                                4. Mainkan, Kembalikan, & Titip Koleksimu
                            </h4>
                            <p class="font-sans text-xs text-[#6E6259] mt-1 leading-relaxed">
                                Nikmati waktu membaca & bermain. Kembalikan tepat waktu agar uang jaminanmu kembali utuh. Punya buku/game nganggur di rumah? Daftarkan ke rak tetangga untuk dapat uang saku santai!
                            </p>
                        </div>
                    </div>

                    <!-- Clean Community Perks Pill -->
                    <div class="bg-[#F6F1E7] p-3 text-xs font-mono text-[#2C241E] border-l-4 border-l-[#3A6B56] grid grid-cols-2 gap-2">
                        <div class="flex items-center gap-1.5">
                            <span class="text-[#3A6B56] font-bold">✓</span>
                            <span>Jaminan 100% Kembali</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[#3A6B56] font-bold">✓</span>
                            <span>Koleksi Warga Terjaga</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[#3A6B56] font-bold">✓</span>
                            <span>Bebas Denda Kaku</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[#D95D39] font-bold">+</span>
                            <span>Bisa Titip Koleksi Sendiri</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Clean Footer Navigation Bar -->
            <div class="bg-[#EFE7D8] border-t-[1.5px] border-[#2C241E] px-5 py-3.5 flex items-center justify-between gap-3">
                
                <!-- 'Jangan tampilkan lagi' Checkbox (Stored in localStorage) -->
                <label class="flex items-center gap-2 cursor-pointer select-none text-[11px] text-[#6E6259] font-mono">
                    <input 
                        type="checkbox" 
                        x-model="dontShowAgain" 
                        class="accent-[#D95D39] w-3.5 h-3.5"
                    >
                    <span>Jangan tampilkan lagi</span>
                </label>

                <!-- Step Navigation Buttons -->
                <div class="flex items-center gap-2">
                    <!-- Button Sebelumnya -->
                    <button 
                        type="button" 
                        @click="prevStep()"
                        :disabled="step === 1"
                        class="px-3 py-1.5 text-xs font-mono font-medium text-[#6E6259] hover:text-[#2C241E] disabled:opacity-40 disabled:cursor-not-allowed transition-colors cursor-pointer"
                    >
                        Sebelumnya
                    </button>

                    <!-- Button Lanjut / Selesai -->
                    <button 
                        type="button" 
                        @click="nextStep()"
                        class="px-4 py-2 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-xs border-[1.5px] border-[#2C241E] shadow-[3px_3px_0px_#2C241E] hover:bg-[#C24D2B] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all flex items-center gap-1.5 cursor-pointer"
                    >
                        <span x-text="step === 4 ? 'Siap Jelajahi Rak! 🎲' : 'Lanjut →'"></span>
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

