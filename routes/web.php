<?php

use App\Http\Controllers\PlatController;
use App\Http\Controllers\ShowController;

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

Route::get('/',[ShowController::class,'show']);
Route::get('menu',[ShowController::class,'menu']);

Route::get('create_plat',[PlatController::class,'create_plat']);
Route::post('store_plat',[PlatController::class,'store_plat']);
