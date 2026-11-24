<div 
    x-data="{
        isOpen: false,
        item: {
            id: 'BG-014',
            code: 'BG-014',
            title: 'Catan: Edisi Bahasa',
            daily_rate: 15000,
            deposit: 50000,
            owner: 'Mas Dimas',
            location: 'Blok C-12 • 250m',
            pieces: '1 Papan, 2 Dadu, 96 Kartu, 16 Kota',
            type: 'boardgame',
            cover_bg: '#E09F3E'
        },
        days: 3,
        handoverLocation: 'pos_satpam',
        handoverNote: '',
        agreedToComponents: false,
        stampedSuccess: false,
        otpCode: '482-910',

        openModal(data) {
            if (data) this.item = data;
            this.days = 3;
            this.handoverNote = '';
            this.agreedToComponents = false;
            this.stampedSuccess = false;
            // Generate deterministic-looking random 6-digit OTP
            const p1 = Math.floor(100 + Math.random() * 900);
            const p2 = Math.floor(100 + Math.random() * 900);
            this.otpCode = `${p1}-${p2}`;
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
        },
        incrementDays() {
            if (this.days < 30) this.days++;
        },
        decrementDays() {
            if (this.days > 1) this.days--;
        },
        get rentalFee() {
            return (this.item.daily_rate || 0) * this.days;
        },
        get depositFee() {
            return (this.item.deposit || 0);
        },
        get totalEscrow() {
            return this.rentalFee + this.depositFee;
        },
        get dueDateFormatted() {
            const d = new Date();
            d.setDate(d.getDate() + parseInt(this.days));
            const daysName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const dayName = daysName[d.getDay()];
            const dateNum = String(d.getDate()).padStart(2, '0');
            const monthName = months[d.getMonth()];
            return `Kembali: ${dayName}, ${dateNum} ${monthName} • Maks 20.00 WIB`;
        },
        submitRental() {
            if (!this.agreedToComponents) return;
            this.stampedSuccess = true;
            if (window.Livewire) {
                Livewire.dispatch('rental-confirmed', {
                    itemId: this.item.id,
                    days: this.days,
                    dueDate: this.dueDateFormatted,
                    location: this.handoverLocation,
                    note: this.handoverNote,
                    otp: this.otpCode
                });
            }
        }
    }"
    @open-checkout.window="openModal($event.detail)"
    @keydown.escape.window="closeModal()"
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
        @click.self="closeModal()"
    >
        <!-- Vintage Library Due-Date Slip Modal (max-w-lg, single outer hard shadow) -->
        <div 
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="relative w-full max-w-lg bg-[#FFFDF9] border-[1.5px] border-[#2C241E] shadow-[4px_4px_0px_#2C241E] my-6 overflow-hidden"
        >
            <!-- Top Monospace Stamp Header -->
            <div class="bg-[#EFE7D8] border-b border-[#D8CFC0] px-5 py-2.5 flex items-center justify-between text-[11px] font-mono text-[#6E6259]">
                <span class="font-bold tracking-wider uppercase text-[#2C241E]">🏷️ KARTU PEMINJAMAN • DUE SLIP</span>
                <button 
                    type="button"
                    @click="closeModal()" 
                    class="w-6 h-6 border border-[#2C241E] bg-[#FFFDF9] text-[#2C241E] font-mono font-bold flex items-center justify-center hover:bg-[#D95D39] hover:text-[#FFFDF9] transition-colors cursor-pointer"
                    title="Tutup"
                >
                    ✕
                </button>
            </div>

            <!-- Modal Body (Clean Ivory Cardstock with Ruled Dividers) -->
            <div class="p-5 sm:p-6 space-y-5">

                <!-- Item Header: Thumbnail Preview + Fraunces Title + Unit Code + Owner Badge -->
                <div class="flex items-start gap-3.5 pb-4 border-b border-[#D8CFC0]">
                    <!-- Mini Cover Thumbnail -->
                    <div 
                        class="w-14 h-16 shrink-0 border-[1.5px] border-[#2C241E] flex items-center justify-center text-2xl shadow-[2px_2px_0px_#2C241E]"
                        :style="'background-color: ' + (item.cover_bg || item.cover_tone || '#EFE7D8')"
                    >
                        <span x-text="item.type === 'boardgame' ? '🎲' : (item.type === 'comic' ? '💭' : '📖')"></span>
                    </div>

                    <div class="flex-grow min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-mono text-[10px] font-bold bg-[#2C241E] text-[#FFFDF9] px-1.5 py-0.5" x-text="item.code || 'BG-014'"></span>
                            <span class="font-mono text-[11px] text-[#6E6259] truncate" x-text="(item.owner || 'Mas Dimas') + ' • ' + (item.location ? item.location.split('•')[0].trim() : 'Blok C-12')"></span>
                        </div>
                        <h2 class="font-serif font-black text-xl text-[#2C241E] leading-tight truncate" x-text="item.title"></h2>
                        <p class="font-mono text-xs text-[#6E6259] mt-0.5">
                            Rp <span class="font-bold text-[#2C241E]" x-text="Number(item.daily_rate || 0).toLocaleString('id-ID')"></span>/hari
                        </p>
                    </div>
                </div>

                <!-- Interactive Day Stepper & Live Due-Date Stamp -->
                <div class="pb-4 border-b border-[#D8CFC0] space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <label class="block font-serif font-bold text-sm text-[#2C241E]">Durasi Pinjam</label>
                            <div class="flex items-center gap-1.5 mt-1.5 text-[11px] font-mono">
                                <button type="button" @click="days = 3" :class="days === 3 ? 'bg-[#2C241E] text-[#FFFDF9]' : 'bg-[#F6F1E7] text-[#2C241E] hover:bg-[#EFE7D8]'" class="px-2 py-0.5 border border-[#2C241E] transition-colors cursor-pointer">3 Hari</button>
                                <button type="button" @click="days = 7" :class="days === 7 ? 'bg-[#2C241E] text-[#FFFDF9]' : 'bg-[#F6F1E7] text-[#2C241E] hover:bg-[#EFE7D8]'" class="px-2 py-0.5 border border-[#2C241E] transition-colors cursor-pointer">7 Hari</button>
                                <button type="button" @click="days = 14" :class="days === 14 ? 'bg-[#2C241E] text-[#FFFDF9]' : 'bg-[#F6F1E7] text-[#2C241E] hover:bg-[#EFE7D8]'" class="px-2 py-0.5 border border-[#2C241E] transition-colors cursor-pointer">14 Hari</button>
                            </div>
                        </div>

                        <!-- Tactile - / + Stepper -->
                        <div class="flex items-center gap-1.5">
                            <button 
                                type="button"
                                @click="decrementDays()"
                                :disabled="days <= 1"
                                class="w-8 h-8 border border-[#2C241E] bg-[#FFFDF9] font-mono font-bold text-base flex items-center justify-center shadow-[2px_2px_0px_#2C241E] hover:bg-[#F6F1E7] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none disabled:opacity-40 cursor-pointer transition-all"
                            >−</button>
                            <div class="w-14 h-8 border border-[#2C241E] bg-[#F6F1E7] flex items-center justify-center font-mono font-bold text-sm text-[#2C241E]">
                                <span x-text="days"></span><span class="text-[10px] ml-0.5 text-[#6E6259]">hr</span>
                            </div>
                            <button 
                                type="button"
                                @click="incrementDays()"
                                :disabled="days >= 30"
                                class="w-8 h-8 border border-[#2C241E] bg-[#FFFDF9] font-mono font-bold text-base flex items-center justify-center shadow-[2px_2px_0px_#2C241E] hover:bg-[#F6F1E7] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none disabled:opacity-40 cursor-pointer transition-all"
                            >+</button>
                        </div>
                    </div>

                    <!-- Tilted Live Due-Date Stamp Box -->
                    <div class="pt-1 flex justify-end">
                        <div class="inline-block border-2 border-dashed border-[#D95D39] bg-[#FDF0EC]/70 text-[#D95D39] px-3 py-1 font-mono font-bold text-xs -rotate-1 tracking-tight">
                            📅 <span x-text="dueDateFormatted"></span>
                        </div>
                    </div>
                </div>

                <!-- Live Cost Breakdown (Ruled Ledger Lines) -->
                <div class="pb-4 border-b border-[#D8CFC0] font-mono text-xs space-y-2">
                    <div class="flex items-center justify-between text-[#6E6259]">
                        <span>Tarif Sewa (<span x-text="days"></span> hari × Rp <span x-text="Number(item.daily_rate || 0).toLocaleString('id-ID')"></span>)</span>
                        <span class="font-bold text-[#2C241E]" x-text="'Rp ' + Number(rentalFee).toLocaleString('id-ID')"></span>
                    </div>
                    <div class="flex items-center justify-between text-[#6E6259]">
                        <span>Deposit Jaminan <span class="text-[10px] text-[#3A6B56]">(100% kembali)</span></span>
                        <span class="font-bold text-[#2C241E]" x-text="'Rp ' + Number(depositFee).toLocaleString('id-ID')"></span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-dashed border-[#D8CFC0] text-sm font-bold">
                        <span class="font-serif text-[#2C241E]">Total Dana Tertahan (Escrow)</span>
                        <span class="text-[#D95D39] text-base" x-text="'Rp ' + Number(totalEscrow).toLocaleString('id-ID')"></span>
                    </div>
                </div>

                <!-- Pick-up Point & Handover Note -->
                <div class="pb-4 border-b border-[#D8CFC0] space-y-2.5">
                    <label class="block font-serif font-bold text-xs text-[#2C241E]">Titik Ketemuan & Catatan:</label>
                    <div class="grid grid-cols-2 gap-2 text-xs font-sans">
                        <label class="cursor-pointer border border-[#2C241E] p-2 flex items-center gap-2 transition-colors" :class="handoverLocation === 'pos_satpam' ? 'bg-[#EAF2EE] font-bold text-[#2E5544]' : 'bg-[#F6F1E7] text-[#6E6259]'">
                            <input type="radio" value="pos_satpam" x-model="handoverLocation" class="accent-[#3A6B56]">
                            <span>Pos Satpam Blok C</span>
                        </label>
                        <label class="cursor-pointer border border-[#2C241E] p-2 flex items-center gap-2 transition-colors" :class="handoverLocation === 'teras' ? 'bg-[#EAF2EE] font-bold text-[#2E5544]' : 'bg-[#F6F1E7] text-[#6E6259]'">
                            <input type="radio" value="teras" x-model="handoverLocation" class="accent-[#3A6B56]">
                            <span>Teras Rumah Pemilik</span>
                        </label>
                    </div>
                    <input 
                        type="text" 
                        x-model="handoverNote"
                        placeholder="Catatan singkat (opsional): Ketemuan jam 5 sore ya Mas..."
                        class="w-full bg-[#F6F1E7] border border-[#D8CFC0] focus:border-[#2C241E] px-3 py-1.5 text-xs font-mono text-[#2C241E] placeholder-[#6E6259]/70 focus:outline-none"
                    >
                </div>

                <!-- Component Acknowledgment Checkbox -->
                <div class="space-y-2.5">
                    <div class="bg-[#F6F1E7] px-3 py-2 text-[11px] font-mono text-[#6E6259] border-l-2 border-[#3A6B56]">
                        <strong class="text-[#2C241E]">Termasuk:</strong> 
                        <span x-text="item.pieces ? item.pieces : 'Buku fisik cetakan asli + pembatas pita'"></span>
                    </div>

                    <label class="flex items-center gap-2.5 cursor-pointer select-none text-xs font-sans font-semibold text-[#2C241E]">
                        <input type="checkbox" x-model="agreedToComponents" class="accent-[#D95D39] w-4 h-4">
                        <span>Saya siap menjaga kelengkapan komponen selama masa pinjam</span>
                    </label>
                </div>

                <!-- Confirmation State with Sample OTP Code -->
                <div 
                    x-show="stampedSuccess"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="p-3.5 bg-[#EAF2EE] border border-[#3A6B56] text-[#2E5544] font-mono text-xs flex items-center justify-between gap-3"
                >
                    <div>
                        <strong class="block text-xs uppercase tracking-wider">✓ JADWAL DIKUNCI!</strong>
                        <span class="font-sans text-[11px]">Tunjukkan kode OTP ini saat ketemuan:</span>
                    </div>
                    <div class="border-2 border-dashed border-[#D95D39] bg-[#FFFDF9] text-[#D95D39] px-2.5 py-1 font-black text-sm tracking-widest -rotate-2">
                        <span x-text="otpCode"></span>
                    </div>
                </div>

            </div>

            <!-- Footer CTA -->
            <div class="bg-[#EFE7D8] border-t border-[#D8CFC0] px-5 py-3.5 flex items-center justify-between gap-3">
                <button 
                    type="button" 
                    @click="closeModal()"
                    class="text-xs font-mono font-medium text-[#6E6259] hover:text-[#2C241E] cursor-pointer"
                >
                    Batal
                </button>

                <button 
                    type="button"
                    @click="submitRental()"
                    :disabled="!agreedToComponents || stampedSuccess"
                    class="px-5 py-2.5 font-sans font-bold text-xs sm:text-sm border-[1.5px] border-[#2C241E] transition-all flex items-center gap-2"
                    :class="agreedToComponents && !stampedSuccess 
                        ? 'bg-[#D95D39] text-[#FFFDF9] shadow-[3px_3px_0px_#2C241E] hover:bg-[#C24D2B] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none cursor-pointer' 
                        : 'bg-[#F6F1E7] text-[#6E6259] border-[#6E6259] opacity-60 cursor-not-allowed'"
                >
                    <span x-text="stampedSuccess ? '✓ Jadwal Terkunci' : 'Ajukan Pinjam & Kunci Jadwal'"></span>
                </button>
            </div>
        </div>
    </div>
</div>
