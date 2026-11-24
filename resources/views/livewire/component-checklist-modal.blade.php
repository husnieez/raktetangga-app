<div 
    x-data="{
        isOpen: false,
        item: {
            title: 'Catan: Edisi Bahasa',
            code: 'BG-014',
            owner: 'Mas Dimas'
        },
        components: [
            { id: 1, name: '2x Dadu Kayu Berbintik Enam', checked: false, critical: true },
            { id: 2, name: '1x Papan Lipat Hexagon (Tebal & Bersih)', checked: false, critical: true },
            { id: 3, name: '96x Kartu Sumber Daya & Perkembangan (Sleeved)', checked: false, critical: true },
            { id: 4, name: '16x Token Kota & 20x Token Pemukiman Kayu', checked: false, critical: false },
            { id: 5, name: '1x Buku Manual Petunjuk Aturan Bahasa Indonesia', checked: false, critical: false },
        ],
        hasMissingIssue: false,
        missingNote: '',
        confirmed: false,

        openModal(data) {
            if (data) {
                this.item = data;
                // customize components if boardgame vs book
                if (data.type === 'book') {
                    this.components = [
                        { id: 1, name: 'Cover Depan & Belakang Utuh (Bebas Lipatan Ekstrem)', checked: false, critical: true },
                        { id: 2, name: 'Halaman Lengkap (Cek Sampul 1 - Akhir)', checked: false, critical: true },
                        { id: 3, name: 'Bebas Noda Basah / Tinta Spidol Tebal', checked: false, critical: true },
                        { id: 4, name: '1x Pembatas Buku Pita Kain Asli', checked: false, critical: false },
                    ];
                } else {
                    this.components = [
                        { id: 1, name: '2x Dadu Kayu Berbintik Enam', checked: false, critical: true },
                        { id: 2, name: '1x Papan Lipat Hexagon (Tebal & Rata)', checked: false, critical: true },
                        { id: 3, name: '96x Kartu Permainan (Sleeved / Plastik Rapi)', checked: false, critical: true },
                        { id: 4, name: '16x Token Kayu & Miniatur Rumah', checked: false, critical: false },
                        { id: 5, name: '1x Buku Panduan Lembar Aturan Cetak', checked: false, critical: false },
                    ];
                }
            }
            this.hasMissingIssue = false;
            this.missingNote = '';
            this.confirmed = false;
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
        },
        toggleComponent(comp) {
            comp.checked = !comp.checked;
        },
        get totalCount() {
            return this.components.length;
        },
        get checkedCount() {
            return this.components.filter(c => c.checked).length;
        },
        get progressPercent() {
            return Math.round((this.checkedCount / this.totalCount) * 100);
        },
        get isAllChecked() {
            return this.checkedCount === this.totalCount;
        },
        get canSubmit() {
            if (this.isAllChecked) return true;
            if (this.hasMissingIssue && this.missingNote.trim().length >= 5) return true;
            return false;
        },
        confirmHandover() {
            if (!this.canSubmit) return;
            this.confirmed = true;
            setTimeout(() => {
                if (window.Livewire) {
                    Livewire.dispatch('checklist-verified', {
                        itemId: this.item.id,
                        status: this.hasMissingIssue ? 'VERIFIKASI_DENGAN_CATATAN' : 'KOMPONEN_LENGKAP_100',
                        note: this.missingNote
                    });
                }
            }, 600);
        }
    }"
    @open-checklist.window="openModal($event.detail)"
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
        class="fixed inset-0 z-50 bg-[#2C241E]/75 flex items-center justify-center p-3 sm:p-4 overflow-y-auto"
        @click.self="closeModal()"
    >
        <!-- Modal Card -->
        <div 
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="relative w-full max-w-xl bg-[#FFFDF9] border-[2px] border-[#2C241E] shadow-[8px_8px_0px_#2C241E] my-6"
        >
            <!-- Header Bar -->
            <div class="bg-[#EFE7D8] border-b-[2px] border-[#2C241E] p-4 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 bg-[#3A6B56] text-[#FFFDF9] border border-[#2C241E] flex items-center justify-center text-sm shadow-[1.5px_1.5px_0px_#2C241E]">
                        🔍
                    </span>
                    <div>
                        <span class="font-mono text-[10px] uppercase tracking-wider text-[#6E6259] font-bold block">
                            PROTOKOL RAWAT BERSAMA
                        </span>
                        <h2 class="font-serif font-black text-lg text-[#2C241E]">
                            Lembar Cek Fisik & Kelengkapan
                        </h2>
                    </div>
                </div>

                <button 
                    type="button"
                    @click="closeModal()" 
                    class="w-7 h-7 border border-[#2C241E] bg-[#FFFDF9] text-[#2C241E] font-mono font-bold flex items-center justify-center shadow-[2px_2px_0px_#2C241E] hover:bg-[#D95D39] hover:text-[#FFFDF9] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all"
                >
                    ✕
                </button>
            </div>

            <div class="p-6">
                <!-- Info Item & Subtitle -->
                <div class="bg-[#F6F1E7] border border-[#2C241E] p-3 mb-5 flex items-center justify-between shadow-[2px_2px_0px_#2C241E]">
                    <div>
                        <span class="text-[10px] font-mono uppercase bg-[#2C241E] text-[#FFFDF9] px-1 py-0.5" x-text="item.code || 'BG-014'"></span>
                        <h4 class="font-serif font-bold text-base text-[#2C241E] mt-0.5" x-text="item.title"></h4>
                        <p class="text-xs text-[#6E6259] font-sans">
                            Koleksi milik <span class="font-bold text-[#2C241E]" x-text="item.owner || 'Tetangga'"></span>
                        </p>
                    </div>

                    <div class="text-right">
                        <span class="font-mono text-[11px] text-[#6E6259] block">Status Cek:</span>
                        <span 
                            class="font-mono text-xs font-bold px-2 py-0.5 border"
                            :class="isAllChecked ? 'bg-[#EAF2EE] text-[#3A6B56] border-[#3A6B56]' : 'bg-[#FDF5E8] text-[#BF8228] border-[#E09F3E]'"
                            x-text="isAllChecked ? '100% LENGKAP' : (checkedCount + '/' + totalCount + ' DIPERIKSA')"
                        ></span>
                    </div>
                </div>

                <!-- Board Game Track Milestone Progress Bar -->
                <div class="mb-6 bg-[#FFFDF9] border border-[#2C241E] p-3.5 shadow-[2px_2px_0px_#2C241E]">
                    <div class="flex items-center justify-between text-xs font-mono mb-2">
                        <span class="font-bold text-[#2C241E] flex items-center gap-1.5">
                            <span>🎲</span>
                            <span>Lintasan Verifikasi Meja</span>
                        </span>
                        <span class="font-bold text-[#D95D39]" x-text="progressPercent + '% Selesai'"></span>
                    </div>

                    <!-- Visual Game Track with Stepper Circles -->
                    <div class="relative py-2">
                        <!-- Connecting Track Line -->
                        <div class="absolute top-1/2 left-4 right-4 h-1.5 -translate-y-1/2 bg-[#D8CFC0] border border-[#2C241E]">
                            <!-- Active Track Progress Fill -->
                            <div 
                                class="h-full bg-[#3A6B56] transition-all duration-300"
                                :style="'width: ' + progressPercent + '%'"
                            ></div>
                        </div>

                        <!-- Track Nodes / Wooden Tokens -->
                        <div class="relative flex items-center justify-between">
                            <template x-for="(comp, index) in components" :key="comp.id">
                                <div class="flex flex-col items-center group">
                                    <button 
                                        type="button"
                                        @click="toggleComponent(comp)"
                                        class="w-8 h-8 rounded-full border-2 border-[#2C241E] flex items-center justify-center font-mono text-xs font-bold transition-all shadow-[1.5px_1.5px_0px_#2C241E] hover:scale-110"
                                        :class="comp.checked ? 'bg-[#3A6B56] text-[#FFFDF9] rotate-[-6deg]' : 'bg-[#FFFDF9] text-[#2C241E]'"
                                    >
                                        <span x-show="comp.checked">✓</span>
                                        <span x-show="!comp.checked" x-text="index + 1"></span>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="text-[11px] text-[#6E6259] text-center mt-2 font-sans italic">
                        "Sentuh atau centang tiap token komponen untuk memastikan tidak ada bidak yang tertinggal."
                    </div>
                </div>

                <!-- Interactive Checklist Items (Click to Stamp Checkmark & Strike-through) -->
                <div class="space-y-2.5 mb-5">
                    <template x-for="comp in components" :key="comp.id">
                        <div 
                            @click="toggleComponent(comp)"
                            class="p-3 border-[1.5px] border-[#2C241E] flex items-center justify-between cursor-pointer select-none transition-all duration-150"
                            :class="comp.checked ? 'bg-[#EAF2EE]/60 shadow-[1px_1px_0px_#2C241E] translate-x-0.5' : 'bg-[#FFFDF9] shadow-[3px_3px_0px_#2C241E] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#2C241E]'"
                        >
                            <div class="flex items-center gap-3">
                                <!-- Tactile Checkbox Box -->
                                <div 
                                    class="w-6 h-6 border-2 border-[#2C241E] flex items-center justify-center font-mono font-bold text-sm transition-all shadow-[1px_1px_0px_#2C241E]"
                                    :class="comp.checked ? 'bg-[#3A6B56] text-[#FFFDF9] rotate-[-6deg]' : 'bg-[#FFFDF9] text-transparent'"
                                >
                                    ✓
                                </div>

                                <!-- Component Text with Satisfying Strike-through -->
                                <div>
                                    <span 
                                        class="font-sans text-xs sm:text-sm font-semibold transition-all"
                                        :class="comp.checked ? 'line-through text-[#6E6259] decoration-[#D95D39] decoration-2' : 'text-[#2C241E]'"
                                        x-text="comp.name"
                                    ></span>
                                    <span x-show="comp.critical" class="ml-1 text-[10px] font-mono text-[#D95D39] font-bold">
                                        [WAJIB]
                                    </span>
                                </div>
                            </div>

                            <!-- Stamp pill on checked -->
                            <div class="hidden sm:block">
                                <span 
                                    x-show="comp.checked"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 scale-50 -rotate-12"
                                    x-transition:enter-end="opacity-100 scale-100 rotate-[-2deg]"
                                    class="stamp-badge border-[#3A6B56] text-[#3A6B56] text-[10px]"
                                >
                                    ADA & LENGKAP
                                </span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Missing / Damaged Item Accordion Toggle -->
                <div class="border border-[#2C241E] bg-[#FDF5E8] p-3 mb-4 shadow-[2px_2px_0px_#2C241E]">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" x-model="hasMissingIssue" class="accent-[#E09F3E] w-4 h-4">
                        <span class="font-serif font-bold text-xs text-[#2C241E]">
                            ⚠️ Ada komponen yang kurang / sudah cacat dari awal?
                        </span>
                    </label>

                    <div x-show="hasMissingIssue" x-transition class="mt-2.5 pt-2.5 border-t border-[#D8CFC0]">
                        <p class="text-[11px] text-[#6E6259] mb-1.5 font-sans">
                            Catat agar pemilik dan peminjam sama-sama tahu, sehingga uang jaminan tetap aman saat pengembalian nanti:
                        </p>
                        <textarea 
                            x-model="missingNote"
                            placeholder="Contoh: 1 kartu sumber daya sedikit terlipat di pojok kanan, atau dadu hitam diganti dadu putih..."
                            rows="2"
                            class="w-full bg-[#FFFDF9] border border-[#2C241E] p-2 text-xs font-mono text-[#2C241E] focus:outline-none focus:ring-1 focus:ring-[#2C241E]"
                        ></textarea>
                    </div>
                </div>

                <!-- Confirmation Success Notice -->
                <div 
                    x-show="confirmed"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="p-3 bg-[#EAF2EE] border-2 border-[#3A6B56] text-[#2E5544] font-mono text-xs shadow-[3px_3px_0px_#3A6B56] flex items-center justify-between"
                >
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📜</span>
                        <div>
                            <strong>SERAH TERIMA TELAH DIVERIFIKASI!</strong>
                            <p class="text-[11px] font-sans">Berita acara fisik tersimpan di log peminjaman RT.</p>
                        </div>
                    </div>
                    <button type="button" @click="closeModal()" class="px-2.5 py-1 bg-[#3A6B56] text-[#FFFDF9] font-bold border border-[#2C241E]">
                        Selesai
                    </button>
                </div>

            </div>

            <!-- Footer Action with Physically Locked Button State -->
            <div class="bg-[#EFE7D8] border-t-[2px] border-[#2C241E] p-4 flex items-center justify-between gap-3">
                <button 
                    type="button" 
                    @click="closeModal()"
                    class="px-3.5 py-2 bg-[#FFFDF9] text-[#2C241E] font-sans font-bold text-xs border-[1.5px] border-[#2C241E] shadow-[2.5px_2.5px_0px_#2C241E] hover:bg-[#F6F1E7] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all"
                >
                    Tutup
                </button>

                <!-- Physically Locked Button Until All Checked OR Note Logged -->
                <button 
                    type="button"
                    @click="confirmHandover()"
                    :disabled="!canSubmit || confirmed"
                    class="px-5 py-2.5 font-sans font-bold text-xs sm:text-sm border-[1.5px] border-[#2C241E] transition-all flex items-center gap-2"
                    :class="canSubmit && !confirmed 
                        ? 'bg-[#3A6B56] text-[#FFFDF9] shadow-[3.5px_3.5px_0px_#2C241E] hover:bg-[#2E5544] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4.5px_4.5px_0px_#2C241E] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none' 
                        : 'bg-[#EFE7D8] text-[#6E6259] border-[#6E6259] shadow-[2px_2px_0px_#6E6259] cursor-not-allowed opacity-60'"
                >
                    <!-- Padlock icon when locked -->
                    <span x-show="!canSubmit">🔒</span>
                    <span x-show="canSubmit">🔓</span>
                    <span x-text="canSubmit ? (hasMissingIssue ? 'Konfirmasi dengan Catatan Selisih' : 'Konfirmasi Komponen Lengkap') : 'Terkunci (Periksa Semua Komponen)'"></span>
                </button>
            </div>

        </div>
    </div>
</div>

