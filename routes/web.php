<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechnicianDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminMakeUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

// Bloquer l'inscription publique
Route::match(['get', 'post'], 'register', function () {
    abort(404);
});

// Routes d'authentification de base
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Routes nécessitant une authentification
Route::middleware('auth')->group(function () {
    // Vérification email
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('verification.send');

    // Déconnexion
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Changement de mot de passe forcé
    Route::middleware(['force.password.change'])->group(function () {
        Route::get('/password/change', [PasswordController::class, 'showChangeForm'])
            ->name('password.change')
            ->withoutMiddleware('force.password.change');
        
        Route::post('/password/change', [PasswordController::class, 'changePassword'])
            ->name('password.update');
    });

    // Changement de mot de passe admin (sans restriction)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/change-password', [PasswordController::class, 'adminChangePassword'])
            ->name('admin.password.change');
    });
});

// Routes protégées (authentifiées + vérifiées + mot de passe changé)
Route::middleware(['auth', 'verified', 'password.changed'])->group(function () {
    // Redirection selon le rôle
    Route::get('/dashboard', function () {
        return redirect(RouteServiceProvider::redirectTo());
    })->name('dashboard');

    // Tableaux de bord par rôle
    Route::middleware('role:admin')->get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

// Route technicien
Route::middleware(['auth', 'verified', 'role:technician'])->group(function () {
    Route::get('/technician/dashboard', [TechnicianDashboardController::class, 'index'])->name('technician.dashboard');;
});
    Route::middleware('role:user')->get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes Admin spécifiques
// routes/web.php
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('directions', AdminController::class)->names([
        'index' => 'admin.directions.index',
        'create' => 'admin.directions.create',
        'store' => 'admin.directions.store',
        'edit' => 'admin.directions.edit',
        'update' => 'admin.directions.update',
        'destroy' => 'admin.directions.destroy'
    ]);

    // Gestion des utilisateurs
    Route::resource('users', AdminMakeUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);

    // Réinitialisation forcée de mot de passe
    Route::post('users/{user}/force-reset', [AdminMakeUserController::class, 'forcePasswordReset'])
        ->name('admin.users.force-password-reset');
});