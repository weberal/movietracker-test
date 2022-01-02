<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('movies', [App\Http\Controllers\MoviesController::class, 'index']);
Route::get('movies/{title}/{page}', [App\Http\Controllers\MoviesController::class, 'show']);
Route::delete('movies/{title}', [App\Http\Controllers\MoviesController::class, 'destroy']);
Route::post('movies', [App\Http\Controllers\MoviesController::class, 'store']);
Route::get('movie-ids', [App\Http\Controllers\MoviesController::class, 'watchedIds']);
