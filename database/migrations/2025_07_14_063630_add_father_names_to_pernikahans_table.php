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
        Schema::table('pernikahans', function (Blueprint $table) {
            // Tambahkan kolom untuk nama ayah suami setelah kolom pendidikan suami
            $table->string('nama_ayah_suami')->nullable()->after('pendidikan_terakhir_suami');
            // Tambahkan kolom untuk nama ayah istri setelah kolom pendidikan istri
            $table->string('nama_ayah_istri')->nullable()->after('pendidikan_terakhir_istri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            $table->dropColumn(['nama_ayah_suami', 'nama_ayah_istri']);
        });
    }
};