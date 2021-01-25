<?php

namespace App\Http\Controllers;

use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelamarController extends Controller
{
    public function detail($kodePelamar)
    {
        $pelamar = Pelamar::whereKodePelamar($kodePelamar)->firstOrFail();

        return view('pages.pelamar.detail', [
            'pelamar' => $pelamar,
        ]);
    }

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

    public function dowloadFilePelamar($tipe, $kodePelamar)
    {
        $pelamar = Pelamar::whereKodePelamar($kodePelamar)->firstOrFail();
        $downloadFile = ($tipe == 'ktp') ? $pelamar->ktp : (($tipe == 'sim') ? $pelamar->sim : (($tipe == 'document') ? $pelamar->document_lain : false));
        return Storage::download($downloadFile);
    }
}
