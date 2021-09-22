<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestIQItem extends Model
{
    use HasFactory;
    protected $table = 'tes_iq_item';
    protected $primaryKey = "ID_tiq_item";
    protected $fillable = ['ID_tiq', 'ID_tiq_soal', 'nomor', 'jawaban', 'poin'];
}
