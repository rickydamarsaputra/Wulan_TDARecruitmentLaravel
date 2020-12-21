<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
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
            'status' => 1
        ]);

        return redirect('/');
    });
});

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashoard.index');

    Route::prefix('/member')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('member.index');
        Route::get('/detail/{namaMember}', [MemberController::class, 'detail'])->name('member.detail');
    });
});

Route::prefix('helpers')->group(function () {
    Route::prefix('generate')->group(function () {
        Route::get('/slug/{slug}', [ToolController::class, 'generateSlug'])->name('helpers.generate.slug');
        Route::get('/password', [ToolController::class, 'generatePassword'])->name('helpers.generate.password');
    });
});

Route::prefix('datatables')->group(function () {
    Route::get('/member', [MemberController::class, 'datatables'])->name('datatables.member');
});
