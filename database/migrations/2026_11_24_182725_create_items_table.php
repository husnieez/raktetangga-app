<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pemilik barang
            $table->string('code')->unique(); // Contoh: BG-014, BK-108
            $table->enum('type', ['boardgame', 'book', 'comic']);
            $table->string('title');
            $table->string('author_or_genre'); // Pengarang buku atau genre board game
            $table->string('meta_info')->nullable(); // Contoh: "3-4 Pemain • 60-90 Mnt" atau "508 Hlm"
            $table->text('pieces')->nullable(); // Daftar komponen board game
            $table->unsignedInteger('daily_rate'); // Tarif per hari
            $table->unsignedInteger('deposit'); // Nominal jaminan
            $table->string('location'); // Contoh: "Blok C-12"
            $table->unsignedInteger('distance')->default(250); // Jarak dalam meter
            $table->enum('status', ['TERSEDIA', 'DIPINJAM', 'ANTRIAN'])->default('TERSEDIA');
            $table->string('cover_color')->default('#E09F3E');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
