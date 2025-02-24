<?php

use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('movies', [MovieController::class, 'index']);
Route::get('movie/{id}', [MovieController::class, 'show']);
Route::get('movie/{id}', [MovieController::class, 'destroy']);
Route::post('movies', [MovieController::class, 'store']);
