<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa akun warga pemilik koleksi
        $dimas = User::firstOrCreate(
            ['email' => 'dimas@raktetangga.test'],
            [
                'member_code' => '#RT-014',
                'name' => 'Mas Dimas',
                'phone' => '081234567801',
                'block' => 'Blok C-12',
                'role' => 'keduanya',
                'balance' => 150000,
                'password' => bcrypt('password'),
            ]
        );

        $sari = User::firstOrCreate(
            ['email' => 'sari@raktetangga.test'],
            [
                'member_code' => '#RT-027',
                'name' => 'Mbak Sari',
                'phone' => '081234567802',
                'block' => 'Blok B-08',
                'role' => 'pemilik',
                'balance' => 125000,
                'password' => bcrypt('password'),
            ]
        );

        $budi = User::firstOrCreate(
            ['email' => 'budi@raktetangga.test'],
            [
                'member_code' => '#RT-039',
                'name' => 'Pak Budi',
                'phone' => '081234567803',
                'block' => 'Blok A-04',
                'role' => 'keduanya',
                'balance' => 200000,
                'password' => bcrypt('password'),
            ]
        );

        $dummyItems = [
            [
                'user_id' => $dimas->id,
                'code' => 'BG-014',
                'type' => 'boardgame',
                'title' => 'Catan: Edisi Bahasa',
                'author_or_genre' => 'Strategi & Koloni',
                'meta_info' => '3-4 Pemain • 60-90 Mnt',
                'pieces' => '96 Kartu, 16 Kota, 2 Dadu Kayu, 1 Papan Hexagon',
                'daily_rate' => 15000,
                'deposit' => 50000,
                'location' => 'Blok C-12 • 250m',
                'distance' => 250,
                'status' => 'TERSEDIA',
                'cover_color' => '#E09F3E',
            ],
            [
                'user_id' => $sari->id,
                'code' => 'BK-108',
                'type' => 'book',
                'title' => 'Cantik Itu Luka',
                'author_or_genre' => 'Eka Kurniawan',
                'meta_info' => '508 Hlm',
                'pieces' => 'Novel fisik sampul lunak + pembatas buku',
                'daily_rate' => 3000,
                'deposit' => 20000,
                'location' => 'Blok B-08 • 180m',
                'distance' => 180,
                'status' => 'TERSEDIA',
                'cover_color' => '#FFFDF9',
            ],
            [
                'user_id' => $dimas->id,
                'code' => 'BG-021',
                'type' => 'boardgame',
                'title' => 'Ticket to Ride: Europe',
                'author_or_genre' => 'Keluarga & Rute Kereta',
                'meta_info' => '2-5 Pemain • 45-60 Mnt',
                'pieces' => '1 Peta Eropa, 240 Kereta Mini, 158 Kartu, 5 Penanda Skor',
                'daily_rate' => 18000,
                'deposit' => 60000,
                'location' => 'Blok C-12 • 250m',
                'distance' => 250,
                'status' => 'TERSEDIA',
                'cover_color' => '#3A6B56',
            ],
            [
                'user_id' => $budi->id,
                'code' => 'KM-005',
                'type' => 'comic',
                'title' => 'Doraemon Petualangan Vol. 1-5',
                'author_or_genre' => 'Fujiko F. Fujio',
                'meta_info' => '5 Jilid Lengkap',
                'pieces' => 'Paket 5 buku komik edisi cetak ulang',
                'daily_rate' => 4000,
                'deposit' => 25000,
                'location' => 'Blok A-04 • 420m',
                'distance' => 420,
                'status' => 'TERSEDIA',
                'cover_color' => '#D95D39',
            ],
            [
                'user_id' => $sari->id,
                'code' => 'BK-112',
                'type' => 'book',
                'title' => 'Laut Bercerita',
                'author_or_genre' => 'Leila S. Chudori',
                'meta_info' => '379 Hlm',
                'pieces' => 'Buku fisik sampul bersampul plastik bening',
                'daily_rate' => 3500,
                'deposit' => 20000,
                'location' => 'Blok B-08 • 180m',
                'distance' => 180,
                'status' => 'TERSEDIA',
                'cover_color' => '#EFE7D8',
            ],
            [
                'user_id' => $budi->id,
                'code' => 'BG-033',
                'type' => 'boardgame',
                'title' => 'Monopoly Deal: Edisi Kartu',
                'author_or_genre' => 'Pesta & Kartu Cepat',
                'meta_info' => '2-5 Pemain • 15-20 Mnt',
                'pieces' => '110 Kartu Aksi & Properti + Kotak Kaleng',
                'daily_rate' => 7000,
                'deposit' => 25000,
                'location' => 'Blok A-04 • 420m',
                'distance' => 420,
                'status' => 'DIPINJAM',
                'cover_color' => '#E09F3E',
            ],
            [
                'user_id' => $dimas->id,
                'code' => 'KM-019',
                'type' => 'comic',
                'title' => 'Detektif Conan Vol. 90-94',
                'author_or_genre' => 'Gosho Aoyama',
                'meta_info' => '5 Jilid Misteri',
                'pieces' => '5 buku komik kondisi terawat',
                'daily_rate' => 4500,
                'deposit' => 25000,
                'location' => 'Blok C-12 • 250m',
                'distance' => 250,
                'status' => 'TERSEDIA',
                'cover_color' => '#FFFDF9',
            ],
            [
                'user_id' => $sari->id,
                'code' => 'BK-125',
                'type' => 'book',
                'title' => 'Filosofi Teras',
                'author_or_genre' => 'Henry Manampiring',
                'meta_info' => '346 Hlm',
                'pieces' => 'Buku fisik asli cetakan Kompas',
                'daily_rate' => 3000,
                'deposit' => 15000,
                'location' => 'Blok B-08 • 180m',
                'distance' => 180,
                'status' => 'TERSEDIA',
                'cover_color' => '#EFE7D8',
            ],
        ];

        foreach ($dummyItems as $item) {
            Item::updateOrCreate(
                ['code' => $item['code']],
                $item
            );
        }
    }
}