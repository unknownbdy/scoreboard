<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreController;

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

Route::get('/',[ScoreController::class,'index']);
Route::post('/GetScoreDetail',[ScoreController::class,'GetScoreDetail']);
Route::get('/startmatch/{id}',[ScoreController::class,'StartMatch']);
Route::post('gameover', [ScoreController::class,'GameOver']);
