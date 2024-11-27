<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SousAdminController;
use Illuminate\Support\Facades\Route;

// Root Route: Displays the welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route for Clients
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Dashboard Route for Admins
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashAdmin', [AdminController::class, 'index'])->name('admin');
});

// Dashboard Route for Sous-Admins
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/SousAdmin', [SousAdminController::class, 'index'])->name('sousAdmin');
});

// Authenticated Routes: Accessible only to logged-in users
Route::middleware('auth')->group(function () {
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
});

// **Admin Routes**: Specific to admin actions
Route::get('/admin/annonces/{annonce}', [AdminController::class, 'show'])->name('admin.annonces.show');
Route::post('/annonce/approve/{id}', [AdminController::class, 'approveAnnonce'])->name('annonces.approve');
Route::post('/annonce/reject/{id}', [AdminController::class, 'rejectAnnonce'])->name('annonces.reject');
Route::get('/annonce/approve/', [AdminController::class, 'approvedAnnonce'])->name('annonceapproved');
Route::get('/annonce/reject/', [AdminController::class, 'rejectedAnnonce'])->name('annoncerejected');
Route::get('/admin/annonce/{id}/view', [AdminController::class, 'viewAnnonce'])->name('annonce.view');

// **Admin User Management**
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users'); // List of users
Route::get('/admin/create-user', [AdminController::class, 'createUser'])->name('admin.createUser');
Route::post('/admin/store-user', [AdminController::class, 'storeUser'])->name('admin.storeUser');

Route::get('/admin/user/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit'); // Edit user form
Route::put('/admin/user/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update'); // Update user
Route::delete('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete'); // Delete user

// **Publishing Route**
Route::get('/annonce-publier', [AnnonceController::class, 'publierIndex'])->name('annonce.publier');

// Authentication Routes: Ensures authentication functionality
require __DIR__ . '/auth.php';

// If you have additional admin authentication, uncomment the line below
// require __DIR__ . '/admin-auth.php';

/*
 * Updates:
 * - Added role-based restrictions directly in ProfileController for profile management.
 * - Enhanced the Profile routes for edit, update, and delete functionalities.
 * - Verified the AnnonceController routes remain consistent with the existing role setup.
 */
