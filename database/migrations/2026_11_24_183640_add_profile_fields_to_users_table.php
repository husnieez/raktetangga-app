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
        Schema::table('users', function (Blueprint $table) {
            $table->string('member_code')->unique()->nullable()->after('id');
            $table->string('phone')->unique()->nullable()->after('email');
            $table->string('block')->default('Blok C')->after('phone');
            $table->string('role')->default('keduanya')->after('block');
            $table->unsignedBigInteger('balance')->default(125000)->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
