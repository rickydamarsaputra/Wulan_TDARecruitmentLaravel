<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $table = 'tes_iq_soal';
    protected $primaryKey = "ID_tiq_soal";
    protected $fillable = ['desc_soal', 'jawaban_benar', 'poin_benar'];

    public function opsi()
    {
        return $this->hasMany(SoalOpsi::class, 'ID_tiq_soal', 'ID_tiq_soal');
    }
}
