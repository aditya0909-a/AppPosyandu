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
       
    Route::get('/pendaftaran/fiturposyandubalita/petugas/{jadwalId}', [PPBcontroller::class, 'pendaftaran']);

    Route::get('/api/peserta/{jadwalId}', [PPBcontroller::class, 'getPesertaByJadwal'])->name('peserta.json');

    Route::post('/pesertabarubalita', [PPBController::class, 'register']);

    Route::get('/api/datapesertabalita', [PPBcontroller::class, 'index']);

    Route::post('/pendaftaran/fiturposyandubalita/store', [PPBcontroller::class, 'store']);

    Route::post('/pendaftaran/fiturposyandubalita/destroy', [PPBcontroller::class, 'destroy']);


    Route::get('/penimbangan/fiturposyandubalita/petugas/{jadwalId}', [PPBcontroller::class, 'penimbangan']);

    Route::put('/update-penimbangan/{id}', [PPBcontroller::class, 'updatepenimbangan']);
    
    Route::get('/pengukuran/fiturposyandubalita/petugas/{jadwalId}', [PPBcontroller::class, 'pengukuran']);

    Route::put('/update-pengukuran/{id}', [PPBcontroller::class, 'updatepengukuran']);

    Route::get('/kuisioner/fiturposyandubalita/petugas/{jadwalId}', function ($jadwalId) {
        return view('petugas.posyandubalita.fitur_kuisioner', ['jadwalId' => $jadwalId]);
    });

    Route::get('/vitamin/fiturposyandubalita/petugas/{jadwalId}', [PPBcontroller::class, 'vitamin']);

    Route::put('/update-vitamin/{id}', [PPBcontroller::class, 'updatevitamin']);
    
    Route::get('/susu/fiturposyandubalita/petugas/{jadwalId}', [PPBcontroller::class, 'susu']);

    Route::put('/update-susu/{id}', [PPBcontroller::class, 'updatesusu']);

    Route::get('/obatcacing/fiturposyandubalita/petugas/{jadwalId}', [PPBcontroller::class, 'obatcacing']);

    Route::put('/update-obatcacing/{id}', [PPBcontroller::class, 'updateobatcacing']);

    Route::get('/imunisasi/fiturposyandubalita/petugas/{jadwalId}', [PPBcontroller::class, 'imunisasi']);

    Route::put('/update-imunisasi/{id}', [PPBcontroller::class, 'updateimunisasi']);

    Route::get('/pendaftaran/fiturposyandulansia/petugas/{jadwalId}', [PPLcontroller::class, 'pendaftaran']);

    Route::post('/pesertabarulansia', [PPLController::class, 'register']);

    Route::get('/api/datapesertalansia', [PPLcontroller::class, 'index']);

    Route::post('/pendaftaran/fiturposyandulansia/store', [PPLcontroller::class, 'store']);

    Route::post('/pendaftaran/fiturposyandulansia/destroy', [PPLcontroller::class, 'destroy']);

    Route::get('/penimbangan/fiturposyandulansia/petugas/{jadwalId}', [PPLcontroller::class, 'penimbangan']);

    Route::put('/update-penimbangan-lansia/{id}', [PPLcontroller::class, 'updatepenimbangan']);

    Route::get('/pengukuran/fiturposyandulansia/petugas/{jadwalId}', [PPLcontroller::class, 'pengukuran']);

    Route::put('/update-pengukuran-lansia/{id}', [PPLcontroller::class, 'updatepengukuran']);

    Route::get('/pemeriksaan/fiturposyandulansia/petugas/{jadwalId}', [PPLcontroller::class, 'pemeriksaan']);

    Route::put('/update-pemeriksaan/{id}', [PPLcontroller::class, 'updatepemeriksaan']);

    Route::get('/tesdengar/fiturposyandulansia/petugas/{jadwalId}', [PPLcontroller::class, 'tesdengar']);

    Route::get('/kuisioner_dengar/{id}/{jadwal_id}', [PPLcontroller::class, 'kuisionerdengar']);

    Route::put('/update-kuisionerdengar/{id}', [PPLController::class, 'updatekuisionerdengar']);
    
    Route::get('/teskognitif/fiturposyandulansia/petugas/{jadwalId}', [PPLcontroller::class, 'teskognitif']);

    Route::get('/kuisioner_kognitif/{id}/{jadwal_id}', [PPLcontroller::class, 'kuisionerkognitif']);

    Route::put('/update-kuisionerkognitif/{id}', [PPLController::class, 'updatekuisionerkognitif']);

    Route::get('/teslihat/fiturposyandulansia/petugas/{jadwalId}', [PPLcontroller::class, 'teslihat']);

    Route::get('/kuisioner_lihat/{id}/{jadwal_id}', [PPLcontroller::class, 'kuisionerlihat']);

    Route::put('/update-kuisionerlihat/{id}', [PPLController::class, 'updatekuisionerlihat']);

    Route::get('/tesmobilisasi/fiturposyandulansia/petugas/{jadwalId}', [PPLcontroller::class, 'tesmobilisasi']);

    Route::get('/kuisioner_mobilisasi/{id}/{jadwal_id}', [PPLcontroller::class, 'kuisionermobilisasi']);

    Route::put('/update-kuisionermobilisasi/{id}', [PPLController::class, 'updatekuisionermobilisasi']);

    Route::get('/fiturjadwal/petugas', [JadwalController::class, 'jadwalPetugas'])->name('jadwal.petugas');

});


Route::middleware(['auth', 'role:pesertabalita'])->group(function () {

    Route::get('/dashboard/pesertabalita', function () {
        return view('pesertabalita.dashboard');
    });

    Route::get('/fiturjadwal/pesertabalita', [JadwalController::class, 'jadwalPesertaBalita'])->name('jadwal.pesertaBalita');

    
});

Route::middleware(['auth', 'role:pesertalansia'])->group(function () {

    Route::get('/dashboard/pesertalansia', function () {
        return view('pesertalansia.dashboard');
    });
    
    Route::get('/fiturjadwal/pesertalansia', [JadwalController::class, 'jadwalPesertaLansia'])->name('jadwal.pesertaLansia');

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

    Route::get('/admin.databalita/{id}', [PPBcontroller::class, 'DataPesertaBalita']);

    Route::get('/admin.databalita/{id}', [PPBController::class, 'DataKesehatan']);

    

    Route::get('/api/chart-data/{pesertaId}', [PPBcontroller::class, 'getChartDataByPeserta']);
    
    Route::get('/fiturdatalansia/admin', function () {
        return view('admin.fitur_datalansia', [
            'PesertaPosyanduLansias' => PesertaPosyanduLansia::all()
        ]);
    });

    Route::post('/pesertaposyandulansia', [PPBController::class, 'register'])->name('pesertaposyandulansiapesertas.tambah');

    Route::put('/pesertaposyandulansia/{id}', [PPBController::class, 'update'])->name('pesertaposyandulansias.update');

    Route::get('/admin.datalansia/{id}', [PPBcontroller::class, 'DataPesertaLansia']);

    Route::get('/admin.datalansia/{id}', [PPBController::class, 'DataKesehatan']);
    
   
    Route::get('/fiturpenjadwalan/admin', [JadwalController::class, 'index'])->name('admin.jadwal.index');
    
    Route::post('/jadwal/tambah', [JadwalController::class, 'store'])->name('jadwal.store');

    Route::put('/jadwal/update/{id}', [JadwalController::class, 'update']);

    Route::get('/admin/jadwal/{id}', [JadwalController::class, 'showJadwalWithPeserta'])->name('admin.jadwal');
        

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
