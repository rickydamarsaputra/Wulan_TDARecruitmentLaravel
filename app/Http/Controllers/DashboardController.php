<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Member;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role != 'member') {
            return view('pages.dashboard.index');
        } else {
            $member = Member::find($user->ID_member);
            $lowongan = Lowongan::whereIdMember($member->ID_member)->whereStatusAktif(1)->count();
            $pelamar = Pelamar::whereIdMember($member->ID_member)->count();

            return view('pages.dashboard.index', [
                'countLowonganAktif' => $lowongan,
                'countPelamar' => $pelamar,
            ]);
        }
    }
}
