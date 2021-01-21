<?php

namespace App\Http\Controllers;

use App\Models\Pelamar;
use Illuminate\Http\Request;

class PelamarController extends Controller
{
    public function changeStatus($idPelamar)
    {
        $pelamar = Pelamar::findOrfail($idPelamar);
        if ($pelamar->status == 0) {
            $pelamar->update([
                'status' => 1,
            ]);
        } else if ($pelamar->status == 1) {
            $pelamar->update([
                'status' => 2,
            ]);
        }

        return redirect()->back();
    }
}
