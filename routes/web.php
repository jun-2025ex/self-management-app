<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecordController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/record', [RecordController::class, 'index'])->name('record');
Route::post('/record', [RecordController::class, 'store']);
Route::delete('/record/delete', [RecordController::class, 'destroy'])->name('record.delete');
