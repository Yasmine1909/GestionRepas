<?php

use App\Http\Controllers\PlatController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActiveDaysConfigurationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NotificationController;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ReservationStatsController;
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

// Route pour la page de connexion
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Authentification
Auth::routes(); // Génère les routes d'authentification par défaut

// Appliquer le middleware 'auth' à toutes les routes ci-dessous
Route::middleware(['auth'])->group(function () {
    // Toutes vos routes nécessitant une authentification
    Route::get('/', [ShowController::class, 'show'])->name('home');
    Route::get('menu', [ShowController::class, 'menu']);
    Route::get('menus', [ShowController::class, 'menus']);
    Route::post('store', [MenuController::class, 'store'])->name('store');
    Route::get('/admin/active-days-configuration', [ActiveDaysConfigurationController::class, 'showConfigurationForm'])->name('admin.active_days_configuration');
    Route::post('/admin/active-days-configuration', [ActiveDaysConfigurationController::class, 'saveConfiguration'])->name('admin.save_active_days_configuration');
    Route::get('/admin/ajouter-menu', [MenuController::class, 'showWeeklyMenuForm'])->name('admin.show_weekly_menu_form');
    Route::post('/admin/store-weekly-menu', [MenuController::class, 'storeWeeklyMenu'])->name('admin.store_weekly_menu');
    Route::get('modifier_menu/{id}', [ShowController::class, 'modifier_menu'])->name('modifier_menu');
    Route::put('update/{id}', [ShowController::class, 'update'])->name('update');
    Route::delete('supprimer_menu/{id}', [ShowController::class, 'destroy'])->name('destroy');
    Route::post('/semaine/{id}/dupliquer', [ShowController::class, 'dupliquerSemaine'])->name('dupliquer.semaine');
    Route::delete('/semaine/{id}/supprimer', [ShowController::class, 'supprimerSemaine'])->name('supprimer.semaine');
    Route::post('/telecharger_menu/{week}', [MenuController::class, 'downloadPDF'])->name('telecharger.menu');
    Route::get('/download-menu/{startDate}', [ReservationController::class, 'downloadMenu'])->name('download.menu');
    Route::get('/Dashboard', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{date}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/reserve', [ReservationController::class, 'reserve'])->name('reserve');
    Route::post('/reservations/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
    Route::post('/reservations/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::post('/reserve-week', [ReservationController::class, 'reserveWeek'])->name('reserve.week');
    Route::get('statistiques', [ShowController::class, 'statistiques']);
    Route::get('/reservation-stats', [ReservationStatsController::class, 'index']);
    Route::post('/reservation-stats/fetch', [ReservationStatsController::class, 'fetchStats']);
    Route::get('/reservation-stats/fetch-history', [ReservationStatsController::class, 'fetchHistory']);
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/search', [NotificationController::class, 'search'])->name('notifications.search');
    Route::get('/test-email', function () {
        $user = Auth::user(); // Assurez-vous que vous êtes connecté ou remplacez ceci par un utilisateur fictif
        $notification = App\Models\Notification::first(); // Utilisez une notification existante ou créez-en une pour tester
        Mail::to($user->email)->send(new NotificationMail($notification));
        return 'E-mail envoyé avec succès !';
    });
});

// Redirection vers la page d'accueil après connexion
// Route::get('/home', [HomeController::class, 'index'])->name('home');
