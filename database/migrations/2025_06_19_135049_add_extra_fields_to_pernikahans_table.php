<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // database/migrations/xxxx_xx_xx_xxxxxx_add_extra_fields_to_pernikahans_table.php

    public function up(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            
            $table->date('tanggal_daftar')->nullable()->after('id');
            $table->integer('usia_suami')->nullable()->after('tanggal_lahir_suami');
            $table->integer('usia_istri')->nullable()->after('tanggal_lahir_istri');
            $table->text('alamat_pasangan')->nullable()->after('tanggal_lahir_istri');
            $table->string('desa')->nullable()->after('alamat_pasangan');
            $table->string('tempat_akad')->nullable()->after('desa');
            $table->string('wali')->nullable()->after('tempat_akad');
            $table->string('nama_wali')->nullable()->after('wali');
        });
    }

    public function down(): void
    {
        Schema::table('pernikahans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_daftar', 'usia_suami', 'usia_istri', 'alamat_pasangan', 'desa', 'tempat_akad', 'wali', 'nama_wali']);
        });
    }
};
