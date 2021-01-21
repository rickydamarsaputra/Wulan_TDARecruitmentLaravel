<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class Lowongan extends Model
{
    use HasFactory;
    protected $table = "lowongan";
    protected $primaryKey = "ID_lowongan";
    protected $guarded = ["ID_lowongan"];

    public function member()
    {
        return $this->hasOne(Member::class, "ID_member", "ID_member");
    }

    public function pelamar()
    {
        return $this->hasMany(Pelamar::class, "ID_lowongan", "ID_lowongan");
    }
}
