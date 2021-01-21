<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Auth;
use DataTables;

class LowonganController extends Controller
{
    public function index()
    {
        return view('pages.lowongan.index');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nama_lowongan' => 'required'
        ]);

        $lowongan = Lowongan::create([
            'ID_member' => Auth::user()->ID_member,
            'label' => $request->nama_lowongan,
            'status_aktif' => 0
        ]);
        return redirect()->route('lowongan.index');
    }

    public function update($idLowongan, Request $request)
    {
        $lowongan = Lowongan::findOrfail($idLowongan);
        $lowongan->update([
            'label' => $request->nama_lowongan,
        ]);

        return redirect()->back();
    }

    public function detail($idLowongan)
    {
        $lowongan = Lowongan::findOrfail($idLowongan);
        return view('pages.lowongan.detail', [
            'lowongan' => $lowongan
        ]);
    }

    public function changeStatus($lowongan, $status)
    {
        $currentLowongan = Lowongan::findOrfail($lowongan);
        $statusLowongan = $status == "terima" ? 1 : 0;

        $currentLowongan->update([
            'status_aktif' => $statusLowongan
        ]);
        return redirect()->back();
    }

    public function datatablesPelamarLowongan($idLowongan)
    {
        $model = Lowongan::findOrfail($idLowongan);
        return DataTables::of($model->pelamar)
            ->addIndexColumn()
            ->addColumn('pelamar', function ($pelamar) {
                return $pelamar;
            })
            ->toJson();
    }

    public function datatables()
    {
        $model = Lowongan::with(["member"])->get(["ID_lowongan", "label", "ID_member", "created_at", "status_aktif"]);
        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('lowongan', function ($lowongan) {
                return $lowongan;
            })
            ->toJson();
    }
}
