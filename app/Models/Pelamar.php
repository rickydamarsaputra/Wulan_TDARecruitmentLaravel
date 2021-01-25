<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\Lowongan;
use App\Models\PendidikanPelamar;
use App\Models\PengalamanKerja;
use App\Models\PengalamanOrganisasi;

class Pelamar extends Model
{
    use HasFactory;
    protected $table = "pelamar";
    protected $primaryKey = "ID_pelamar";
    protected $guarded = ["ID_pelamar"];

    public function member()
    {
        return $this->hasOne(Member::class, 'ID_member', 'ID_member');
    }

    public function lowongan()
    {
        return $this->hasOne(Lowongan::class, 'ID_lowongan', 'ID_lowongan');
    }

    public function pendidikanPelamar()
    {
        return $this->hasMany(PendidikanPelamar::class, 'ID_pelamar', 'ID_pelamar');
    }

    public function pengalamanKerja()
    {
        return $this->hasMany(PengalamanKerja::class, 'ID_pelamar', 'ID_pelamar');
    }

    public function pengalamanOrganisasi()
    {
        return $this->hasMany(PengalamanOrganisasi::class, 'ID_pelamar', 'ID_pelamar');
    }
}
