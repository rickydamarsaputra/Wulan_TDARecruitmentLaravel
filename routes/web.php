<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ToolController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login.view');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login.view');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'registerView'])->name('register.view');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.user');
    Route::get('/register/admin', function () {
        $admin = User::create([
            'ID_member' => null,
            'role' => 'admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'retrocode.rc@gmail.com',
            'status' => 1
        ]);

        return redirect('/');
    });
});

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashoard.index');

    Route::prefix('member')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('member.index');
        Route::get('/detail/{namaMember}', [MemberController::class, 'detail'])->name('member.detail');
        Route::put('/change/status/{member}/{status}', [MemberController::class, 'changeStatus'])->name('member.change.status');
    });

    Route::prefix('lowongan')->group(function () {
        Route::get('/', [LowonganController::class, 'index'])->name('lowongan.index');
        Route::view('/create', 'pages.lowongan.create')->name('lowongan.create.view');
        Route::post('/create', [LowonganController::class, 'create'])->name('lowongan.create.process');
        Route::put('/update/{idLowongan}', [LowonganController::class, 'update'])->name('lowongan.update');
        Route::get('/detail/{idLowongan}', [LowonganController::class, 'detail'])->name('lowongan.detail');
        Route::put('/change/status/{lowongan}/{status}', [LowonganController::class, 'changeStatus'])->name('lowongan.change.status');
    });

    Route::prefix('pelamar')->group(function () {
        Route::put('/change/status/{idPelamar}', [PelamarController::class, 'changeStatus'])->name('pelamar.change.status');
        Route::get('/{kodePelamar}', [PelamarController::class, 'detail'])->name('pelamar.detail');
        Route::get('/download/{tipe}/{kodePelamar}', [PelamarController::class, 'dowloadFilePelamar'])->name('pelamar.download.file');
    });
});

Route::prefix('perusahaan')->group(function () {
    Route::get('/{kodeMember}', [PerusahaanController::class, 'PerusahaanPelamarFormView'])->name('perusahaan.pelamar.view');
    Route::post('/{kodeMember}', [PerusahaanController::class, 'PerusahaanPelamarFormProcess'])->name('perusahaan.pelamar.process');

    Route::get('/result/{kodePelamar}', [PerusahaanController::class, 'perusahaanPelamarResultPage'])->name('perusahaan.pelamar.result.page.view');
});

Route::get('mail-test', [MailController::class, 'test']);

Route::prefix('helpers')->group(function () {
    Route::prefix('generate')->group(function () {
        Route::get('/slug/{slug}', [ToolController::class, 'generateSlug'])->name('helpers.generate.slug');
        Route::get('/password', [ToolController::class, 'generatePassword'])->name('helpers.generate.password');
    });
    Route::get('/find/lowongan/{idLowongan}', [ToolController::class, 'findLowongan'])->name('helpers.find.lowongan');
});

Route::prefix('datatables')->group(function () {
    Route::get('/member', [MemberController::class, 'datatables'])->name('datatables.member');
    Route::get('/lowongan', [LowonganController::class, 'datatables'])->name('datatables.lowongan');
    Route::get('/pelamar/lowongan/{idLowongan}', [LowonganController::class, 'datatablesPelamarLowongan'])->name('datatables.pelamar.lowongan');
});
