<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

Route::get('/blogs/{id}', [BlogController::class, 'index']);
Route::put('/blogs/update/{id}', [BlogController::class, 'update']);
Route::delete('/blogs/delete/{id}', [BlogController::class, 'delete']);