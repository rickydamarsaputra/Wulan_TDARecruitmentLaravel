<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambaran extends Model
{
    use HasFactory;
    protected $table = "gambaran";
    protected $primaryKey = "ID_gambaran";
    protected $guarded = ["ID_gambaran"];
}
