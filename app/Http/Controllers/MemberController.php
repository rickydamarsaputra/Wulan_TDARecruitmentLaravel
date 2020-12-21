<?php

namespace App\Http\Controllers;

use App\Models\Member;
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

    public function datatables()
    {
        $model = Member::select("member.*");
        return DataTables::of($model)
            ->addIndexColumn()
            ->addColumn('intro', 'Hi Hello!')
            ->toJson();
    }
}
