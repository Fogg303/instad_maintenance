<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TechnicianDashboardController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Middleware 'auth' pour protéger les routes après connexion
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect(RouteServiceProvider::redirectTo());
    })->name('dashboard');

    // Routes pour chaque rôle
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('role:admin') // Middleware pour restreindre l'accès aux admins
        ->name('admin.dashboard');

    Route::get('/technician/dashboard', [TechnicianDashboardController::class, 'index'])
        ->middleware('role:technician') // Middleware pour les techniciens
        ->name('technician.dashboard');

    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->middleware('role:user') // Middleware pour les utilisateurs simples
        ->name('user.dashboard');

    // Routes du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
require __DIR__.'/auth.php';
