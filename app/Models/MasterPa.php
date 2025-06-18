<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPa extends Model
{
    use HasFactory;

    protected $table = 'master_pa';
    protected $fillable = ['nama_pa', 'alamat'];

    public function perceraians()
    {
        return $this->hasMany(Perceraian::class, 'pa_id');
    }
}
