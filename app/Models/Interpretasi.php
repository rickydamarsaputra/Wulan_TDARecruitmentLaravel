<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interpretasi extends Model
{
    use HasFactory;
    protected $table = "interpretasi";
    protected $primaryKey = "ID_interpretasi";
    protected $guarded = ["ID_interpretasi"];
}
