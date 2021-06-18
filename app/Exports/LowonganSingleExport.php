<?php

namespace App\Exports;

use App\Models\Lowongan;
use App\Models\Pelamar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LowonganSingleExport implements FromView
{
    public $idLowongan;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($idLowongan)
    {
        $this->idLowongan = $idLowongan;
    }

    public function view(): View
    {
        $pelamar = Pelamar::whereIdLowongan($this->idLowongan)->get();
        return view('pages.lowongan.export-excel-pelamar', [
            'pelamar' => $pelamar,
        ]);
    }
}
