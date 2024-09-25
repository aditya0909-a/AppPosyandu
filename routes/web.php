<?php
use App\Http\Controllers\registercontroller;
use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard_admin');
});

Route::get('/fitur_databalita_admin', function () {
    return view('fitur_databalita_admin');
});

Route::get('/fitur_datalansia_admin', function () {
    return view('fitur_datalansia_admin');
});

Route::get('/fitur_penjadwalan_admin', function () {
    return view('fitur_penjadwalan_admin');
});

Route::get('/fitur_kelolaakun_admin', function () {
    return view('fitur_kelolaakun_admin');
});

Route::get('/fiturposyandubalita_kader', function () {
    return view('fiturposyandubalita_kader');
});

Route::get('/fiturposyandulansia_kader', function () {
    return view('fiturposyandulansia_kader');
});

Route::get('/fiturimunisasi_kader', function () {
    return view('fiturimunisasi_kader');
});

Route::get('/fiturpenjadwalan_kader', function () {
    return view('fiturpenjadwalan_kader');
});

Route::get('/logout', function () {
    return view('login');
});

Route::post('/register', [registercontroller::class, 'register']);