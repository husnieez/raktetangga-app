# 📚🎲 RakTetangga — Platform Peminjaman Buku & Board Game Komunitas

**RakTetangga** adalah aplikasi web berbasis komunitas (*hyperlocal peer-to-peer rental*) yang memungkinkan warga dalam satu lingkungan (RT/RW) untuk saling meminjamkan buku fisik, komik, dan *board game* secara aman, transparan, dan terstruktur.

## ✨ Fitur Utama

* **Katalog Meja Warga & Filter Real-Time:** Pencarian judul, kode koleksi, atau pengarang secara langsung dilengkapi filter kategori (*Buku*, *Board Game*, *Komik*), radius jarak rumah, dan ketersediaan barang.

* **Kocok Rekomendasi Dadu (*Mystery Pick*):** Fitur interaktif berbasis Alpine.js untuk memilihkan rekomendasi bacaan atau permainan meja secara acak dari koleksi yang tersedia.

* **Kartu Anggota & Dompet Deposit:** Sistem registrasi/login warga dengan nomor identitas anggota (`#RT-xxx`), saldo dompet terintegrasi, dan penahanan uang jaminan (*deposit*) otomatis selama masa peminjaman.

* **Serah Terima Berbasis OTP & Checklist Kelengkapan:** Pembuatan kode OTP serah terima dan pencatatan kelengkapan komponen (seperti jumlah dadu, kartu, maupun kondisi sampul buku).

* **Manajemen Rak Koleksiku:** Warga dapat menitipkan koleksi pribadi untuk disewakan, mengatur tarif sewa harian, nominal deposit, serta rincian kelengkapan barang.

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel 13 (PHP 8.4)

* **Frontend & Interaktivitas:** Livewire v3, Alpine.js, Tailwind CSS

* **Database:** MySQL (Laragon)

* **Estetika Desain:** *Tactile Analog Paper* & *Neighborhood Library Card*

## 🚀 Cara Menjalankan Proyek Secara Lokal

1. **Clone repository ini:**

   ```
   git clone https://github.com/husnieez/raktetangga-app.git
   cd raktetangga-app
   
   ```

2. **Install dependensi PHP:**

   ```
   composer install
   
   ```

3. **Salin file konfigurasi `.env` dan buat *application key*:**

   ```
   cp .env.example .env
   php artisan key:generate
   
   ```

4. **Konfigurasi Database di file `.env`:**
   Sesuaikan pengaturan koneksi MySQL lokal (contoh menggunakan Laragon):

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=raktetangga
   DB_USERNAME=root
   DB_PASSWORD=
   
   ```

5. **Jalankan migrasi tabel dan *seeder* data awal:**

   ```
   php artisan migrate --seed
   
   ```

6. **Jalankan server pengembangan Laravel:**

   ```
   php artisan serve
   
   ```

   Buka browser dan akses `http://127.0.0.1:8000`.

## 👤 Akun Demo Warga (Hasil Seeder)

| Nama Warga | Email | No. WhatsApp | Password | 
| ----- | ----- | ----- | ----- | 
| Mas Dimas | `dimas@raktetangga.test` | `081234567801` | `password` | 
| Mbak Sari | `sari@raktetangga.test` | `081234567802` | `password` | 
| Pak Budi | `budi@raktetangga.test` | `081234567803` | `password` | 

© 2026 **RakTetangga** — Dibangun untuk Proyek Mata Kuliah Pemrograman Framework.