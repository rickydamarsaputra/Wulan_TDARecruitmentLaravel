<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengalamanKerja extends Model
{
    use HasFactory;
    protected $table = "pengalaman_kerja";
    protected $primaryKey = "ID_pengalaman_krj";
    protected $guarded = ["ID_pengalaman_krj"];
}
