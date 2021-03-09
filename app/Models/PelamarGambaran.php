<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarGambaran extends Model
{
    use HasFactory;
    protected $table = "pelamar_gambaran";
    protected $primaryKey = "ID_pelamar_gambaran";
    protected $guarded = ["ID_pelamar_gambaran"];
}
