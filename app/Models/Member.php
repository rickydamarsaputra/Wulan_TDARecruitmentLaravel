<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lowongan;
use App\Models\User;

class Member extends Model
{
    use HasFactory;
    protected $table = 'member';
    protected $primaryKey = 'ID_member';
    protected $guarded = ['ID_member'];

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'ID_member', 'ID_member');
    }

    public function pelamar()
    {
        return $this->hasMany(Pelamar::class, 'ID_member', 'ID_member');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'ID_member', 'ID_member');
    }
}
