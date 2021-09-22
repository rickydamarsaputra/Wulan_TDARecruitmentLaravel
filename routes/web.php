<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IqTestController;
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
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.view');
    Route::post('/change/password', [AuthController::class, 'changePassword'])->name('change.password');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashoard.index');

    Route::prefix('member')->group(function () {
        Route::middleware('admin')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('member.index');
            Route::get('/register', [AuthController::class, 'registerView'])->name('member.register.view');
            Route::post('/register', [AuthController::class, 'registerProcess'])->name('member.register.process');
            Route::get('/detail/{id}', [MemberController::class, 'detail'])->name('member.detail');
            Route::put('/change/{member}', [MemberController::class, 'updateMember'])->name('member.update');
            Route::put('/change/status/{member}/{status}', [MemberController::class, 'changeStatus'])->name('member.change.status');
            Route::get('/export-pdf', [MemberController::class, 'exportPDF'])->name('member.export.pdf');
            Route::get('/export-excel', [MemberController::class, 'exportEXCEL'])->name('member.export.excel');
        });
        Route::get('/detail/export-excel/{kodeMember}', [MemberController::class, 'pelamarExportExcel'])->name('member.pelamar.export.excel');
    });

    Route::prefix('lowongan')->middleware('auth')->group(function () {
        Route::get('/', [LowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/create', [LowonganController::class, 'createView'])->name('lowongan.create.view');
        Route::post('/create', [LowonganController::class, 'createProcess'])->name('lowongan.create.process');
        Route::put('/update/{idLowongan}', [LowonganController::class, 'update'])->name('lowongan.update');
        Route::get('/detail/{idLowongan}', [LowonganController::class, 'detail'])->name('lowongan.detail');
        Route::get('/detail/export-excel/{idLowongan}', [LowonganController::class, 'exportDetailEXCEL'])->name('lowongan.export.detail.excel');
        Route::put('/change/status/{lowongan}/{status}', [LowonganController::class, 'changeStatus'])->name('lowongan.change.status');
        Route::get('/export-pdf', [LowonganController::class, 'exportPDF'])->name('lowongan.export.pdf');
        Route::get('/export-excel', [LowonganController::class, 'exportEXCEL'])->name('lowongan.export.excel');
    });

    Route::prefix('pelamar')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/', [PelamarController::class, 'index'])->name('pelamar.index');
            Route::get('/detail/{id}', [PelamarController::class, 'detail'])->name('pelamar.detail');
            Route::put('/change/status/{idPelamar}', [PelamarController::class, 'changeStatus'])->name('pelamar.change.status');
            Route::get('/export-excel', [PelamarController::class, 'exportEXCEL'])->name('pelamar.export.excel');
            Route::get('/export-pdf', [PelamarController::class, 'exportPDF'])->name('pelamar.export.pdf');
        });
        Route::get('/download/{tipe}/{kodePelamar}', [PelamarController::class, 'dowloadFilePelamar'])->name('pelamar.download.file');
    });

    Route::prefix('iq-question')->group(function () {
        Route::get('/', [IqTestController::class, 'questionIndex'])->name('iq-question.index');
        Route::get('/create', [IqTestController::class, 'questionCreateView'])->name('iq-question.create.view');
        Route::post('/create', [IqTestController::class, 'questionCreateProcess'])->name('iq-question.create.process');
    });
});

Route::prefix('perusahaan')->group(function () {
    Route::prefix('disc')->group(function () {
        Route::get('/result/{idPelamar}/{kodePelamar}', [PerusahaanController::class, 'discTestResult'])->middleware('auth')->name('perusahaan.pelamar.test.disc.result');
        Route::get('/{idPelamar}/{kodePelamar}', [PerusahaanController::class, 'discTestView'])->name('perusahaan.pelamar.test.disc.view');
        Route::post('/{idPelamar}/{kodePelamar}', [PerusahaanController::class, 'discTestProcess'])->name('perusahaan.pelamar.test.disc.process');
    });
    Route::prefix('iq')->group(function () {
        Route::get('/{idPelamar}/{kodePelamar}', [IqTestController::class, 'index'])->name('perusahaan.pelamar.test.iq.view');
        Route::get('/{idPelamar}/{kodePelamar}/question/{questionNumber}', [IqTestController::class, 'questionView'])->name('perusahaan.pelamar.test.iq.question.view');
        Route::post('/{idPelamar}/{kodePelamar}/question/{questionNumber}', [IqTestController::class, 'questionProcess'])->name('perusahaan.pelamar.test.iq.question.process');
    });
    Route::view('/thank-you', 'pages.public.perusahaan.thank-you')->name('perusahaan.thank.you');
    Route::get('/sorry/{kodeMember}', [PerusahaanController::class, 'notFoundLowongan'])->name('perusahaan.not.found.lowongan');
    Route::get('/{kodeMember}', [PerusahaanController::class, 'PerusahaanPelamarFormView'])->name('perusahaan.pelamar.view');
    Route::post('/{kodeMember}', [PerusahaanController::class, 'PerusahaanPelamarFormProcess'])->name('perusahaan.pelamar.process');
    Route::get('/result/{idPelamar}/{kodePelamar}', [PerusahaanController::class, 'perusahaanPelamarResultPage'])->name('perusahaan.pelamar.result.page.view');
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
    Route::post('/pelamar', [PelamarController::class, 'datatables'])->name('datatables.pelamar');
    Route::get('/test_iq', [IqTestController::class, 'datatables'])->name('datatables.test.iq');
    Route::get('/pelamar/lowongan/{idLowongan}', [LowonganController::class, 'datatablesPelamarLowongan'])->name('datatables.pelamar.lowongan');
});
