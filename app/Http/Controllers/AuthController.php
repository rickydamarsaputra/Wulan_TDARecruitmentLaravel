<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\User;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('pages.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::whereUsername($request->username)->first();

        if (Auth::attempt($request->only(['username', 'password']))) {
            if ($user->status) {
                return redirect()->route('dashoard.index');
            }
        }

        return redirect()->back();
    }

    public function registerView()
    {
        return view('pages.auth.register');
    }

    public function registerProcess(Request $request)
    {
        $this->validate($request, [
            'nama_member' => 'required',
            'nomor_member' => 'required',
            'nama_bisnis' => 'required',
            'kode_member' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $member = Member::create([
            'kode_member' => $request->kode_member,
            'nomor_member' => $request->nomor_member,
            'nama_member' => $request->nama_member,
            'nama_bisnis' => $request->nama_bisnis,
            'status_aktivasi' => 0,
        ]);

        $user = User::create([
            'ID_member' => $member->ID_member,
            'role' => 'member',
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'status' => 0,
        ]);
        return redirect()->route('login.view');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
