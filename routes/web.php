<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{any}', [App\Http\Controllers\SinglePageController::class, 'index'])->where('any', '.*');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/search', [App\Http\Controllers\MovieController::class, 'search'])->name('search');

// Route::get('/movies', function(){ 
//     return Auth::user()->movies;
// });

// Route::post('/movies', function(Request $request){ 
//     Auth::user()->movies()->attach([
//         'imdb_id' => request('imdb_id')
//     ]);
// });