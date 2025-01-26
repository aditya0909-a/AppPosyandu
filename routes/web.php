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
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PesertabalitaController;
use App\Http\Controllers\PesertalansiaController;

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

    Route::get('/dashboard/petugas/{userId}', function ($userId) {
        // Anda bisa menggunakan $userId untuk menampilkan data yang relevan
        return view('petugas.dashboard', compact('userId'));
    });

    Route::get('/fiturposyandu/petugas/{userId}', function ($userId) {
        return view('petugas.fitur_posyandu', [
            'Jadwals' => Jadwal::all(),
            'userId' => $userId]);
    });
    
    Route::get('/api/jadwal-options', [JadwalController::class, 'getJadwalOptions']);
       
    Route::get('/pendaftaran/fiturposyandubalita/{userId}/{jadwalId}', [PPBcontroller::class, 'pendaftaran']);

    Route::get('/pesertabalita/{jadwalId}', [PPBController::class, 'getPesertaByJadwal']);

    Route::post('/pesertabarubalita', [PPBController::class, 'register']);

    Route::get('/api/datapesertabalita', [PPBcontroller::class, 'index']);

    Route::post('/pendaftaran/fiturposyandubalita/store', [PPBcontroller::class, 'store']);

    Route::post('/pendaftaran/fiturposyandubalita/destroy', [PPBcontroller::class, 'destroy']);


    Route::get('/penimbangan/fiturposyandubalita/{userId}/{jadwalId}', [PPBcontroller::class, 'penimbangan']);

    Route::put('/update-penimbangan/{id}', [PPBcontroller::class, 'updatepenimbangan']);
    
    Route::get('/pengukuran/fiturposyandubalita/{userId}/{jadwalId}', [PPBcontroller::class, 'pengukuran']);

    Route::put('/update-pengukuran/{id}', [PPBcontroller::class, 'updatepengukuran']);
    
    Route::get('/susu/fiturposyandubalita/{userId}/{jadwalId}', [PPBcontroller::class, 'susu']);

    Route::put('/update-susu/{id}', [PPBcontroller::class, 'updatesusu']);

    Route::get('/obatcacing/fiturposyandubalita/{userId}/{jadwalId}', [PPBcontroller::class, 'obatcacing']);

    Route::put('/update-obatcacing/{id}', [PPBcontroller::class, 'updateobatcacing']);

    Route::get('/imunisasi/fiturposyandubalita/{userId}/{jadwalId}', [PPBcontroller::class, 'imunisasi']);

    Route::put('/update-imunisasi/{id}', [PPBcontroller::class, 'updateimunisasi']);

    Route::get('/pendaftaran/fiturposyandulansia/{userId}/{jadwalId}', [PPLcontroller::class, 'pendaftaran']);

    Route::get('/peserta/{jadwalId}', [PPLController::class, 'getPesertaByJadwal']);

    Route::post('/pesertabarulansia', [PPLController::class, 'register']);

    Route::get('/api/datapesertalansia', [PPLcontroller::class, 'index']);

    Route::post('/pendaftaran/fiturposyandulansia/store', [PPLcontroller::class, 'store']);

    Route::post('/pendaftaran/fiturposyandulansia/destroy', [PPLcontroller::class, 'destroy']);

    Route::get('/penimbangan/fiturposyandulansia/{userId}/{jadwalId}', [PPLcontroller::class, 'penimbangan']);

    Route::put('/update-penimbangan-lansia/{id}', [PPLcontroller::class, 'updatepenimbangan']);

    Route::get('/pengukuran/fiturposyandulansia/{userId}/{jadwalId}', [PPLcontroller::class, 'pengukuran']);

    Route::put('/update-pengukuran-lansia/{id}', [PPLcontroller::class, 'updatepengukuran']);

    Route::get('/pemeriksaan/fiturposyandulansia/{userId}/{jadwalId}', [PPLcontroller::class, 'pemeriksaan']);

    Route::put('/update-pemeriksaan/{id}', [PPLcontroller::class, 'updatepemeriksaan']);

    Route::get('/tesdengar/fiturposyandulansia/{userId}/{jadwalId}', [PPLcontroller::class, 'tesdengar'])->name('tesdengar.fiturposyandulansia');

    Route::get('/kuisioner_dengar/{id}/{jadwal_id}/{userId}', [PPLcontroller::class, 'kuisionerdengar']);

    Route::put('/update-kuisionerdengar/{id}', [PPLController::class, 'updatekuisionerdengar']);
    
    Route::get('/teskognitif/fiturposyandulansia/{userId}/{jadwalId}', [PPLcontroller::class, 'teskognitif'])->name('teskognitif.fiturposyandulansia');

    Route::get('/kuisioner_kognitif/{id}/{jadwal_id}/{userId}', [PPLcontroller::class, 'kuisionerkognitif']);

    Route::put('/update-kuisionerkognitif/{id}', [PPLController::class, 'updatekuisionerkognitif']);

    Route::get('/teslihat/fiturposyandulansia/{userId}/{jadwalId}', [PPLcontroller::class, 'teslihat'])->name('teslihat.fiturposyandulansia');

    Route::get('/kuisioner_lihat/{id}/{jadwal_id}/{userId}', [PPLcontroller::class, 'kuisionerlihat']);

    Route::put('/update-kuisionerlihat/{id}', [PPLController::class, 'updatekuisionerlihat']);

    Route::get('/tesmobilisasi/fiturposyandulansia/{userId}/{jadwalId}', [PPLcontroller::class, 'tesmobilisasi'])->name('tesmobilisasi.fiturposyandulansia');

    Route::get('/kuisioner_mobilisasi/{id}/{jadwal_id}/{userId}', [PPLcontroller::class, 'kuisionermobilisasi']);

    Route::put('/update-kuisionermobilisasi/{id}', [PPLController::class, 'updatekuisionermobilisasi']);

    Route::get('/fiturjadwal/petugas/{userId}', [JadwalController::class, 'getViewPetugas']);

});


Route::middleware(['auth', 'role:pesertabalita'])->group(function () {

    Route::get('/dashboard/pesertabalita/{userId}', function ($userId) {
        $user = User::findOrFail($userId); // Temukan user berdasarkan userId
        $peserta = $user->pesertaBalita; // Dapatkan data pesertaBalita terkait user
    
        return view('pesertabalita.dashboard', compact('userId', 'peserta'));
    });    

    Route::get('/fiturjadwal/pesertabalita/{userId}', [JadwalController::class, 'getViewPesertaBalita']);

    Route::get('/pesertabalita.databalita/{pesertaId}', [PesertabalitaController::class, 'DataKesehatan']);

    Route::get('/api/chart-data-balita/{pesertaId}', [Pesertabalitacontroller::class, 'getChartDataByPeserta']);

    
});

Route::middleware(['auth', 'role:pesertalansia'])->group(function () {

    Route::get('/dashboard/pesertalansia/{userId}', function ($userId) {
        $user = User::findOrFail($userId); // Temukan user berdasarkan userId
        $peserta = $user->pesertaLansia; // Dapatkan data pesertalansia terkait user
    
        return view('pesertalansia.dashboard', compact('userId', 'peserta'));
    });   
    
    Route::get('/fiturjadwal/pesertalansia/{userId}', [JadwalController::class, 'getViewPesertaLansia']);

    Route::get('/pesertalansia.datalansia/{pesertaId}', [PesertalansiaController::class, 'DataKesehatan']);

    Route::get('/api/chart-data-lansia/{pesertaId}', [Pesertalansiacontroller::class, 'getChartDataByPeserta']);

});



Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard/admin/{userId}', function ($userId) {
        // Anda bisa menggunakan $userId untuk menampilkan data yang relevan
        return view('admin.dashboard', compact('userId'));
    });

    Route::get('/fiturdatabalita/admin/{userId}', function ($userId) {
        return view('admin.fitur_databalita', [
            'PesertaPosyanduBalitas' => PesertaPosyanduBalita::all(),
            'userId' => $userId // Menyertakan userId ke dalam view
        ]);
    });
    

    Route::post('/pesertaposyandubalita', [PPBController::class, 'register'])->name('pesertaposyandubalitapesertas.tambah');

    Route::put('/pesertaposyandubalita/{id}', [PPBController::class, 'update'])->name('pesertaposyandubalitas.update');

    Route::get('/admin.databalita/{id}', [PPBcontroller::class, 'DataPesertaBalita']);

    Route::get('/admin.databalita/{id}', [PPBController::class, 'DataKesehatan']);

    Route::get('/api/chart-data-balita/{pesertaId}', [PPBcontroller::class, 'getChartDataByPeserta']);
    
    Route::get('/fiturdatalansia/admin/{userId}', function ($userId) {
        return view('admin.fitur_datalansia', [
            'PesertaPosyanduLansias' => PesertaPosyanduLansia::all(),
            'userId' => $userId
        ]);
    });

    Route::get('/api/chart-data-lansia/{pesertaId}', [PPLcontroller::class, 'getChartDataByPeserta']);

    Route::post('/pesertaposyandulansia', [PPLcontroller::class, 'register'])->name('pesertaposyandulansiapesertas.tambah');

    Route::put('/pesertaposyandulansia/{id}', [PPLcontroller::class, 'update'])->name('pesertaposyandulansias.update');

    Route::get('/admin.datalansia/{id}', [PPLcontroller::class, 'DataPesertaLansia']);

    Route::get('/admin.datalansia/{id}', [PPLcontroller::class, 'DataKesehatan']);

    Route::get('/fiturpenjadwalan/admin/{userId}', [JadwalController::class, 'getViewAdmin']);
    
    
    Route::post('/jadwal/tambah', [JadwalController::class, 'store'])->name('jadwal.store');

    Route::put('/jadwal/update/{id}', [JadwalController::class, 'update']);

    Route::get('/admin/jadwalbalita/{id}', [JadwalController::class, 'jadwalbalita']);
    Route::get('/admin/jadwallansia/{id}', [JadwalController::class, 'jadwallansia']);

    Route::get('/exportdaftarbalita/pdf/{id}', [ExportController::class, 'exportdaftarbalitaPdf']);
    Route::get('/exportdaftarbalita/excel/{id}', [ExportController::class, 'exportdaftarbalitaExcel']);

    Route::get('/exportpengukuranbalita/pdf/{id}', [ExportController::class, 'exportpengukuranbalitaPdf']);
    Route::get('/exportpengukuranbalita/excel/{id}', [ExportController::class, 'exportpengukuranbalitaExcel']);

    Route::get('/exportimunisasibalita/pdf/{id}', [ExportController::class, 'exportimunisasibalitaPdf']);
    Route::get('/exportimunisasibalita/excel/{id}', [ExportController::class, 'exportimunisasibalitaExcel']);

    Route::get('/exportobatcacingbalita/pdf/{id}', [ExportController::class, 'exportobatcacingbalitaPdf']);
    Route::get('/exportobatcacingbalita/excel/{id}', [ExportController::class, 'exportobatcacingbalitaExcel']);

    Route::get('/exportsusubalita/pdf/{id}', [ExportController::class, 'exportsusubalitaPdf']);
    Route::get('/exportsusubalita/excel/{id}', [ExportController::class, 'exportsusubalitaExcel']);

    Route::get('/exportdaftarlansia/pdf/{id}', [ExportController::class, 'exportdaftarlansiaPdf']);
    Route::get('/exportdaftarlansia/excel/{id}', [ExportController::class, 'exportdaftarlansiaExcel']);

    Route::get('/exportpengukuranlansia/pdf/{id}', [ExportController::class, 'exportpengukuranlansiaPdf']);
    Route::get('/exportpengukuranlansia/excel/{id}', [ExportController::class, 'exportpengukuranlansiaExcel']);

    Route::get('/exportpemeriksaanlansia/pdf/{id}', [ExportController::class, 'exportpemeriksaanlansiaPdf']);
    Route::get('/exportpemeriksaanlansia/excel/{id}', [ExportController::class, 'exportpemeriksaanlansiaExcel']);

    Route::get('/exportSKILAS/pdf/{id}', [ExportController::class, 'exportSKILASPdf']);
    Route::get('/exportSKILAS/excel/{id}', [ExportController::class, 'exportSKILASExcel']);
        
    Route::get('/fiturkelolaakun/admin/{userId}', [UserController::class, 'index']);

    // Di web.php atau api.php, sesuaikan route-nya:
    Route::post('/users/{id}/destroy', [UserController::class, 'destroy']);

    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::put('/users/{id}', [RegisterController::class, 'update'])->name('users.update');
});


// Route::get('/logout', function () {
//     return view('login');
// });

// Route::post('/register', [registercontroller::class, 'register']);
