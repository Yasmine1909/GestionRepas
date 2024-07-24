<?php

use App\Http\Controllers\PlatController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SomeController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActiveDaysConfigurationController;

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





Route::get('notifications',[ShowController::class,'notifications']);
Route::get('Dashboard',[ShowController::class,'dashboard']);


// Gérer la soumission du formulaire de configuration des menus
Route::post('store', [MenuController::class, 'store'])->name('store');




//Configurer les jours
Route::get('/admin/active-days-configuration', [ActiveDaysConfigurationController::class, 'showConfigurationForm'])->name('admin.active_days_configuration');
Route::post('/admin/active-days-configuration', [ActiveDaysConfigurationController::class, 'saveConfiguration'])->name('admin.save_active_days_configuration');

//Ajouter Les PLats aux Jours
Route::get('/admin/ajouter-menu', [MenuController::class, 'showWeeklyMenuForm'])->name('admin.show_weekly_menu_form');
Route::post('/admin/store-weekly-menu', [MenuController::class, 'storeWeeklyMenu'])->name('admin.store_weekly_menu');

// Route pour afficher le formulaire de modification
Route::get('modifier_menu/{id}', [ShowController::class, 'modifier_menu'])->name('modifier_menu');

// Route pour mettre à jour les données du menu
Route::put('update/{id}', [ShowController::class, 'update'])->name('update');


// Route pour supprimer un plat
Route::delete('supprimer_menu/{id}', [ShowController::class, 'destroy'])->name('destroy');


Route::delete('/semaine/{id}/dupliquer', [ShowController::class, 'dupliquerSemaine'])->name('dupliquer.semaine');
Route::delete('/semaine/{id}/supprimer', [ShowController::class, 'supprimerSemaine'])->name('supprimer.semaine');


Route::post('/telecharger_menu/{week}', [MenuController::class, 'downloadPDF'])->name('telecharger.menu');
