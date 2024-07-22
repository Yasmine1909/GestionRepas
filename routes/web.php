<?php

use App\Http\Controllers\PlatController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController; // Assurez-vous d'importer le LoginController
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Routes pour les affichages publics
Route::get('/', [ShowController::class, 'show']);
Route::get('menu', [ShowController::class, 'menu']);
Route::get('connexion', [ShowController::class, 'connexion']);
Route::get('menus', [ShowController::class, 'menus']);
Route::get('notifications', [ShowController::class, 'notifications']);
Route::get('Dashboard', [ShowController::class, 'dashboard']);

// Routes pour la gestion des menus
Route::get('modifier_menu/{id}', [ShowController::class, 'modifier_menu'])->name('modifier_menu');
Route::put('update/{id}', [ShowController::class, 'update'])->name('update');
Route::delete('supprimer_menu/{id}', [ShowController::class, 'destroy'])->name('destroy');
Route::get('ajouter_menu', [MenuController::class, 'ajouter_menu'])->name('ajouter_menu');
Route::post('store', [MenuController::class, 'store'])->name('store');

// Authentification
Auth::routes(); // Cette ligne génère les routes d'authentification par défaut

// Utiliser votre vue personnalisée pour la page de connexion
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Redirection vers la page d'accueil après connexion
Route::get('/home', [HomeController::class, 'index'])->name('home');
