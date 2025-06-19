<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Pernikahan extends Model
{
    use HasFactory;
     protected $fillable = [
        'kua_id',
        'jenis_data',
        'no_akta',
        'tanggal_akad',
        'nama_suami',
        'nik_suami',
        'tempat_lahir_suami',
        'tanggal_lahir_suami',
        'nama_istri',
        'nik_istri',
        'tempat_lahir_istri',
        'tanggal_lahir_istri',
        'status_verifikasi', 
        'created_by',
        'catatan_verifikasi',
        'verified_by',
        'tanggal_daftar',
        'usia_suami',
        'usia_istri',
        'alamat_pasangan',
        'desa',
        'tempat_akad',
        'wali',
        'nama_wali',
    ];

      public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
     protected static function boot()
    {
        parent::boot();

       
        static::creating(function ($pernikahan) {
            
            
            $tanggalAkad = Carbon::parse($pernikahan->tanggal_akad);
            // $tanggalAkad = \Carbon\Carbon::createFromFormat('d/m/Y', $pernikahan->tanggal_akad);
            $bulanRomawi = self::getRomanMonth($tanggalAkad->month);
            $tahun = $tanggalAkad->year;
            
            
            $kodeKua = str_pad($pernikahan->kua_id, 2, '0', STR_PAD_LEFT);

           
            $urutan = Pernikahan::where('kua_id', $pernikahan->kua_id)
                                ->whereYear('tanggal_akad', $tahun)
                                ->whereMonth('tanggal_akad', $tanggalAkad->month)
                                ->count() + 1;
            
            $nomorUrut = str_pad($urutan, 3, '0', STR_PAD_LEFT);

            $pernikahan->no_akta = "K.{$kodeKua}/PN/{$bulanRomawi}/{$tahun}/{$nomorUrut}";
        });
    }

    // Helper function untuk mengubah angka bulan menjadi Romawi
    private static function getRomanMonth($month)
    {
        $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $romans[$month - 1];
    }
    public function kua(): BelongsTo
    {
        
        return $this->belongsTo(MasterKua::class, 'kua_id');
    }

   
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
     public function files()
    {
        return $this->hasMany(PernikahanFile::class);
    }

    public function images()
    {
        return $this->hasMany(PernikahanImage::class);
    }
}
