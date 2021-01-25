<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanPelamar extends Model
{
    use HasFactory;
    protected $table = "pendidikan_pelamar";
    protected $primaryKey = "ID_pendidikan";
    protected $guarded = ["ID_pendidikan"];
}
