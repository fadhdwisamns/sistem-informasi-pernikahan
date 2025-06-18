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
             $table->foreignId('kua_id')
                  ->nullable()
                  ->after('role') 
                  ->constrained('master_kua')
                  ->onDelete('set null');

            
            $table->foreignId('pa_id')
                  ->nullable()
                  ->after('kua_id') 
                  ->constrained('master_pa')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kua_id']);
            $table->dropForeign(['pa_id']);

            $table->dropColumn('kua_id');
            $table->dropColumn('pa_id');
        });
    }
};
