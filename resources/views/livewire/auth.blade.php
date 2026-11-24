@extends('layouts.app', ['title' => 'Masuk & Daftar Anggota — RakTetangga'])

@section('content')
<div 
    x-data="{
        mode: 'register',
        showPassword: false,
        form: {
            name: '',
            phone: '',
            block: 'Blok C',
            role: 'keduanya',
            password: ''
        },
        loginForm: {
            identifier: '',
            password: '',
            remember: true
        },
        get isFormComplete() {
            return this.form.name.trim().length >= 3 &&
                   this.form.phone.trim().length >= 8 &&
                   this.form.password.length >= 6;
        }
    }"
    class="min-h-[80vh] flex items-center justify-center py-10 px-4 sm:px-6"
>
    <!-- Split Two-Column Container Card -->
    <div class="w-full max-w-4xl bg-[#FFFDF9] border-[1.5px] border-[#2C241E] shadow-[6px_6px_0px_#2C241E] overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            
            <!-- LEFT COLUMN: Interactive Form (7 Cols) -->
            <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between border-b lg:border-b-0 lg:border-r-[1.5px] border-[#2C241E]">
                <div>
                    <!-- Header & Brand Cue -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 bg-[#D95D39] text-[#FFFDF9] border border-[#2C241E] flex items-center justify-center font-bold text-xs shadow-[1.5px_1.5px_0px_#2C241E]">
                                📚
                            </span>
                            <span class="font-serif font-black text-xl text-[#2C241E] tracking-tight">RakTetangga</span>
                        </div>
                        <span class="font-mono text-[10px] uppercase bg-[#EAF2EE] text-[#3A6B56] border border-[#3A6B56] px-1.5 py-0.5 font-bold">
                            KELUARGA BESAR RT 04
                        </span>
                    </div>

                    <!-- Mode Switcher Tab -->
                    <div class="flex border-[1.5px] border-[#2C241E] p-1 bg-[#F6F1E7] mb-6 shadow-[2px_2px_0px_#2C241E]">
                        <button 
                            type="button" 
                            @click="mode = 'register'"
                            class="flex-1 py-1.5 text-xs font-mono font-bold transition-all cursor-pointer"
                            :class="mode === 'register' ? 'bg-[#2C241E] text-[#FFFDF9] shadow-[1px_1px_0px_#2C241E]' : 'text-[#6E6259] hover:text-[#2C241E]'"
                        >
                            Daftar Anggota Baru
                        </button>
                        <button 
                            type="button" 
                            @click="mode = 'login'"
                            class="flex-1 py-1.5 text-xs font-mono font-bold transition-all cursor-pointer"
                            :class="mode === 'login' ? 'bg-[#2C241E] text-[#FFFDF9] shadow-[1px_1px_0px_#2C241E]' : 'text-[#6E6259] hover:text-[#2C241E]'"
                        >
                            Sudah Punya Kartu
                        </button>
                    </div>

                    <!-- REGISTER FORM -->
                    <form method="POST" action="/register" x-show="mode === 'register'" x-transition class="space-y-4">
                        @csrf
                        <div>
                            <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">
                                Nama Lengkap / Panggilan Tetangga:
                            </label>
                            <input 
                                type="text" 
                                name="name"
                                x-model="form.name"
                                placeholder="Contoh: Mas Budi Prasetyo / Mbak Rina"
                                class="w-full bg-[#FFFDF9] border-[1.5px] border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] placeholder-[#6E6259]/60 focus:outline-none focus:ring-1 focus:ring-[#2C241E]"
                                required
                            >
                        </div>

                        <div>
                            <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">
                                Nomor WhatsApp (Koordinasi Serah Terima):
                            </label>
                            <input 
                                type="tel" 
                                name="phone"
                                x-model="form.phone"
                                placeholder="0812-3456-7890"
                                class="w-full bg-[#FFFDF9] border-[1.5px] border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] placeholder-[#6E6259]/60 focus:outline-none focus:ring-1 focus:ring-[#2C241E]"
                                required
                            >
                        </div>

                        <div>
                            <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">
                                Blok / Zona Domisili:
                            </label>
                            <div class="relative">
                                <select 
                                    name="block"
                                    x-model="form.block"
                                    class="w-full bg-[#FFFDF9] border-[1.5px] border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] appearance-none focus:outline-none focus:ring-1 focus:ring-[#2C241E] cursor-pointer"
                                >
                                    <option value="Blok A">Blok A (Sektor Depan)</option>
                                    <option value="Blok B">Blok B (Taman Melati)</option>
                                    <option value="Blok C">Blok C (Dekat Pos Satpam)</option>
                                    <option value="Blok D">Blok D (Area Lapangan)</option>
                                    <option value="Area Kos">Area Kos / Kontrakan Warga</option>
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none text-[#6E6259]">▼</span>
                            </div>
                        </div>

                        <!-- Role Pill Toggle -->
                        <div>
                            <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1.5">
                                Peran Awal di Komunitas:
                            </label>
                            <input type="hidden" name="role" :value="form.role">
                            <div class="grid grid-cols-3 gap-2">
                                <button 
                                    type="button"
                                    @click="form.role = 'peminjam'"
                                    class="p-2 border-[1.5px] text-left transition-all cursor-pointer"
                                    :class="form.role === 'peminjam' ? 'bg-[#EAF2EE] border-[#3A6B56] shadow-[2px_2px_0px_#3A6B56]' : 'bg-[#FFFDF9] border-[#2C241E] hover:bg-[#F6F1E7]'"
                                >
                                    <span class="block text-sm">📖</span>
                                    <span class="block font-serif font-bold text-[11px] text-[#2C241E] leading-tight">Mau Pinjam Aja</span>
                                    <span class="text-[9px] font-mono text-[#6E6259]">Pembaca & Pemain</span>
                                </button>

                                <button 
                                    type="button"
                                    @click="form.role = 'pemilik'"
                                    class="p-2 border-[1.5px] text-left transition-all cursor-pointer"
                                    :class="form.role === 'pemilik' ? 'bg-[#FDF0EC] border-[#D95D39] shadow-[2px_2px_0px_#D95D39]' : 'bg-[#FFFDF9] border-[#2C241E] hover:bg-[#F6F1E7]'"
                                >
                                    <span class="block text-sm">📦</span>
                                    <span class="block font-serif font-bold text-[11px] text-[#2C241E] leading-tight">Mau Titip Koleksi</span>
                                    <span class="text-[9px] font-mono text-[#6E6259]">Dapat Uang Saku</span>
                                </button>

                                <button 
                                    type="button"
                                    @click="form.role = 'keduanya'"
                                    class="p-2 border-[1.5px] text-left transition-all cursor-pointer"
                                    :class="form.role === 'keduanya' ? 'bg-[#FDF5E8] border-[#E09F3E] shadow-[2px_2px_0px_#E09F3E]' : 'bg-[#FFFDF9] border-[#2C241E] hover:bg-[#F6F1E7]'"
                                >
                                    <span class="block text-sm">🤝</span>
                                    <span class="block font-serif font-bold text-[11px] text-[#2C241E] leading-tight">Keduanya</span>
                                    <span class="text-[9px] font-mono text-[#6E6259]">Direkomendasikan</span>
                                </button>
                            </div>
                        </div>

                        <!-- Kata Sandi -->
                        <div>
                            <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">
                                Kata Sandi:
                            </label>
                            <div class="relative">
                                <input 
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    x-model="form.password"
                                    placeholder="Minimal 6 karakter..."
                                    class="w-full bg-[#FFFDF9] border-[1.5px] border-[#2C241E] px-3 py-2 pr-10 text-xs font-mono text-[#2C241E] focus:outline-none focus:ring-1 focus:ring-[#2C241E]"
                                    required
                                >
                                <button 
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-xs text-[#6E6259]"
                                    x-text="showPassword ? '🙈' : '👁️'"
                                ></button>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button 
                                type="submit"
                                class="w-full py-3 px-4 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-sm border-[1.5px] border-[#2C241E] btn-tactile flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>🖨️</span>
                                <span>Cetak & Terbitkan Kartu Warga</span>
                            </button>
                        </div>
                    </form>

                    {{-- Kotak Notifikasi Gagal Login / Daftar --}}
                    @if ($errors->any())
                        <div class="mb-5 bg-[#FDF0EC] border-2 border-[#D95D39] p-3.5 shadow-[3px_3px_0px_#2C241E] text-xs">
                            <div class="flex items-center gap-2 font-mono font-bold text-[#D95D39] mb-1">
                                <span>⚠️</span>
                                <span>GAGAL MEMPROSES DATA WARGA:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1 font-sans text-[#2C241E]">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- LOGIN FORM -->
                    <form method="POST" action="/login" x-show="mode === 'login'" x-transition class="space-y-4">
                        @csrf
                        <div>
                            <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">
                                Nomor WhatsApp atau ID Anggota:
                            </label>
                            <input 
                                type="text" 
                                name="identifier"
                                x-model="loginForm.identifier"
                                placeholder="Contoh: 0812-3456-7890 atau #RT-042"
                                class="w-full bg-[#FFFDF9] border-[1.5px] border-[#2C241E] px-3 py-2 text-xs font-mono text-[#2C241E] focus:outline-none focus:ring-1 focus:ring-[#2C241E]"
                                required
                            >
                        </div>

                        <div>
                            <label class="block font-serif font-bold text-xs text-[#2C241E] mb-1">
                                Kata Sandi:
                            </label>
                            <div class="relative">
                                <input 
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    x-model="loginForm.password"
                                    placeholder="Ketik kata sandi akunmu..."
                                    class="w-full bg-[#FFFDF9] border-[1.5px] border-[#2C241E] px-3 py-2 pr-10 text-xs font-mono text-[#2C241E] focus:outline-none focus:ring-1 focus:ring-[#2C241E]"
                                    required
                                >
                                <button 
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-xs text-[#6E6259]"
                                    x-text="showPassword ? '🙈' : '👁️'"
                                ></button>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button 
                                type="submit"
                                class="w-full py-3 px-4 bg-[#D95D39] text-[#FFFDF9] font-sans font-bold text-sm border-[1.5px] border-[#2C241E] btn-tactile flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>🔑</span>
                                <span>Buka Kunci Rak Peminjaman</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RIGHT COLUMN: Live Preview "Kartu Anggota Komunitas" (5 Cols) -->
            <div class="lg:col-span-5 bg-[#F6F1E7] p-6 sm:p-8 flex flex-col justify-between items-center relative overflow-hidden">
                
                <div class="w-full max-w-sm mb-2 flex items-center justify-between text-xs font-mono text-[#6E6259]">
                    <span class="font-bold flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#D95D39] animate-pulse"></span>
                        <span>PRATINJAU FISIK KARTU:</span>
                    </span>
                    <span class="text-[10px] uppercase text-[#3A6B56] font-bold" x-text="isFormComplete ? '● SIAP DICAP' : '○ MENGISI DATA'"></span>
                </div>

                <!-- Physical Card -->
                <div class="w-full max-w-sm bg-[#FFFDF9] border-2 border-[#2C241E] shadow-[5px_5px_0px_#2C241E] relative flex flex-col justify-between overflow-hidden my-auto select-none transition-all duration-200">
                    <div class="bg-[#EFE7D8] border-b-[1.5px] border-[#2C241E] px-4 py-2.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3.5 h-3.5 rounded-full border border-[#2C241E] bg-[#F6F1E7]"></div>
                            <span class="font-mono text-[10px] font-bold tracking-widest text-[#2C241E] uppercase">
                                KARTU TANDA ANGGOTA
                            </span>
                        </div>
                        <span class="font-mono text-[10px] font-black text-[#D95D39] bg-[#FFFDF9] border border-[#2C241E] px-1.5 py-0.5">
                            #RT-049
                        </span>
                    </div>

                    <div class="p-4 relative bg-[repeating-linear-gradient(to_bottom,transparent,transparent_27px,#D8CFC0_27px,#D8CFC0_28px)]">
                        <div class="flex items-center justify-between mb-3 border-b border-[#2C241E] pb-2">
                            <div>
                                <span class="font-serif font-black text-sm text-[#2C241E] block leading-tight">RakTetangga</span>
                                <span class="text-[9px] font-mono text-[#6E6259]">Perpustakaan & Meja Bersama</span>
                            </div>
                            <div class="text-right font-mono text-[9px] text-[#6E6259]">
                                <span>TGL TERBIT:</span><br>
                                <strong class="text-[#2C241E]">24 NOV 2026</strong>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 my-2">
                            <div class="w-14 h-16 border-[1.5px] border-dashed border-[#2C241E] bg-[#F6F1E7] flex flex-col items-center justify-center p-1 text-center shrink-0">
                                <span class="text-xl">👤</span>
                                <span class="font-mono text-[8px] uppercase text-[#6E6259] mt-0.5" x-text="form.block.split(' ')[0]"></span>
                            </div>

                            <div class="flex-grow space-y-1">
                                <div>
                                    <span class="text-[9px] font-mono uppercase text-[#6E6259] block">Nama Warga:</span>
                                    <div 
                                        class="font-serif font-bold text-base text-[#2C241E] leading-tight truncate max-w-[170px]"
                                        x-text="form.name.trim() ? form.name : 'Nama Calon Warga'"
                                        :class="!form.name.trim() ? 'opacity-40 italic' : ''"
                                    ></div>
                                </div>

                                <div>
                                    <span class="text-[9px] font-mono uppercase text-[#6E6259] block">WhatsApp / Kontak:</span>
                                    <div 
                                        class="font-mono text-xs text-[#2C241E]"
                                        x-text="form.phone.trim() ? form.phone : '08xx-xxxx-xxxx'"
                                        :class="!form.phone.trim() ? 'opacity-40' : ''"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-2 border-t border-[#D8CFC0] grid grid-cols-2 gap-2 text-xs font-mono">
                            <div>
                                <span class="text-[9px] text-[#6E6259] block uppercase">Domisili:</span>
                                <span class="font-bold text-[#2C241E] text-[11px] bg-[#EFE7D8] px-1 py-0.5 border border-[#2C241E] inline-block" x-text="form.block"></span>
                            </div>
                            <div>
                                <span class="text-[9px] text-[#6E6259] block uppercase">Peran:</span>
                                <span 
                                    class="font-bold text-[10px] px-1 py-0.5 border border-[#2C241E] inline-block uppercase"
                                    x-text="form.role === 'peminjam' ? 'PEMINJAM' : (form.role === 'pemilik' ? 'PEMILIK' : 'LENGKAP')"
                                ></span>
                            </div>
                        </div>

                        <div class="mt-3 pt-2 border-t border-[#2C241E]/40 flex items-center justify-between text-[10px] font-mono text-[#6E6259]">
                            <span class="tracking-widest font-black text-xs">||||| || |||||| | ||||</span>
                            <span>VERIFIKASI RT 04</span>
                        </div>

                        <!-- Rubber Stamp Trigger on Complete -->
                        <div 
                            x-show="isFormComplete"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-150 rotate-45"
                            x-transition:enter-end="opacity-100 scale-100 -rotate-8"
                            class="absolute bottom-4 right-3 pointer-events-none"
                        >
                            <div class="border-2 border-dashed border-[#3A6B56] bg-[#EAF2EE]/90 text-[#3A6B56] px-2.5 py-1 font-mono font-black text-xs tracking-wider uppercase -rotate-6 shadow-[2px_2px_0px_#3A6B56]">
                                ✓ WARGA TERVERIFIKASI
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full max-w-sm mt-3 text-center">
                    <p class="text-[11px] font-sans text-[#6E6259] leading-tight">
                        "Kartu fisik ini tersimpan di sistem RT dan digunakan saat serah terima buku & game di Pos Satpam."
                    </p>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

