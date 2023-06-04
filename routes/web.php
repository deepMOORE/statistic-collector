<?php

use App\Http\Controllers\AnomaliesController;
use App\Http\Controllers\ArticleController;
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

Route::get('/', [ArticleController::class, 'viewWelcome']);
Route::get('articles/create', [ArticleController::class, 'viewCreate']);
Route::get('articles/edit/{id}', [ArticleController::class, 'viewEdit']);

Route::get('anomalies/{id}', [AnomaliesController::class, 'index']);
Route::get('anomalies/download/{id}', [AnomaliesController::class, 'download']);
