<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Rujuk extends Model
{
    use HasFactory;

     protected $fillable = [
        'no_surat_rujuk',
        'tanggal_rujuk',
        'nama_suami',
        'nik_suami',
        'nama_istri',
        'nik_istri',
        'tempat_rujuk',
        'status',
        'catatan_verifikasi', 
        'verified_by',
        'desa', // <-- TAMBAHKAN INI
        'file_akta_cerai',

    ];

     public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

     protected static function boot()
    {
        parent::boot();

        
        static::creating(function ($rujuk) {
           
            $latestRujuk = static::latest()->first(); 

            // Format nomor surat: Contoh "SRJ/TAHUN/XXXX"
            $prefix = 'SRJ/';
            $year = date('Y');
            $number = 1;

            if ($latestRujuk) {
                
                $lastNo = $latestRujuk->no_surat_rujuk;
                $parts = explode('/', $lastNo); // Pisahkan berdasarkan '/'

              
                if (count($parts) === 3 && $parts[1] === $year && is_numeric($parts[2])) {
                    $number = (int)$parts[2] + 1;
                } else {
                    
                    $number = 1;
                }
            }

            $formattedNumber = str_pad($number, 4, '0', STR_PAD_LEFT); // 4 digit angka

            $rujuk->no_surat_rujuk = $prefix . $year . '/' . $formattedNumber;

            
        });
        static::updating(function ($rujuk) {
            // Hanya isi verified_by jika status berubah dan statusnya sudah disetujui/ditolak
            if ($rujuk->isDirty('status') && in_array($rujuk->status, ['Disetujui', 'Ditolak'])) {
                if (Auth::check()) {
                    $rujuk->verified_by = Auth::id();
                }
            }
        });
    }
}
