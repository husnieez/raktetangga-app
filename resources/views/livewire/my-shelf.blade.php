@extends('layouts.app', ['title' => 'Rak Koleksiku — Kelola & Titip Koleksi | RakTetangga'])

@section('content')
<div 
    x-data="{
        components: [
            { name: 'Dadu Kayu', qty: 2 },
            { name: 'Papan Lipat', qty: 1 }
        ],
        addComponentRow() {
            this.components.push({ name: '', qty: 1 });
        },
        removeComponentRow(index) {
            this.components.splice(index, 1);
        }
    }"
    class="max-w-6xl mx-auto px-4 sm:px-6 py-8"
>
    @php
        $borrowedCount = $items->where('status', 'DIPINJAM')->count();
        $availableCount = $items->where('status', 'TERSEDIA')->count();
        $estimatedIncome = $items->where('status', 'DIPINJAM')->sum('daily_rate') * 3;
    @endphp

    <!-- Top Summary Strip -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="font-mono text-[11px] uppercase tracking-wider text-[#3A6B56] font-bold">
                📦 MEJA TITIPAN WARGA
            </span>
            <h1 class="font-serif font-black text-3xl text-[#2C241E] mt-1">
                Rak Koleksiku
            </h1>
            <p class="font-sans text-sm text-[#6E6259] mt-1">
                Kelola buku & board game yang kamu titipkan agar bisa dimainkan tetangga sekitar.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 font-mono text-xs">
            <div class="bg-[#FFFDF9] px-4 py-2.5 border border-[#D8CFC0] flex items-center gap-2.5">
                <span class="text-lg">📚</span>
                <div>
                    <span class="block text-[10px] text-[#6E6259] uppercase">Total Koleksi</span>
                    <strong class="text-sm text-[#2C241E]">{{ $items->count() }} Item</strong>
                </div>
            </div>

            <div class="bg-[#EAF2EE] px-4 py-2.5 border border-[#3A6B56]/30 flex items-center gap-2.5">
                <span class="text-lg">🤝</span>
                <div>
                    <span class="block text-[10px] text-[#2E5544] uppercase">Sedang Dipinjam</span>
                    <strong class="text-sm text-[#2E5544]">{{ $borrowedCount }} Item</strong>
                </div>
            </div>

            <div class="bg-[#FDF5E8] px-4 py-2.5 border border-[#E09F3E]/40 flex items-center gap-2.5">
                <span class="text-lg">💰</span>
                <div>
                    <span class="block text-[10px] text-[#BF8228] uppercase">Estimasi Sewa</span>
                    <strong class="text-sm text-[#2C241E]">Rp {{ number_format($estimatedIncome, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div class="mb-6 bg-[#EAF2EE] border-[1.5px] border-[#3A6B56] text-[#2E5544] px-4 py-3 font-mono text-xs flex items-center justify-between shadow-[3px_3px_0px_#3A6B56]">
            <div class="flex items-center gap-2">
                <span>✅</span>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
            <a href="/" class="underline font-bold hover:text-[#D95D39]">Lihat di Beranda →</a>
        </div>
    @endif

    <!-- Notifikasi Error Validasi -->
    @if ($errors->any())
        <div class="mb-6 bg-[#FDF0EC] border-[1.5px] border-[#D95D39] text-[#D95D39] px-4 py-3 font-mono text-xs shadow-[3px_3px_0px_#2C241E]">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Two-Column Responsive Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT COLUMN (lg:col-span-7) — Daftar Koleksiku dari Database -->
        <div class="lg:col-span-7 space-y-4">
            <div class="flex items-center justify-between border-b border-[#D8CFC0] pb-2">
                <h2 class="font-serif font-bold text-lg text-[#2C241E]">Daftar Koleksi di Rak</h2>
                <span class="font-mono text-xs text-[#6E6259]">{{ $availableCount }} Siap Disewakan</span>
            </div>

            @if ($items->isEmpty())
                <div class="bg-[#FFFDF9] border-[1.5px] border-[#2C241E] p-8 text-center shadow-[3px_3px_0px_#2C241E]">
                    <div class="text-3xl mb-2">📭</div>
                    <h3 class="font-serif font-bold text-base text-[#2C241E]">Rak Koleksimu Masih Kosong</h3>
                    <p class="font-sans text-xs text-[#6E6259] mt-1">
                        Isi formulir di sebelah kanan untuk mulai menitipkan buku, komik, atau board game ke tetangga!
                    </p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($items as $item)
                        <div x-data="{ showComponents: false }" class="bg-[#FFFDF9] border-[1.5px] border-[#2C241E] p-4 shadow-[3px_3px_0px_#2C241E] transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start gap-3.5 min-w-0">
                                    <div 
                                        class="w-12 h-14 shrink-0 border border-[#2C241E] flex items-center justify-center text-xl shadow-[2px_2px_0px_#2C241E]"
                                        style="background-color: {{ $item->type === 'boardgame' ? '#E09F3E' : ($item->type === 'comic' ? '#EFE7D8' : '#EAF2EE') }}"
                                    >
                                        <span>{{ $item->type === 'boardgame' ? '🎲' : ($item->type === 'comic' ? '💭' : '📚') }}</span>
                                    </div>

                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-mono text-[10px] font-bold bg-[#EFE7D8] text-[#2C241E] px-1.5 py-0.5 border border-[#D8CFC0]">{{ $item->code }}</span>
                                            <span class="font-mono text-[10px] text-[#6E6259]">{{ $item->author_or_genre }}</span>
                                            @if ($item->status === 'DIPINJAM')
                                                <span class="font-mono text-[10px] font-bold bg-[#FDF0EC] text-[#D95D39] px-1.5 py-0.5 border border-[#D95D39]/40">Sedang Dipinjam</span>
                                            @else
                                                <span class="font-mono text-[10px] font-bold bg-[#EAF2EE] text-[#3A6B56] px-1.5 py-0.5 border border-[#3A6B56]/40">Tersedia</span>
                                            @endif
                                        </div>
                                        <h3 class="font-serif font-bold text-base text-[#2C241E] mt-1 truncate">{{ $item->title }}</h3>
                                        <div class="font-mono text-xs text-[#6E6259] mt-0.5 flex items-center gap-3">
                                            <span><strong class="text-[#2C241E]">Rp {{ number_format($item->daily_rate, 0, ',', '.') }}</strong>/hari</span>
                                            <span>•</span>
                                            <span>Deposit: Rp {{ number_format($item->deposit, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex sm:flex-col items-center sm:items-end justify-between gap-2.5 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-[#D8CFC0]/60">
                                    <button type="button" @click="showComponents = !showComponents" class="text-xs font-mono font-bold text-[#2C241E] bg-[#F6F1E7] hover:bg-[#EFE7D8] border border-[#2C241E] px-2.5 py-1 transition-colors cursor-pointer flex items-center gap-1">
                                        <span>🔍</span>
                                        <span x-text="showComponents ? 'Tutup Detail' : 'Cek Kelengkapan'"></span>
                                    </button>
                                </div>
                            </div>

                            <div x-show="showComponents" x-transition x-cloak class="mt-4 pt-3 border-t border-dashed border-[#D8CFC0]">
                                <div class="text-[11px] font-mono uppercase font-bold text-[#6E6259] mb-1">Kelengkapan & Catatan Fisik:</div>
                                <div class="bg-[#F6F1E7] border border-[#D8CFC0] px-3 py-2 text-xs font-mono text-[#2C241E]">
                                    {{ $item->pieces ?: 'Sesuai standar kelengkapan asli.' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN (lg:col-span-5) — Form "Titip Koleksi Baru" terhubung ke Database -->
        <div class="lg:col-span-5 bg-[#FFFDF9] border-[1.5px] border-[#2C241E] p-6 shadow-[4px_4px_0px_#2C241E]">
            <div class="border-b border-[#D8CFC0] pb-3 mb-5">
                <span class="font-mono text-[10px] uppercase tracking-wider text-[#D95D39] font-bold block">+ FORMULIR PENDAFTARAN BARANG</span>
                <h2 class="font-serif font-black text-xl text-[#2C241E]">Titip Koleksi Baru</h2>
            </div>

            <form method="POST" action="{{ route('shelf.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">Judul Buku / Board Game / Komik:</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Ticket to Ride: Europe" required class="w-full bg-[#F6F1E7] border border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] focus:outline-none focus:bg-[#FFFDF9]">
                </div>

                <div>
                    <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">Pengarang / Genre / Pemain:</label>
                    <input type="text" name="author_or_genre" value="{{ old('author_or_genre') }}" placeholder="Contoh: Tere Liye atau 2-4 Pemain • Strategi" required class="w-full bg-[#F6F1E7] border border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] focus:outline-none focus:bg-[#FFFDF9]">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">Kategori:</label>
                        <select name="type" class="w-full bg-[#F6F1E7] border border-[#2C241E] px-2.5 py-2 text-xs font-mono text-[#2C241E] focus:outline-none cursor-pointer">
                            <option value="boardgame" {{ old('type') === 'boardgame' ? 'selected' : '' }}>🎲 Board Game</option>
                            <option value="book" {{ old('type') === 'book' ? 'selected' : '' }}>📚 Buku</option>
                            <option value="comic" {{ old('type') === 'comic' ? 'selected' : '' }}>💭 Komik</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">Kondisi Fisik:</label>
                        <select name="condition" class="w-full bg-[#F6F1E7] border border-[#2C241E] px-2.5 py-2 text-xs font-mono text-[#2C241E] focus:outline-none cursor-pointer">
                            <option value="Mint / Mulus">Mint / Mulus</option>
                            <option value="Baik">Baik</option>
                            <option value="Layak Baca">Layak Baca</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">Tarif Harian (Rp):</label>
                        <input type="number" name="daily_rate" value="{{ old('daily_rate', 12000) }}" min="1000" step="500" required class="w-full bg-[#F6F1E7] border border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] focus:outline-none focus:bg-[#FFFDF9]">
                    </div>
                    <div>
                        <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">Nominal Deposit (Rp):</label>
                        <input type="number" name="deposit" value="{{ old('deposit', 40000) }}" min="0" step="5000" required class="w-full bg-[#F6F1E7] border border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] focus:outline-none focus:bg-[#FFFDF9]">
                    </div>
                </div>

                <!-- Dynamic Component Repeater (Terkirim sebagai array comp_names[] & comp_qtys[]) -->
                <div class="pt-3 border-t border-[#D8CFC0]">
                    <div class="flex items-center justify-between mb-2">
                        <label class="font-serif font-bold text-xs text-[#2C241E]">Daftar Kelengkapan / Komponen</label>
                        <button type="button" @click="addComponentRow()" class="text-[11px] font-mono font-bold text-[#3A6B56] hover:text-[#2C241E] cursor-pointer">+ Tambah Komponen</button>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(comp, index) in components" :key="index">
                            <div class="flex items-center gap-2">
                                <input type="text" name="comp_names[]" x-model="comp.name" placeholder="Nama (mis: Dadu Kayu)" class="flex-grow bg-[#F6F1E7] border border-[#D8CFC0] focus:border-[#2C241E] px-2.5 py-1.5 text-xs font-mono text-[#2C241E] focus:outline-none">
                                <input type="number" name="comp_qtys[]" x-model="comp.qty" min="1" placeholder="Jml" class="w-16 bg-[#F6F1E7] border border-[#D8CFC0] focus:border-[#2C241E] px-2 py-1.5 text-xs font-mono text-center text-[#2C241E] focus:outline-none">
                                <button type="button" @click="removeComponentRow(index)" class="w-7 h-7 flex items-center justify-center text-xs text-[#6E6259] hover:text-[#D95D39] cursor-pointer">✕</button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full py-3 px-4 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-sm border-[1.5px] border-[#2C241E] shadow-[3px_3px_0px_#2C241E] hover:bg-[#C24D2B] active:translate-x-0.5 active:translate-y-0.5 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <span>📥</span>
                        <span>Simpan ke Rak</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection