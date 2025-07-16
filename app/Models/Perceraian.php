<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perceraian extends Model
{
    use HasFactory;
     protected $fillable = [
        'pa_id',
        'no_putusan', 
        'tanggal_putusan',
        'nama_penggugat',
        'nama_tergugat',
        'status_verifikasi',
        'catatan_verifikasi',
        'verified_by',
        'created_by',
        'jenis_cerai',
        'kua_id',
        'nik_penggugat',
        'nik_tergugat',
    ];

   
    public function masterPa()
    {
        return $this->belongsTo(MasterPA::class, 'pa_id'); 
    }

    
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($perceraian) {
            
            if (!empty($perceraian->no_putusan)) {
                return;
            }

            $latestPerceraian = static::latest()->first(); 

            // Format nomor putusan: Contoh "PTSN/TAHUN/XXXX" (Putusan)
            $prefix = 'PTSN/';
            $year = date('Y');
            $number = 1;

            if ($latestPerceraian) {
                $lastNo = $latestPerceraian->no_putusan;
                $parts = explode('/', $lastNo);
                
                if (count($parts) === 3 && $parts[1] === $year && is_numeric($parts[2])) {
                    $number = (int)$parts[2] + 1;
                } else {
                   
                    $number = 1;
                }
            }

            $formattedNumber = str_pad($number, 4, '0', STR_PAD_LEFT); // 4 digit angka
            $perceraian->no_putusan = $prefix . $year . '/' . $formattedNumber;

            
            if (auth()->check() && empty($perceraian->created_by)) {
                $perceraian->created_by = auth()->id();
            }
        });

      
        static::updating(function ($perceraian) {
            
            if ($perceraian->isDirty('status_verifikasi') && in_array($perceraian->status_verifikasi, ['disetujui', 'ditolak'])) {
                if (auth()->check()) {
                    $perceraian->verified_by = auth()->id();
                }
            }
        });
    }
}
