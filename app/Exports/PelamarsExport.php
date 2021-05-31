<?php

namespace App\Exports;

use App\Pelamar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PelamarsExport implements FromView
{
    public $member;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($member)
    {
        $this->member = $member;
    }

    public function view(): View
    {
        return view('pages.member.export-excel-pelamar', [
            'member' => $this->member,
        ]);
    }
}
