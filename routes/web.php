<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SousAdminController;
use App\Http\Controllers\PackController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes for client dashboard
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Routes for admin dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashAdmin', [AdminController::class, 'index'])->name('admin');
});

// Routes for sous-admin dashboard
Route::middleware(['auth', 'role:sous-admin'])->group(function () {
    Route::get('/SousAdmin', [SousAdminController::class, 'index'])->name('sousAdmin');
});

// Authenticated Routes: Accessible only to logged-in users
Route::middleware('auth')->group(function () {
    Route::get('/profile/view', [ProfileController::class, 'view'])->name('profile.view');

    // **Profile Routes**: Role-based access added in `ProfileController` to manage user profiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // **Annonce Routes**
    Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index'); // List of annonces
    Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create'); // Form to create an annonce
    Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store'); // Store new annonce
    Route::get('/annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show'); // Show a specific annonce
    Route::get('/annonces/{annonce}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit'); // Form to edit an annonce
    Route::patch('/annonces/{annonce}', [AnnonceController::class, 'update'])->name('annonces.update'); // Update annonce
    Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy'])->name('annonces.destroy'); // Delete annonce

    Route::get('/annonces/{annonce}/confirmation', [AnnonceController::class, 'confirmation'])->name('annonces.confirmation'); // Confirmation page
    Route::post('/annonces/{annonce}/payment', [AnnonceController::class, 'payment'])->name('annonces.payment'); // Payment route
    Route::post('/annonces/{annonce}/cancel', [AnnonceController::class, 'cancel'])->name('annonces.cancel'); // Cancel route

    // New route for handling payment simulation
    Route::post('/annonces/{annonce}/payer', [AnnonceController::class, 'payment'])->name('annonces.payment'); // Simulate payment

    Route::get('/packs', [PackController::class, 'index'])->name('packs.index');
    Route::post('/packs/purchase', [PackController::class, 'purchase'])->name('packs.purchase');
});

// **Admin Routes**: Specific to admin actions
Route::get('/admin/annonces/{annonce}', [AdminController::class, 'show'])->name('admin.annonces.show');
Route::post('/annonce/approve/{id}', [AdminController::class, 'approveAnnonce'])->name('annonces.approve');
Route::post('/annonce/reject/{id}', [AdminController::class, 'rejectAnnonce'])->name('annonces.reject');
Route::get('/annonce/approve/', [AdminController::class, 'approvedAnnonce'])->name('annonceapproved');
Route::get('/annonce/reject/', [AdminController::class, 'rejectedAnnonce'])->name('annoncerejected');
Route::get('/admin/annonce/{id}/view', [AdminController::class, 'viewAnnonce'])->name('annonce.view');

// Route for generating the invoice
Route::get('/annonces/{annonce}/invoice', [AnnonceController::class, 'generateInvoice'])->name('annonces.invoice');

// **Admin User Management**
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users'); // List of users
Route::get('/admin/create-user', [AdminController::class, 'createUser'])->name('admin.createUser');
Route::post('/admin/store-user', [AdminController::class, 'storeUser'])->name('admin.storeUser');

Route::get('/admin/user/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit'); // Edit user form
Route::put('/admin/user/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update'); // Update user
Route::delete('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete'); // Delete user

// **Publishing Route**
Route::get('/annonce-publier', [AnnonceController::class, 'publierIndex'])->name('annonce.publier');

// Authentication Routes
require __DIR__ . '/auth.php';

// **Logout Route**
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
