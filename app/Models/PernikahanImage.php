<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PernikahanImage extends Model
{
    use HasFactory;
    protected $fillable = ['pernikahan_id', 'image_path', 'original_name'];
    public function pernikahan() { return $this->belongsTo(Pernikahan::class); }
}
