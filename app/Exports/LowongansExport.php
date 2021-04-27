<?php

namespace App\Exports;

use App\Models\Lowongan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class LowongansExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $user = Auth::user();
        $lowongan = $user->role == 'admin' ? Lowongan::all() : Lowongan::whereIdMember($user->ID_member)->get();

        return view('pages.lowongan.export-excel', [
            'lowongan' => $lowongan,
        ]);
    }
}
