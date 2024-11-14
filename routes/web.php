<?php

use App\Models\User;
use App\Models\PesertaPosyanduBalita;
use App\Models\PesertaPosyanduLansia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PPBcontroller;
use App\Http\Controllers\PPLcontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');


Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/dashboard/petugas', function () {
        return view('dashboard_petugas');
    });

    Route::get('/fiturposyandubalita_petugas', function () {
        return view('fiturposyandubalita_petugas');
    });

    Route::get('/fiturposyandulansia_petugas', function () {
        return view('fiturposyandulansia_petugas');
    });

    Route::get('/fiturimunisasi_petugas', function () {
        return view('fiturimunisasi_petugas');
    });

    Route::get('/fiturpenjadwalan_petugas', function () {
        return view('fiturpenjadwalan_petugas');
    });
});


Route::middleware(['auth', 'role:pesertabalita'])->group(function () {

    Route::get('/dashboard/pesertaBalita', function () {
        return view('dashboard_peserta_balita');
    });
});

Route::middleware(['auth', 'role:pesertalansia'])->group(function () {

    Route::post('/pesertaposyandulansia', [PPLController::class, 'register'])->name('pesertaposyandulansiapesertas.tambah');

    Route::put('/pesertaposyandulansia/{id}', [PPLController::class, 'update'])->name('pesertaposyandulansias.update');

    Route::get('/pesertaposyandulansia/{id}', [PPLController::class, 'show'])->name('pesertaposyandulansias.show');

    Route::get('/dashboard/pesertaLansia', function () {
        return view('dashboard_peserta_lansia');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard_admin');
    });
    Route::get('/fitur_databalita_admin', function () {
        return view('fitur_databalita_admin', [
            'PesertaPosyanduBalitas' => PesertaPosyanduBalita::all()
        ]);
    });

    Route::post('/pesertaposyandubalita', [PPBController::class, 'register'])->name('pesertaposyandubalitapesertas.tambah');

    Route::put('/pesertaposyandubalita/{id}', [PPBController::class, 'update'])->name('pesertaposyandubalitas.update');

    Route::get('/pesertaposyandubalita/{id}', [PPBController::class, 'show'])->name('pesertaposyandubalitas.show');

    Route::get('/fitur_datalansia_admin', function () {
        return view('fitur_datalansia_admin', [
            'PesertaPosyanduLansias' => PesertaPosyanduLansia::all()
        ]);
    });

    Route::get('/fitur_penjadwalan_admin', function () {
        return view('fitur_penjadwalan_admin');
    });

    Route::get('/DataPesertaPosyanduBalita_admin/{id}', [PPBcontroller::class, 'DataPesertaBalita']);

    Route::get('/fitur_kelolaakun_admin', function () {
        return view('fitur_kelolaakun_admin', [
            'users' => User::all()
        ]);
    });
    
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::put('/users/{id}', [RegisterController::class, 'update'])->name('users.update');
});


// Route::get('/logout', function () {
//     return view('login');
// });

// Route::post('/register', [registercontroller::class, 'register']);
