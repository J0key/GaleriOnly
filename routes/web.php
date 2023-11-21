<?php

use App\Http\Controllers\GaleriController;
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

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
Route::get('/galeri/{id}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
Route::post('/galeri/{id}', [GaleriController::class, 'update'])->name('galeri.update');
Route::delete('/galeri/{id}', [GaleriController::class, 'delete'])->name('galeri.delete');








