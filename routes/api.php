<?php

use App\Http\Controllers\ArticleController;
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

Route::post('/articles', [ArticleController::class, 'create']);
Route::delete('/articles', [ArticleController::class, 'delete']);
Route::put('/articles', [ArticleController::class, 'edit']);
