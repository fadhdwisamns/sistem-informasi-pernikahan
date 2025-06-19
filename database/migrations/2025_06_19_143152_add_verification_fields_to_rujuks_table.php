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
        Schema::table('rujuks', function (Blueprint $table) {
          
            $table->string('status_verifikasi')->default('pending')->after('tanggal_rujuk');
            $table->timestamp('tanggal_verifikasi')->nullable()->after('status_verifikasi');
            $table->text('catatan_verifikasi')->nullable()->after('tanggal_verifikasi');

            if (!Schema::hasColumn('rujuks', 'kua_id')) {
                $table->foreignId('kua_id')->after('id')->constrained('master_kua')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rujuks', function (Blueprint $table) {
            
            if (Schema::hasColumn('rujuks', 'kua_id')) {
                $table->dropForeign(['kua_id']);
                $table->dropColumn('kua_id');
            }
            
            // Hapus kolom verifikasi
            $table->dropColumn(['status_verifikasi', 'tanggal_verifikasi', 'catatan_verifikasi']);
        });
    }
};