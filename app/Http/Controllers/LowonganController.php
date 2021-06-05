<?php

namespace App\Http\Controllers;

use App\Exports\LowongansExport;
use App\Exports\PelamarsExport;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PDF;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class LowonganController extends Controller
{
    public function index()
    {
        return view('pages.lowongan.index');
    }

    public function createView()
    {
        // $member = User::where('role', '!=', 'admin')->get();
        $member = Member::whereStatusAktivasi(1)->get(['ID_member', 'nama_member']);

        return view('pages.lowongan.create', [
            'member' => $member,
        ]);
    }

    public function createProcess(Request $request)
    {
        $user = Auth::user();
        $idMember = $user->role != 'admin' ? $user->ID_member : $request->member;

        if ($user->role == 'admin') {
            $this->validate($request, [
                'nama_lowongan' => 'required',
                'member' => 'required'
            ]);
        }
        $this->validate($request, [
            'nama_lowongan' => 'required'
        ]);
        $defaultMessage = 'Selamat! Data Anda telah terkirim ke perusahaan [namaPerusahaan]. Silakan tunggu info lebih lanjut langsung oleh [namaPerusahaan].';

        $lowongan = Lowongan::create([
            'ID_member' => $idMember,
            'label' => $request->nama_lowongan,
            'custom_message' => empty($request->custom_message) ? $defaultMessage : nl2br($request->custom_message),
            'status_aktif' => 0
        ]);
        return redirect()->route('lowongan.index');
    }

    public function update($idLowongan, Request $request)
    {
        $lowongan = Lowongan::findOrfail($idLowongan);
        $defaultMessage = 'Selamat! Data Anda telah terkirim ke perusahaan [namaPerusahaan]. Silakan tunggu info lebih lanjut langsung oleh [namaPerusahaan].';
        $lowongan->update([
            'label' => $request->nama_lowongan,
            'custom_message' => empty($request->custom_message) ? $defaultMessage : nl2br($request->custom_message),
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

    public function exportPDF()
    {
        $user = Auth::user();
        $lowongan = $user->role == 'admin' ? Lowongan::get(['ID_lowongan', 'ID_member', 'label', 'created_at', 'status_aktif']) : Lowongan::whereIdMember($user->ID_member)->get(['ID_lowongan', 'ID_member', 'label', 'created_at', 'status_aktif']);

        $pdf = PDF::loadView('pages.lowongan.export-pdf', [
            'lowongan' => $lowongan,
            'user' => $user,
        ]);
        return $pdf->stream();
    }

    public function exportEXCEL()
    {
        $user = Auth::user();
        $date = date_format(Date::now(), 'dmy');
        $fileName = $user->role == 'admin' ? 'export-excel' : Str::slug($user->member->nama_bisnis);
        $exportName = "$fileName-lowongan-$date.xlsx";

        return Excel::download(new LowongansExport, $exportName);
    }

    public function pelamarExportExcel($idLowongan)
    {
        $lowongan = Lowongan::whereIdLowongan($idLowongan)->first();
        $namaLowongan = Str::slug($lowongan->label);
        $date = date_format(Date::now(), 'dmy');
        $exportName = "$namaLowongan-pelamar-$date.xlsx";

        return Excel::download(new PelamarsExport($lowongan), $exportName);
    }

    public function datatables()
    {
        $user = Auth::user();
        $model = $user->role == 'admin' ? Lowongan::with(["member"]) : Lowongan::whereIdMember($user->member->ID_member);

        return DataTables::of($model->get(["ID_lowongan", "label", "ID_member", "created_at", "status_aktif"]))
            ->addIndexColumn()
            ->addColumn('lowongan', function ($lowongan) {
                return $lowongan;
            })
            ->addColumn('member_nama_and_id', function ($lowongan) {
                return [$lowongan->member->nama_member, $lowongan->member->ID_member];
            })
            ->toJson();
    }
}
