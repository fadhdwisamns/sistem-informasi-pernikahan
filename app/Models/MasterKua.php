<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKua extends Model
{
    use HasFactory;

    protected $table = 'master_kua';

    protected $fillable = ['nama_kua', 'alamat'];
}
