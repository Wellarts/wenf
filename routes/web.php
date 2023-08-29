<?php

use App\Http\Controllers\Orientacao;
use App\Http\Controllers\Receituario;
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

Route::get('print/receituario/{id}',[Receituario::class, 'print'])->name('imprimirReceituario');
Route::get('print/orientacao/{id}',[Orientacao::class, 'print'])->name('imprimirOrientacao');
