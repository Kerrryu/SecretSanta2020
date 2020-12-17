<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SantaUserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getwinner', [App\Http\Controllers\SecretSantaController::class, 'ReturnWinner'])->name('winner');
Route::get('resetkeys', [App\Http\Controllers\SecretSantaController::class, 'ResetKeys'])->name('resetkeys');
Route::get('generatematches', [App\Http\Controllers\SecretSantaController::class, 'GenerateMatches'])->name('genmatches');