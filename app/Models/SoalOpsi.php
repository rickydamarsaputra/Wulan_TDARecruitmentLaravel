<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalOpsi extends Model
{
    use HasFactory;
    protected $table = 'tes_iq_opsi';
    protected $primaryKey = "ID_tiq_opsi";
    protected $fillable = ['ID_tiq_soal', 'desc_opsi'];
}
