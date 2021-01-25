<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengalamanOrganisasi extends Model
{
    use HasFactory;
    protected $table = "pengalaman_organisasi";
    protected $primaryKey = "ID_pengalaman_orgn";
    protected $guarded = ["ID_pengalaman_orgn"];
}
