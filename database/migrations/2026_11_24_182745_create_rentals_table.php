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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('borrower_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('days');
            $table->date('due_date');
            $table->unsignedInteger('total_rental_fee');
            $table->unsignedInteger('deposit_held');
            $table->string('handover_location');
            $table->string('handover_otp', 10);
            $table->text('note')->nullable();
            $table->enum('status', ['MENUNGGU', 'SIAP_DIAMBIL', 'DIPINJAM', 'SELESAI'])->default('SIAP_DIAMBIL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
