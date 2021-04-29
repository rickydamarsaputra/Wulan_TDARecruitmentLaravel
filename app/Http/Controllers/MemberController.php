<?php

namespace App\Http\Controllers;

use App\Exports\MembersExport;
use App\Models\Member;
use App\Models\User;
use PDF;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class MemberController extends Controller
{
    public function index()
    {
        return view('pages.member.index');
    }

    public function detail($namaMember)
    {
        $member = Member::whereNamaMember($namaMember)->firstOrFail();
        return view('pages.member.detail', [
            'member' => $member,
        ]);
    }

    public function updateMember(Request $request, $member)
    {
        $currentMember = Member::whereNamaMember($member)->first();
        $currentMember->update([
            'kode_member' => $request->kode_member,
            'nomor_member' => $request->nomor_member,
            'nama_member' => $request->nama_member,
            'nama_bisnis' => $request->nama_bisnis,
        ]);

        Alert::success('Update!', 'Berhasil Dilakuan.');
        return redirect()->back();
    }

    public function changeStatus($member, $status)
    {
        $currentMember = Member::findOrfail($member);
        $user = User::whereIdMember($member)->first();
        $statusMember = $status == "terima" ? 1 : 0;
        // $statusMember = $status == 'terima' ? 1 : 2;
        // $statusUser = $status == 'terima' ? 1 : 0;

        $currentMember->update([
            'status_aktivasi' => $statusMember,
        ]);
        $user->update([
            'status' => $statusMember,
        ]);

        return redirect()->back();
    }

    public function exportPDF()
    {
        $member = Member::get(['ID_member', 'nama_member', 'nomor_member', 'nama_bisnis', 'kode_member']);

        $pdf = PDF::loadView('pages.member.export-pdf', [
            'member' => $member,
        ]);
        return $pdf->stream();
    }

    public function exportEXCEL()
    {
        $date = date_format(Date::now(), 'dmy');
        $exportName = "export-excel-members-$date.xlsx";
        return Excel::download(new MembersExport, $exportName);
    }

    public function datatables()
    {
        $model = Member::select("member.*");
        return DataTables::of($model)
            ->addIndexColumn()
            ->toJson();
    }
}
