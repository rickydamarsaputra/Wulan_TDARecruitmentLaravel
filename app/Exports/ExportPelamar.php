<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportPelamar implements FromView
{
    public $pelamar;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($pelamar)
    {
        $this->pelamar = $pelamar;
    }
    public function view(): View
    {
        return view('pages.pelamar.export-excel', [
            'pelamar' => $this->pelamar,
        ]);
    }
}
