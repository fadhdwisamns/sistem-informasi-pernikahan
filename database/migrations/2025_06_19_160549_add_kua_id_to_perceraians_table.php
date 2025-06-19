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
        Schema::table('perceraians', function (Blueprint $table) {
            // Tambahkan kolom kua_id setelah kolom 'id'
            // Kolom ini akan terhubung ke tabel master_kua
            $table->foreignId('kua_id')->after('id')->constrained('master_kua')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perceraians', function (Blueprint $table) {
            // Hapus relasi dan kolom jika migration di-rollback
            $table->dropForeign(['kua_id']);
            $table->dropColumn('kua_id');
        });
    }
};