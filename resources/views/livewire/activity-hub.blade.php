@extends('layouts.app', ['title' => 'Aktivitas Sewa & Serah Terima — RakTetangga'])

@section('content')
<div 
    x-data="{
        tab: 'pinjaman',
        toastMessage: '',
        activeTx: null,
        otpModalOpen: false,
        otpInput: '',
        otpError: '',
        returnModalOpen: false,
        returnChecklist: [],
        missingNote: '',
        deductionAmount: 0,

        borrowerTransactions: [
            {
                id: 'TX-101',
                code: 'BG-014',
                title: 'Catan: Edisi Bahasa Indonesia',
                counterparty: 'Mas Dimas • Blok C-12',
                dates: '25 Nov – 28 Nov 2026 (3 Hari)',
                escrow: 95000,
                deposit: 50000,
                meetup: 'Pos Satpam Blok C',
                otp: '482-910',
                status: 'SIAP DIAMBIL'
            },
            {
                id: 'TX-102',
                code: 'BK-108',
                title: 'Cantik Itu Luka',
                counterparty: 'Mbak Maya • Blok B-08',
                dates: '24 Nov – 27 Nov 2026 (3 Hari)',
                escrow: 29000,
                deposit: 20000,
                meetup: 'Teras Rumah Blok B-08',
                otp: '119-340',
                status: 'SEDANG DIPINJAM'
            },
            {
                id: 'TX-103',
                code: 'BG-008',
                title: 'Exploding Kittens: NSFW',
                counterparty: 'Rian • Blok E-15',
                dates: '26 Nov – 27 Nov 2026 (1 Hari)',
                escrow: 38000,
                deposit: 30000,
                meetup: 'Warung Bu RT',
                otp: '551-802',
                status: 'MENUNGGU PERSETUJUAN'
            }
        ],

        lenderTransactions: [
            {
                id: 'TX-201',
                code: 'BG-029',
                title: 'Cascadia: Satwa Liar',
                counterparty: 'Mbak Nadia • Blok B-11',
                dates: '22 Nov – 25 Nov 2026 (3 Hari)',
                escrow: 114000,
                deposit: 60000,
                meetup: 'Pos Satpam Blok C',
                otp: '612-884',
                status: 'PENGAJUAN KEMBALI',
                components: [
                    { id: 1, label: '1x Papan Lipat & Kantung Kain', checked: false },
                    { id: 2, label: '2x Dadu Kayu Penentu', checked: false },
                    { id: 3, label: '54x Kartu Skor & Habitat', checked: false },
                    { id: 4, label: '100x Token Satwa Kayu', checked: false }
                ],
                resolutionNote: ''
            },
            {
                id: 'TX-202',
                code: 'BG-051',
                title: 'Splendor: Pedagang Permata',
                counterparty: 'Pak Hendra • Blok C-03',
                dates: '25 Nov – 28 Nov 2026 (3 Hari)',
                escrow: 87000,
                deposit: 45000,
                meetup: 'Teras Rumah Blok A-05',
                otp: '739-204',
                status: 'SIAP DIAMBIL',
                components: [
                    { id: 1, label: '40x Keping Chip Permata', checked: false },
                    { id: 2, label: '90x Kartu Perkembangan', checked: false },
                    { id: 3, label: '10x Ubin Bangsawan', checked: false }
                ],
                resolutionNote: ''
            }
        ],

        get actionRequiredCount() {
            return this.lenderTransactions.filter(t => t.status !== 'SELESAI' && t.status !== 'SEDANG DIPINJAM').length;
        },
        approveRequest(tx) {
            tx.status = 'SIAP DIAMBIL';
            this.toastMessage = `Permintaan '${tx.title}' disetujui! Kode OTP: ${tx.otp}.`;
        },
        openOtpModal(tx) {
            this.activeTx = tx;
            this.otpInput = '';
            this.otpError = '';
            this.otpModalOpen = true;
        },
        verifyOtp() {
            const cleanInput = this.otpInput.replace(/[^0-9]/g, '');
            const expectedClean = this.activeTx.otp.replace(/[^0-9]/g, '');
            if (cleanInput !== expectedClean) {
                this.otpError = 'Kode OTP tidak cocok.';
                return;
            }
            this.activeTx.status = 'SEDANG DIPINJAM';
            this.otpModalOpen = false;
            this.toastMessage = `Serah terima '${this.activeTx.title}' berhasil diverifikasi!`;
        },
        openReturnChecklist(tx) {
            this.activeTx = tx;
            this.returnChecklist = tx.components.map(c => ({ ...c, checked: false }));
            this.missingNote = '';
            this.deductionAmount = 10000;
            this.returnModalOpen = true;
        },
        get returnCheckedCount() {
            return this.returnChecklist.filter(c => c.checked).length;
        },
        get allReturnItemsChecked() {
            return this.returnChecklist.length > 0 && this.returnCheckedCount === this.returnChecklist.length;
        },
        get returnProgressPercent() {
            if (this.returnChecklist.length === 0) return 0;
            return Math.round((this.returnCheckedCount / this.returnChecklist.length) * 100);
        },
        completeReturn(isComplete) {
            if (isComplete) {
                this.activeTx.resolutionNote = '✓ Semua komponen lengkap. Deposit kembali 100%.';
                this.toastMessage = `Pengembalian '${this.activeTx.title}' selesai!`;
            } else {
                this.activeTx.resolutionNote = `⚠️ Selesai dengan catatan: '${this.missingNote}' (Potong Rp ${Number(this.deductionAmount).toLocaleString('id-ID')}).`;
                this.toastMessage = `Pengembalian '${this.activeTx.title}' diselesaikan dengan potongan deposit.`;
            }
            this.activeTx.status = 'SELESAI';
            this.returnModalOpen = false;
        }
    }"
    class="max-w-5xl mx-auto px-4 sm:px-6 py-8"
>
    <div class="mb-6">
        <span class="font-mono text-[11px] uppercase tracking-wider text-[#D95D39] font-bold">🤝 PUSAT SERAH TERIMA WARGA</span>
        <h1 class="font-serif font-black text-3xl text-[#2C241E] mt-1">Aktivitas Sewa & Serah Terima</h1>
        <p class="font-sans text-sm text-[#6E6259] mt-1">Pantau jadwal pengambilan, verifikasi kode OTP saat ketemuan, dan periksa kelengkapan komponen saat pengembalian.</p>
    </div>

    <div x-show="toastMessage" x-transition class="mb-6 bg-[#EAF2EE] border-[1.5px] border-[#3A6B56] text-[#2E5544] px-4 py-3 font-mono text-xs flex items-center justify-between shadow-[3px_3px_0px_#3A6B56]" x-cloak>
        <div class="flex items-center gap-2">
            <span>✅</span>
            <span class="font-bold" x-text="toastMessage"></span>
        </div>
        <button type="button" @click="toastMessage = ''" class="font-bold hover:text-[#D95D39] cursor-pointer">✕</button>
    </div>

    <!-- Role Tabs -->
    <div class="flex items-center gap-2 border-b-2 border-[#2C241E] mb-6">
        <button type="button" @click="tab = 'pinjaman'" class="px-5 py-2.5 font-mono text-xs sm:text-sm font-bold border-t-[1.5px] border-x-[1.5px] border-[#2C241E] transition-all cursor-pointer -mb-[2px]" :class="tab === 'pinjaman' ? 'bg-[#FFFDF9] text-[#2C241E] border-b-2 border-b-[#FFFDF9]' : 'bg-[#EFE7D8] text-[#6E6259] hover:text-[#2C241E]'">
            📖 Pinjaman Saya (<span x-text="borrowerTransactions.length"></span>)
        </button>

        <button type="button" @click="tab = 'masuk'" class="px-5 py-2.5 font-mono text-xs sm:text-sm font-bold border-t-[1.5px] border-x-[1.5px] border-[#2C241E] transition-all cursor-pointer -mb-[2px] flex items-center gap-2" :class="tab === 'masuk' ? 'bg-[#FFFDF9] text-[#2C241E] border-b-2 border-b-[#FFFDF9]' : 'bg-[#EFE7D8] text-[#6E6259] hover:text-[#2C241E]'">
            <span>📦 Permintaan Masuk</span>
            <span x-show="actionRequiredCount > 0" class="px-1.5 py-0.5 text-[10px] rounded-full bg-[#D95D39] text-[#FFFDF9] font-black leading-none" x-text="actionRequiredCount"></span>
        </button>
    </div>

    <!-- TAB 1: Pinjaman Saya -->
    <div x-show="tab === 'pinjaman'" x-transition class="space-y-4">
        <template x-for="tx in borrowerTransactions" :key="tx.id">
            <div class="bg-[#FFFDF9] border-[1.5px] border-[#2C241E] p-5 shadow-[4px_4px_0px_#2C241E] space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 text-xs font-mono text-[#6E6259]">
                            <span class="bg-[#2C241E] text-[#FFFDF9] px-1.5 py-0.5 font-bold" x-text="tx.code"></span>
                            <span x-text="tx.counterparty"></span>
                        </div>
                        <h3 class="font-serif font-black text-xl text-[#2C241E]" x-text="tx.title"></h3>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs font-mono text-[#6E6259] pt-1">
                            <span>📅 <strong class="text-[#2C241E]" x-text="tx.dates"></strong></span>
                            <span>🛡️ Escrow: <strong class="text-[#2C241E]" x-text="'Rp ' + Number(tx.escrow).toLocaleString('id-ID')"></strong></span>
                        </div>
                    </div>
                    <span class="stamp-badge text-[11px]" :class="{'border-[#E09F3E] text-[#BF8228] bg-[#FDF5E8] -rotate-2': tx.status === 'MENUNGGU PERSETUJUAN', 'border-[#D95D39] text-[#D95D39] bg-[#FDF0EC] -rotate-2': tx.status === 'SIAP DIAMBIL', 'border-[#3A6B56] text-[#3A6B56] bg-[#EAF2EE] rotate-1': tx.status === 'SEDANG DIPINJAM', 'border-[#2C241E] text-[#2C241E] bg-[#EFE7D8] -rotate-1': tx.status === 'SELESAI'}" x-text="tx.status"></span>
                </div>

                <template x-if="tx.status === 'SIAP DIAMBIL'">
                    <div class="bg-[#F6F1E7] border border-dashed border-[#2C241E] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="font-mono text-[10px] uppercase font-bold text-[#D95D39] block">🏷️ SLIP PENGAMBILAN BARANG</span>
                            <p class="font-sans text-xs text-[#2C241E] mt-1">Temui pemilik di <strong x-text="tx.meetup"></strong> dan tunjukkan kode OTP di samping.</p>
                        </div>
                        <div class="shrink-0 bg-[#FFFDF9] border-[1.5px] border-[#2C241E] px-4 py-2 text-center shadow-[2px_2px_0px_#2C241E] -rotate-1">
                            <span class="block text-[9px] font-mono uppercase text-[#6E6259]">KODE SERAH TERIMA</span>
                            <strong class="font-mono font-black text-2xl tracking-widest text-[#D95D39]" x-text="tx.otp"></strong>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <!-- TAB 2: Permintaan Masuk -->
    <div x-show="tab === 'masuk'" x-transition class="space-y-4" x-cloak>
        <template x-for="tx in lenderTransactions" :key="tx.id">
            <div class="bg-[#FFFDF9] border-[1.5px] border-[#2C241E] p-5 shadow-[4px_4px_0px_#2C241E] space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 text-xs font-mono text-[#6E6259]">
                            <span class="bg-[#2C241E] text-[#FFFDF9] px-1.5 py-0.5 font-bold" x-text="tx.code"></span>
                            <span>Peminjam: <strong class="text-[#2C241E]" x-text="tx.counterparty"></strong></span>
                        </div>
                        <h3 class="font-serif font-black text-xl text-[#2C241E]" x-text="tx.title"></h3>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs font-mono text-[#6E6259] pt-1">
                            <span>📅 <strong class="text-[#2C241E]" x-text="tx.dates"></strong></span>
                            <span>💰 Dana Tertahan: <strong class="text-[#2C241E]" x-text="'Rp ' + Number(tx.escrow).toLocaleString('id-ID')"></strong></span>
                        </div>
                    </div>
                    <span class="stamp-badge text-[11px]" :class="{'border-[#E09F3E] text-[#BF8228] bg-[#FDF5E8] -rotate-2': tx.status === 'PENGAJUAN KEMBALI', 'border-[#D95D39] text-[#D95D39] bg-[#FDF0EC] -rotate-2': tx.status === 'SIAP DIAMBIL', 'border-[#3A6B56] text-[#3A6B56] bg-[#EAF2EE] rotate-1': tx.status === 'SEDANG DIPINJAM', 'border-[#2C241E] text-[#2C241E] bg-[#EFE7D8] -rotate-1': tx.status === 'SELESAI'}" x-text="tx.status"></span>
                </div>

                <template x-if="tx.status === 'SIAP DIAMBIL'">
                    <div class="pt-3 border-t border-[#D8CFC0] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <span class="text-xs font-sans text-[#6E6259]">Minta 6-digit OTP dari peminjam saat ketemuan.</span>
                        <button type="button" @click="openOtpModal(tx)" class="px-4 py-2 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-xs border-[1.5px] border-[#2C241E] btn-tactile cursor-pointer">🔑 Verifikasi Serah Terima</button>
                    </div>
                </template>

                <template x-if="tx.status === 'PENGAJUAN KEMBALI'">
                    <div class="bg-[#FDF5E8] border border-[#E09F3E] p-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="text-xs font-sans text-[#2C241E]">
                            <strong class="block font-serif text-sm">Barang sudah dikembalikan oleh peminjam!</strong>
                            <span class="text-[#6E6259]">Periksa kelengkapan dadu, papan, & kartu sebelum mencairkan deposit.</span>
                        </div>
                        <button type="button" @click="openReturnChecklist(tx)" class="px-4 py-2.5 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-xs border-[1.5px] border-[#2C241E] btn-tactile cursor-pointer">🔍 Cek Komponen & Selesaikan</button>
                    </div>
                </template>

                <template x-if="tx.status === 'SELESAI'">
                    <div class="pt-2 border-t border-[#D8CFC0] text-xs font-mono text-[#3A6B56]" x-text="tx.resolutionNote"></div>
                </template>
            </div>
        </template>
    </div>

    <!-- OTP Modal -->
    <div x-show="otpModalOpen" x-transition class="fixed inset-0 z-50 bg-[#2C241E]/70 flex items-center justify-center p-4" @click.self="otpModalOpen = false" x-cloak>
        <div class="w-full max-w-sm bg-[#FFFDF9] border-[1.5px] border-[#2C241E] shadow-[4px_4px_0px_#2C241E] overflow-hidden">
            <div class="bg-[#EFE7D8] border-b border-[#D8CFC0] px-4 py-3 flex items-center justify-between">
                <span class="font-mono text-xs font-bold uppercase text-[#2C241E]">🔑 Verifikasi Serah Terima</span>
                <button type="button" @click="otpModalOpen = false" class="font-mono text-xs font-bold cursor-pointer">✕</button>
            </div>
            <form @submit.prevent="verifyOtp()" class="p-5 space-y-4">
                <input type="text" x-model="otpInput" placeholder="Contoh: 739-204" class="w-full bg-[#F6F1E7] border-[1.5px] border-[#2C241E] px-4 py-3 text-center font-mono font-black text-xl tracking-widest text-[#2C241E] focus:outline-none" required>
                <p x-show="otpError" class="text-[11px] font-mono text-[#D95D39] font-bold" x-text="otpError"></p>
                <button type="submit" class="w-full py-2.5 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-xs border-[1.5px] border-[#2C241E] btn-tactile cursor-pointer">✓ Cocokkan Kode & Mulai Sewa</button>
            </form>
        </div>
    </div>

    <!-- Return Checklist Modal -->
    <div x-show="returnModalOpen" x-transition class="fixed inset-0 z-50 bg-[#2C241E]/75 flex items-center justify-center p-3 sm:p-4 overflow-y-auto" @click.self="returnModalOpen = false" x-cloak>
        <div class="w-full max-w-lg bg-[#FFFDF9] border-[1.5px] border-[#2C241E] shadow-[4px_4px_0px_#2C241E] my-6 overflow-hidden">
            <div class="bg-[#EFE7D8] border-b border-[#D8CFC0] px-5 py-3 flex items-center justify-between">
                <h2 class="font-serif font-black text-lg text-[#2C241E]" x-text="activeTx?.title"></h2>
                <button type="button" @click="returnModalOpen = false" class="font-mono text-xs font-bold cursor-pointer">✕</button>
            </div>
            <div class="p-5 sm:p-6 space-y-5">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-xs font-mono">
                        <span class="font-bold text-[#2C241E]">Kelengkapan Komponen:</span>
                        <span class="font-bold" :class="allReturnItemsChecked ? 'text-[#3A6B56]' : 'text-[#D95D39]'" x-text="returnCheckedCount + ' / ' + returnChecklist.length"></span>
                    </div>
                    <div class="w-full h-3 bg-[#F6F1E7] border border-[#2C241E] overflow-hidden">
                        <div class="h-full transition-all duration-300" :class="allReturnItemsChecked ? 'bg-[#3A6B56]' : 'bg-[#E09F3E]'" :style="'width: ' + returnProgressPercent + '%'"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <template x-for="comp in returnChecklist" :key="comp.id">
                        <label class="flex items-center justify-between p-3 border cursor-pointer select-none" :class="comp.checked ? 'bg-[#EAF2EE]/70 border-[#3A6B56]' : 'bg-[#FFFDF9] border-[#2C241E]'">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" x-model="comp.checked" class="accent-[#3A6B56] w-4 h-4">
                                <span class="font-mono text-xs font-bold" :class="comp.checked ? 'line-through text-[#6E6259]' : 'text-[#2C241E]'" x-text="comp.label"></span>
                            </div>
                        </label>
                    </template>
                </div>
                <div x-show="!allReturnItemsChecked" x-transition class="bg-[#FDF0EC] border border-[#D95D39] p-4 space-y-3">
                    <div class="text-xs font-serif font-bold text-[#D95D39]">⚠️ Catat Komponen Hilang / Potong Deposit</div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <input type="text" x-model="missingNote" placeholder="Komponen hilang..." class="sm:col-span-2 bg-[#FFFDF9] border border-[#2C241E] px-2.5 py-1.5 text-xs font-mono">
                        <input type="number" x-model.number="deductionAmount" min="0" step="5000" class="bg-[#FFFDF9] border border-[#2C241E] px-2.5 py-1.5 text-xs font-mono">
                    </div>
                </div>
            </div>
            <div class="bg-[#EFE7D8] border-t border-[#D8CFC0] px-5 py-3.5 flex items-center justify-between gap-3">
                <button type="button" @click="returnModalOpen = false" class="text-xs font-mono text-[#6E6259] cursor-pointer">Batal</button>
                <button x-show="allReturnItemsChecked" type="button" @click="completeReturn(true)" class="px-4 py-2.5 bg-[#3A6B56] text-[#FFFDF9] font-sans font-bold text-xs border-[1.5px] border-[#2C241E] btn-tactile cursor-pointer">✓ Konfirmasi Lengkap & Cairkan Dana</button>
                <button x-show="!allReturnItemsChecked" type="button" @click="completeReturn(false)" :disabled="!missingNote.trim() || deductionAmount <= 0" class="px-4 py-2.5 font-sans font-bold text-xs border-[1.5px] border-[#2C241E]" :class="missingNote.trim() && deductionAmount > 0 ? 'bg-[#D95D39] text-[#FFFDF9] btn-tactile cursor-pointer' : 'bg-[#F6F1E7] text-[#6E6259] opacity-60 cursor-not-allowed'">Catat Selisih & Potong Deposit</button>
            </div>
        </div>
    </div>
</div>
@endsection

