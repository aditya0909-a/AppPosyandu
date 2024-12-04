<?php

use App\Http\Controllers\JadwalController;
use App\Models\User;
use App\Models\PesertaPosyanduBalita;
use App\Models\PesertaPosyanduLansia;
use App\Models\jadwal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PPBcontroller;
use App\Http\Controllers\PPLcontroller;
use App\Http\Controllers\PetugasController;
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
        return view('petugas.dashboard');
    });

    Route::get('/fiturposyandu/petugas', function () {
        return view('petugas.fitur_posyandu', [
            'Jadwals' => Jadwal::all()]);
    });

    
Route::get('/api/jadwal-options', [JadwalController::class, 'getJadwalOptions']);


    Route::get('/fiturposyandubalita/petugas', function () {
        return view('petugas.fitur_posyandubalita');
    });

    Route::get('/pendaftaran/fiturposyandubalita/petugas', function () {
        return view('petugas.posyandubalita.fitur_pendaftaran');
    });

    Route::get('/api/search', [PPBcontroller::class, 'search'])->name('api.search');


    Route::get('/penimbangan/fiturposyandubalita/petugas', function () {
        return view('petugas.posyandubalita.fitur_penimbangan');
    });

    Route::get('/pengukuran/fiturposyandubalita/petugas', function () {
        return view('petugas.posyandubalita.fitur_pengukuran');
    });

    Route::get('/kuisioner/fiturposyandubalita/petugas', function () {
        return view('petugas.posyandubalita.fitur_kuisioner');
    });

    Route::get('/vitamin/fiturposyandubalita/petugas', function () {
        return view('petugas.posyandubalita.fitur_vitamin');
    });

    Route::get('/susu/fiturposyandubalita/petugas', function () {
        return view('petugas.posyandubalita.fitur_susu');
    });

    Route::get('/imunisasi/fiturposyandubalita/petugas', function () {
        return view('petugas.posyandubalita.fitur_imunisasi');
    });

    Route::get('/fiturposyandulansia/petugas', function () {
        return view('petugas.fitur_posyandulansia');
    });

    Route::get('/pendaftaran/fiturposyandulansia/petugas', function () {
        return view('petugas.posyandulansia.fitur_pendaftaran');
    });

    Route::get('/penimbangan/fiturposyandulansia/petugas', function () {
        return view('petugas.posyandulansia.fitur_penimbangan');
    });

    Route::get('/pengukuran/fiturposyandulansia/petugas', function () {
        return view('petugas.posyandulansia.fitur_pengukuran');
    });

    Route::get('/fiturjadwal/petugas', function () {
        return view('petugas.fitur_jadwal', [
            'Jadwals' => Jadwal::all()
        ]);
    });
});


Route::middleware(['auth', 'role:pesertabalita'])->group(function () {

    Route::get('/dashboard/pesertabalita', function () {
        return view('pesertabalita.dashboard');
    });

    Route::get('/fiturjadwal/pesertabalita', function () {
        return view('pesertabalita.fitur_jadwal', [
            'Jadwals' => Jadwal::all()
        ]);
    });
    
});

Route::middleware(['auth', 'role:pesertalansia'])->group(function () {

    Route::get('/dashboard/pesertalansia', function () {
        return view('pesertalansia.dashboard');
    });
    
    Route::get('/fiturjadwal/pesertalansia', function () {
        return view('pesertalansia.fitur_jadwal', [
            'Jadwals' => Jadwal::all()
        ]);
    });

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('admin.dashboard');
    });
    Route::get('/fiturdatabalita/admin', function () {
        return view('admin.fitur_databalita', [
            'PesertaPosyanduBalitas' => PesertaPosyanduBalita::all()
        ]);
    });

    Route::post('/pesertaposyandubalita', [PPBController::class, 'register'])->name('pesertaposyandubalitapesertas.tambah');

    Route::put('/pesertaposyandubalita/{id}', [PPBController::class, 'update'])->name('pesertaposyandubalitas.update');

    Route::get('/pesertaposyandubalita/{id}', [PPBController::class, 'show'])->name('pesertaposyandubalitas.show');

    Route::get('/admin.databalita/{id}', [PPBcontroller::class, 'DataPesertaBalita']);

    Route::get('/admin.databalita/{id}', [PPBController::class, 'DataKesehatan']);
    




    Route::get('/fiturdatalansia/admin', function () {
        return view('admin.fitur_datalansia', [
            'PesertaPosyanduLansias' => PesertaPosyanduLansia::all()
        ]);
    });

    Route::post('/pesertaposyandulansia', [PPLController::class, 'register'])->name('pesertaposyandulansiapesertas.tambah');

    Route::put('/pesertaposyandulansia/{id}', [PPLController::class, 'update'])->name('pesertaposyandulansias.update');

    Route::get('/pesertaposyandulansia/{id}', [PPLController::class, 'show'])->name('pesertaposyandulansias.show');

    Route::get('/DataPesertaPosyanduLansia_admin/{id}', [PPLcontroller::class, 'DataPesertaLansia']);


    Route::get('/fiturpenjadwalan/admin', function () {
        return view('admin.fitur_penjadwalan', [
            'Jadwals' => Jadwal::all()
        ]);
    });

    Route::post('/jadwal', [JadwalController::class, 'register'])->name('jadwaljadwals.tambah');

    Route::put('/fitur_penjadwalan_admin/{id}', [JadwalController::class, 'update'])->name('fitur_penjadwalan_admin.update');

    Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwals.show');

    Route::get('/DataPenjadwalan_admin/{id}', [PPLcontroller::class, 'DataPenjadwalan']);

    Route::get('/jadwal/admin', function () {
        return view('admin.jadwal');
    });

    Route::get('/fiturkelolaakun/admin', function () {
        return view('admin.fitur_kelolaakun', [
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
