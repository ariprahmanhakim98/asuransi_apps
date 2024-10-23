<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TpprdController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\KepesertaanController;


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

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


// Route::get('/home', function () {
//     return view('homex');
// })->middleware('jwt.auth')->name('home');

Route::get('/home', function () {
    return view('homex');
})->name('home');

Route::get('/change-password', function () {
    return view('auth.change-password');
})->middleware('jwt.auth')->name('change-password');



Route::get('/tpprd/create', [TpprdController::class, 'create'])->name('tpprd.create');
Route::post('/tpprd/store', [TpprdController::class, 'store'])->name('tpprd.store');
Route::get('/tpprd/download-template', [TpprdController::class, 'downloadTemplate'])->name('tpprd.download-template');
Route::post('/import-excel', [ExcelImportController::class, 'importExcel'])->name('tpprd.upload-template');

Route::get('/kepesertaan', [KepesertaanController::class, 'index'])->name('kepesertaan.index');
Route::get('/kepesertaan/data', [KepesertaanController::class, 'getData'])->name('kepesertaan.data');