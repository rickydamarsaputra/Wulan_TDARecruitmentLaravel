<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interpretasi;

class PelamarSummary extends Model
{
    use HasFactory;
    protected $table = "pelamar_summary";
    protected $primaryKey = "ID_pelamar_summary";
    protected $guarded = ["ID_pelamar_summary"];

    public function interpretasi()
    {
        return $this->hasOne(Interpretasi::class, 'ID_interpretasi', 'ID_interpretasi');
    }
}
