<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\EquipementController;
// Ensure the correct namespace or create the EquipmentTypeController if it doesn't exist
use App\Http\Controllers\Admin\EquipmentTypeController;
use App\Http\Controllers\CharacteristicController;
use App\Http\Controllers\MaintenanceRequestController;

Route::get('/', function () {
    return view('welcome');
});

// Bloquer l'inscription publique
Route::match(['get', 'post'], 'register', function () {
    abort(404);
});

// Authentification
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Vérification email
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('verification.send');
});

// Gestion mot de passe
Route::middleware(['auth', 'force.password.change'])->group(function () {
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'changePassword'])->name('password.update');
});

// Routes protégées
Route::middleware(['auth', 'verified', 'password.changed'])->group(function () {
    // Déconnexion
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Tableau de bord général
    Route::get('/dashboard', function () {
        return redirect(RouteServiceProvider::redirectTo());
    })->name('dashboard');

    // Gestion de profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/debug-create', [EquipementController::class, 'create'])->name('debug.create');


    // Routes utilisateur
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');// Routes équipements
    Route::resource('equipments', EquipementController::class) // Nom corrigé
         ->names([
             'index' => 'equipments.index',
             'create' => 'equipments.create',
             'store' => 'equipments.store',
             'edit' => 'equipments.edit',
             'update' => 'equipments.update',
             'destroy' => 'equipments.destroy'
         ]);
    


      // Maintenance routes - Corrected structure
Route::prefix('user/maintenance')->name('maintenance.')->middleware([
    'auth', 
    'verified', 
    'password.changed', 
    'role:user'
])->group(function () {
    // Sélection de l'équipement
    Route::get('/select-equipment', [MaintenanceController::class, 'selectEquipment'])
         ->name('select-equipment');

    // Create maintenance request
    Route::get('/equipments/{equipment}/create', [MaintenanceController::class, 'create'])
         ->name('create')
         ->middleware('check.equipment.status');

    // Store maintenance request
    Route::post('/store/{equipment}', [MaintenanceController::class, 'store'])
         ->name('store');

    // Show maintenance details
    Route::get('/{maintenance}', [MaintenanceController::class, 'show'])
         ->name('show');

    // List maintenance requests
    Route::get('/', [MaintenanceController::class, 'index'])
         ->name('index');
});

}); // Close the user route group
    // Routes technicien
    Route::middleware('role:technician')->prefix('technician')->group(function () {
        Route::get('/dashboard', [TechnicianDashboardController::class, 'index'])->name('technician.dashboard');
        Route::get('/taches', [MaintenanceController::class, 'technicianTasks'])->name('technician.tasks');
        Route::put('/taches/{affectation}', [MaintenanceController::class, 'updateTaskProgress'])->name('technician.update-progress');
    });


    // Routes admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Directions
        Route::resource('directions', AdminController::class)->names([
            'index' => 'admin.directions.index',
            'create' => 'admin.directions.create',
            'store' => 'admin.directions.store',
            'edit' => 'admin.directions.edit',
            'update' => 'admin.directions.update',
            'destroy' => 'admin.directions.destroy'
        ]);

        // Utilisateurs
        Route::resource('users', AdminMakeUserController::class)->except(['show'])->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy'
        ]);

        // Équipements
        Route::resource('equipment-types', EquipmentTypeController::class)->except(['show'])->names([
            'index' => 'admin.equipment-types.index',
            'create' => 'admin.equipment-types.create',
            'store' => 'admin.equipment-types.store',
            'edit' => 'admin.equipment-types.edit',
            'update' => 'admin.equipment-types.update',
            'destroy' => 'admin.equipment-types.destroy',
        ]);



        // Caractéristiques
        Route::resource('characteristics', CharacteristicController::class)->except(['show'])->names([
            'index' => 'admin.characteristics.index',
            'create' => 'admin.characteristics.create',
            'store' => 'admin.characteristics.store',
            'edit' => 'admin.characteristics.edit',
            'update' => 'admin.characteristics.update',
            'destroy' => 'admin.characteristics.destroy',
        ]);

        // Réinitialisation mot de passe
        Route::post('users/{user}/force-reset', [AdminMakeUserController::class, 'forcePasswordReset'])
            ->name('admin.users.force-password-reset');
    });

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'password.changed', 'role:admin'])->group(function () {
        // Équipements (sans création)
        Route::resource('equipments', \App\Http\Controllers\Admin\EquipmentController::class)->except(['create', 'store', 'show'])
             ->names([
                 'index' => 'equipments.index',
                 'edit' => 'equipments.edit',
                 'update' => 'equipments.update',
                 'destroy' => 'equipments.destroy'
             ]);
        
        // Export CSV
        Route::get('/equipments/export', [\App\Http\Controllers\Admin\EquipmentController::class, 'export'])
             ->name('equipments.export');
             
    });
});