<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestIQ extends Model
{
    use HasFactory;
    protected $table = 'tes_iq';
    protected $primaryKey = "ID_tiq";
    protected $fillable = ['ID_pelamar', 'mulai_tes', 'lama_mengerjakan'];
}
