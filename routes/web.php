<?php

use App\Http\Controllers\CkeditorController;
use Illuminate\Support\Facades\Route;

Route::get('ckeditor', [CkeditorController::class, 'index']);
Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');
