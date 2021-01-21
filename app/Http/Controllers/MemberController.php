<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

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

    public function changeStatus($member, $status)
    {
        $currentMember = Member::findOrfail($member);
        $user = User::whereIdMember($member)->first();
        $statusMember = $status == 'terima' ? 1 : 2;
        $statusUser = $status == 'terima' ? 1 : 0;

        $currentMember->update([
            'status_aktivasi' => $statusMember,
        ]);
        $user->update([
            'status' => $statusUser,
        ]);

        return redirect()->route('member.index');
    }

    public function datatables()
    {
        $model = Member::select("member.*");
        return DataTables::of($model)
            ->addIndexColumn()
            ->toJson();
    }
}
