<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MembersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('pages.member.export-excel', [
            'members' => Member::all(),
        ]);
    }
}
