<?php

use App\Http\Controllers\PlatController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\MenuController;

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
Route::get('connexion',[ShowController::class,'connexion']);
Route::get('menus',[ShowController::class,'menus']);




// Route pour afficher le formulaire de modification
Route::get('modifier_menu/{id}', [ShowController::class, 'modifier_menu'])->name('modifier_menu');

// Route pour mettre à jour les données du menu
Route::put('update/{id}', [ShowController::class, 'update'])->name('update');


// Route pour supprimer un plat
Route::delete('supprimer_menu/{id}', [ShowController::class, 'destroy'])->name('destroy');


Route::get('notifications',[ShowController::class,'notifications']);
Route::get('Dashboard',[ShowController::class,'dashboard']);

// Afficher le formulaire de configuration des menus
Route::get('ajouter_menu', [MenuController::class, 'ajouter_menu'])->name('ajouter_menu');

// Gérer la soumission du formulaire de configuration des menus
Route::post('store', [MenuController::class, 'store'])->name('store');
