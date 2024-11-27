<?php

use App\Http\Controllers\JadwalController;
use App\Models\User;
use App\Models\PesertaPosyanduBalita;
use App\Models\PesertaPosyanduLansia;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PPBcontroller;
use App\Http\Controllers\PPLcontroller;
use App\Http\Controllers\JadwalControllercontroller;

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
})->middleware('redirectIfAuthenticated');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login')->middleware('redirectIfAuthenticated');

    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');


Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/dashboard/petugas', function () {
        return view('dashboard_petugas');
    });

    Route::get('/fiturposyandubalita_petugas', function () {
        return view('fiturposyandubalita_petugas', [
            'Jadwals' => Jadwal::all()
        ]);
    });

    Route::get('/fiturposyanduanak_pendaftaran_petugas', function () {
        return view('fiturposyanduanak_pendaftaran_petugas');
    });

    Route::get('/fiturposyandulansia_petugas', function () {
        return view('fiturposyandulansia_petugas');
    });

    Route::get('/fiturimunisasi_petugas', function () {
        return view('fiturimunisasi_petugas');
    });

    Route::get('/fiturjadwal_petugas', function () {
        return view('fiturjadwal_petugas', [
            'Jadwals' => Jadwal::all()
        ]);
    });
});


Route::middleware(['auth', 'role:pesertabalita'])->group(function () {

    Route::get('/dashboard/pesertaBalita', function () {
        return view('dashboard_peserta_balita');
    });

    Route::get('/fiturjadwal_peserta_balita', function () {
        return view('fiturjadwal_peserta_balita', [
            'Jadwals' => Jadwal::all()
        ]);
    });
    
});

Route::middleware(['auth', 'role:pesertalansia'])->group(function () {

    Route::get('/dashboard/pesertaLansia', function () {
        return view('dashboard_peserta_lansia');
    });
    
    Route::get('/fiturjadwal_peserta_lansia', function () {
        return view('fiturjadwal_peserta_lansia', [
            'Jadwals' => Jadwal::all()
        ]);
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

    Route::get('/DataPesertaPosyanduBalita_admin/{id}', [PPBcontroller::class, 'DataPesertaBalita']);

    Route::get('/DataPesertaPosyanduBalita_admin/{id}', [PPBController::class, 'DataKesehatan']);
    
    Route::get('/chart-data/{peserta_id}', [PPBController::class, 'getChartDataByPeserta']);



    Route::get('/fitur_datalansia_admin', function () {
        return view('fitur_datalansia_admin', [
            'PesertaPosyanduLansias' => PesertaPosyanduLansia::all()
        ]);
    });

    Route::post('/pesertaposyandulansia', [PPLController::class, 'register'])->name('pesertaposyandulansiapesertas.tambah');

    Route::put('/pesertaposyandulansia/{id}', [PPLController::class, 'update'])->name('pesertaposyandulansias.update');

    Route::get('/pesertaposyandulansia/{id}', [PPLController::class, 'show'])->name('pesertaposyandulansias.show');

    Route::get('/DataPesertaPosyanduLansia_admin/{id}', [PPLcontroller::class, 'DataPesertaLansia']);


    Route::get('/fitur_penjadwalan_admin', function () {
        return view('fitur_penjadwalan_admin', [
            'Jadwals' => Jadwal::all()
        ]);
    });

    Route::post('/jadwal', [JadwalController::class, 'register'])->name('jadwaljadwals.tambah');

    Route::put('/fitur_penjadwalan_admin/{id}', [JadwalController::class, 'update'])->name('fitur_penjadwalan_admin.update');

    Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwals.show');

    Route::get('/DataPenjadwalan_admin/{id}', [PPLcontroller::class, 'DataPenjadwalan']);

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
