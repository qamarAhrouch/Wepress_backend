<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SousAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashAdmin', [AdminController::class, 'index'])->name('admin');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/SousAdmin', [SousAdminController::class, 'index'])->name('sousAdmin');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Annonce Routes
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

// Approve and Reject Routes
Route::post('/annonce/approve/{id}', [AdminController::class, 'approveAnnonce'])->name('annonces.approve'); // Approve an annonce
Route::post('/annonce/reject/{id}', [AdminController::class, 'rejectAnnonce'])->name('annonces.reject'); // Reject an annonce

require __DIR__ . '/auth.php';
// require __DIR__ . '/admin-auth.php';
