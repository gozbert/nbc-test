<?php

use App\Http\Controllers\RipotiBController;
use App\Http\Controllers\RipotiPartnerController;
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
    return view('welcome');
})->name('home');

Route::post('ripoti_b_excel_download', [RipotiBController::class, 'download'])->name('ripoti_b.download');
Route::post('ripoti_partnership_excel_download', [RipotiPartnerController::class, 'download'])->name('ripoti_partnership.download');
Route::resource('/ripoti_b', RipotiBController::class)->only('index', 'create');
Route::resource('/ripoti_partnership', RipotiPartnerController::class)->only('index');
