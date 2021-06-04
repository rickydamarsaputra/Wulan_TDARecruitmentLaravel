<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

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
                if ($user->role == 'admin') {
                    return redirect()->route('dashoard.index');
                } else {
                    if ($user->member->status_aktivasi != 1) {
                        Alert::error($user->member->nama_member, 'Akun Anda Belum Di Aktivasi Oleh Admin!');
                        return redirect()->back();
                    }
                    return redirect()->route('lowongan.index');
                }
            }
        } else {
            Alert::error('Username / Password', 'Yang Anda Masukan Salah!');
            return redirect()->back();
        }
    }

    public function registerView()
    {
        return view('pages.auth.register');
    }

    public function registerProcess(Request $request)
    {
        $this->validate($request, [
            'nama_member' => 'required|unique:member,nama_member',
            'nomor_member' => 'required',
            'nama_bisnis' => 'required',
            'kode_member' => 'required',
            'email' => 'required|email',
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
            'email' => $request->email,
            'status' => 0,
        ]);
        return redirect()->route('member.index');
        // return redirect()->route('login.view');
    }

    public function profile()
    {
        return view('pages.auth.profile');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $currentUser = Auth::user();

        if (Hash::check($request->old_password, $currentUser->password)) {
            $currentUser->update([
                "password" => bcrypt($request->new_password)
            ]);
            Alert::success('Berhasil!', 'Password berhasil diubah.');
            return redirect()->back();
        } else {
            Alert::error('Password Lama', 'Yang Anda Masukkan Tidak Sesuai!');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
