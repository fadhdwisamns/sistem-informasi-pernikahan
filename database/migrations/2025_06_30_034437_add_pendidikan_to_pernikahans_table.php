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
        // Gunakan Schema::table untuk mengubah tabel yang sudah ada
        Schema::table('pernikahans', function (Blueprint $table) {
            // Menambahkan kolom pendidikan_terakhir_suami setelah kolom usia_suami
            $table->string('pendidikan_terakhir_suami', 255)->nullable()->after('usia_suami');
            
            // Menambahkan kolom pendidikan_terakhir_istri setelah kolom usia_istri
            $table->string('pendidikan_terakhir_istri', 255)->nullable()->after('usia_istri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['pendidikan_terakhir_suami', 'pendidikan_terakhir_istri']);
        });
    }
};