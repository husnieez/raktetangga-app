@extends('layouts.app', ['title' => 'Dompet Warga & Antrean — RakTetangga'])

@section('content')
<div 
    x-data="{
        availableBalance: 125000,
        escrowBalance: 45000,
        toastMessage: '',
        ledger: [
            { id: 1, date: '24 Nov', label: 'Pendapatan Sewa Catan (Mas Hendra)', type: 'credit', amount: 15000 },
            { id: 2, date: '22 Nov', label: 'Escrow Deposit Bumi Manusia', type: 'debit', amount: 30000 },
            { id: 3, date: '19 Nov', label: 'Pengembalian Deposit (Selesai Utuh)', type: 'credit', amount: 30000 },
        ],
        waitlist: [
            {
                id: 1,
                code: 'BK-045',
                title: 'Bumi Manusia — Pramoedya Ananta Toer',
                owner: 'Bu Retno (Blok D-02)',
                position: 1,
                totalQueue: 3,
                eta: '27 Nov 2026'
            },
            {
                id: 2,
                code: 'BK-230',
                title: 'Filosofi Teras — Henry Manampiring',
                owner: 'Mas Danang (Blok C-01)',
                position: 2,
                totalQueue: 4,
                eta: '30 Nov 2026'
            }
        ],
        topUpSimulation() {
            const addAmount = 50000;
            this.availableBalance += addAmount;
            this.ledger.unshift({
                id: Date.now(),
                date: '25 Nov',
                label: 'Isi Saldo Kas Warga (Simulasi)',
                type: 'credit',
                amount: addAmount
            });
            this.toastMessage = 'Saldo berhasil ditambah +Rp 50.000 (Simulasi).';
        },
        cancelWaitlist(index, title) {
            this.waitlist.splice(index, 1);
            this.toastMessage = `Antrean untuk '${title}' telah dibatalkan.`;
        }
    }"
    class="max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-8"
>
    <div>
        <span class="font-mono text-[11px] uppercase tracking-wider text-[#3A6B56] font-bold">📒 BUKU KAS KOMUNITAS • #RT-042</span>
        <h1 class="font-serif font-black text-3xl text-[#2C241E] mt-1">Dompet Warga & Antrean</h1>
        <p class="font-sans text-sm text-[#6E6259] mt-1">Catatan saldo kas sewa, dana jaminan tertahan (escrow), dan urutan antrean koleksi favoritmu.</p>
    </div>

    <div x-show="toastMessage" x-transition class="bg-[#EAF2EE] border-[1.5px] border-[#3A6B56] text-[#2E5544] px-4 py-2.5 font-mono text-xs flex items-center justify-between shadow-[3px_3px_0px_#3A6B56]" x-cloak>
        <div class="flex items-center gap-2">
            <span>✅</span>
            <span class="font-bold" x-text="toastMessage"></span>
        </div>
        <button type="button" @click="toastMessage = ''" class="font-bold hover:text-[#D95D39] cursor-pointer">✕</button>
    </div>

    <!-- Passbook Balance Header -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-[#FFFDF9] border-[1.5px] border-[#2C241E] p-5 shadow-[4px_4px_0px_#2C241E] flex flex-col justify-between gap-4">
            <div>
                <span class="font-mono text-[10px] uppercase tracking-wider text-[#6E6259] font-bold block">SALDO SIAP PAKAI / TARIK</span>
                <div class="font-mono font-black text-3xl text-[#2C241E] mt-1">
                    Rp <span x-text="Number(availableBalance).toLocaleString('id-ID')"></span>
                </div>
            </div>
            <div class="flex items-center justify-between pt-3 border-t border-[#D8CFC0]">
                <span class="text-[11px] font-sans text-[#6E6259]">Siap untuk sewa atau tarik kas</span>
                <button type="button" @click="topUpSimulation()" class="px-3 py-1.5 bg-[#D95D39] text-[#FFFDF9] font-mono font-bold text-xs border border-[#2C241E] btn-tactile cursor-pointer">+ Isi Saldo (Simulasi)</button>
            </div>
        </div>

        <div class="bg-[#EFE7D8] border-[1.5px] border-[#2C241E] p-5 shadow-[4px_4px_0px_#2C241E] flex flex-col justify-between gap-4 relative">
            <div>
                <div class="flex items-center justify-between">
                    <span class="font-mono text-[10px] uppercase tracking-wider text-[#6E6259] font-bold">DANA TERTAHAN DI ESCROW</span>
                    <div class="relative" x-data="{ showTip: false }" @mouseenter="showTip = true" @mouseleave="showTip = false">
                        <button type="button" @click="showTip = !showTip" class="w-5 h-5 rounded-full border border-[#2C241E] bg-[#FFFDF9] text-[#2C241E] font-mono text-[10px] font-bold flex items-center justify-center cursor-help">?</button>
                        <div x-show="showTip" x-transition class="absolute right-0 top-full mt-2 w-56 bg-[#2C241E] text-[#FFFDF9] p-2.5 text-[11px] font-sans leading-snug shadow-[3px_3px_0px_#D95D39] z-20" x-cloak>
                            Otomatis kembali setelah barang dikembalikan lengkap
                        </div>
                    </div>
                </div>
                <div class="font-mono font-black text-3xl text-[#2C241E] mt-1">
                    Rp <span x-text="Number(escrowBalance).toLocaleString('id-ID')"></span>
                </div>
            </div>
            <div class="pt-3 border-t border-[#D8CFC0] text-[11px] font-sans text-[#6E6259]">
                🛡️ Otomatis kembali setelah barang dikembalikan lengkap.
            </div>
        </div>
    </div>

    <!-- Ruled Ledger Transaction History -->
    <section class="bg-[#FFFDF9] border-[1.5px] border-[#2C241E] shadow-[4px_4px_0px_#2C241E] overflow-hidden">
        <div class="bg-[#EFE7D8] border-b-[1.5px] border-[#2C241E] px-5 py-3 flex items-center justify-between">
            <h2 class="font-serif font-bold text-base text-[#2C241E]">Mutasi Buku Kas</h2>
            <span class="font-mono text-[10px] uppercase text-[#6E6259] font-bold">CATATAN TERBARU</span>
        </div>
        <div class="px-5 py-2">
            <template x-for="entry in ledger" :key="entry.id">
                <div class="py-3 border-b border-[#D8CFC0] last:border-b-0 flex items-center justify-between gap-4 text-xs">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="font-mono text-[11px] text-[#6E6259] shrink-0 w-16" x-text="entry.date"></span>
                        <span class="font-sans font-medium text-[#2C241E] truncate" x-text="entry.label"></span>
                    </div>
                    <span class="font-mono font-bold shrink-0" :class="entry.type === 'credit' ? 'text-[#3A6B56]' : 'text-[#D95D39]'" x-text="(entry.type === 'credit' ? '+Rp ' : '-Rp ') + Number(entry.amount).toLocaleString('id-ID')"></span>
                </div>
            </template>
        </div>
    </section>

    <!-- Active Waitlist Queue -->
    <section class="bg-[#FFFDF9] border-[1.5px] border-[#2C241E] shadow-[4px_4px_0px_#2C241E] overflow-hidden">
        <div class="bg-[#EFE7D8] border-b-[1.5px] border-[#2C241E] px-5 py-3 flex items-center justify-between">
            <h2 class="font-serif font-bold text-base text-[#2C241E]">Daftar Antrean Koleksi</h2>
            <span class="font-mono text-[10px] uppercase text-[#6E6259] font-bold" x-text="waitlist.length + ' Antrean Aktif'"></span>
        </div>
        <div class="divide-y divide-[#D8CFC0]">
            <template x-for="(q, index) in waitlist" :key="q.id">
                <div class="p-4 sm:px-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-mono text-[10px] font-bold bg-[#2C241E] text-[#FFFDF9] px-1.5 py-0.5" x-text="q.code"></span>
                            <span class="font-mono text-[10px] font-bold bg-[#FDF5E8] text-[#BF8228] border border-[#E09F3E] px-2 py-0.5" x-text="'Urutan #' + q.position + ' dari ' + q.totalQueue"></span>
                        </div>
                        <h3 class="font-serif font-bold text-base text-[#2C241E]" x-text="q.title"></h3>
                        <p class="font-mono text-[11px] text-[#6E6259]" x-text="'Milik ' + q.owner + ' • Estimasi tersedia: ' + q.eta"></p>
                    </div>
                    <button type="button" @click="cancelWaitlist(index, q.title)" class="text-xs font-mono font-bold text-[#6E6259] hover:text-[#D95D39] underline decoration-dashed self-start sm:self-center cursor-pointer">Batalkan Antrean</button>
                </div>
            </template>
            <template x-if="waitlist.length === 0">
                <div class="p-8 text-center font-mono text-xs text-[#6E6259]">Tidak ada antrean koleksi saat ini.</div>
            </template>
        </div>
    </section>
</div>
@endsection

