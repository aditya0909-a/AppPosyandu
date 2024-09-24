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

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard_admin');
});

Route::get('/fitur_dataanak_admin', function () {
    return view('fitur_dataanak_admin');
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

Route::get('/logout', function () {
    return view('login');
});

Route::post('/register', [registercontroller::class, 'register']);