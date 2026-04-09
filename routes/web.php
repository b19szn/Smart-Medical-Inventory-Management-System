<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Inventory Management
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/create', [InventoryController::class, 'create'])->name('create');
        Route::post('/', [InventoryController::class, 'store'])->name('store');
        Route::get('/{id}', [InventoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [InventoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InventoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [InventoryController::class, 'destroy'])->name('destroy');
    });
    
    // Stock Control (Add/Consume/Transfer)
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/add', [StockController::class, 'showAddForm'])->name('add.form');
        Route::post('/add', [StockController::class, 'add'])->name('add');
        Route::get('/consume', [StockController::class, 'showConsumeForm'])->name('consume.form');
        Route::post('/consume', [StockController::class, 'consume'])->name('consume');
        Route::get('/transfer', [StockController::class, 'showTransferForm'])->name('transfer.form');
        Route::post('/transfer', [StockController::class, 'transfer'])->name('transfer');
        Route::get('/transfers', [StockController::class, 'transfers'])->name('transfers');
    });
    
    // Alerts (Shortage & Expiry)
    Route::prefix('alerts')->name('alerts.')->group(function () {
        Route::get('/', [AlertController::class, 'index'])->name('index');
        Route::get('/shortage', [AlertController::class, 'shortage'])->name('shortage');
        Route::get('/expiry', [AlertController::class, 'expiry'])->name('expiry');
        Route::post('/settings', [AlertController::class, 'updateSettings'])->name('settings.update');
    });
    
    // User Management (Admin & SuperAdmin only)
    Route::middleware(['role:superadmin,admin'])->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
    
    // Export Center
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/', [ExportController::class, 'index'])->name('index');
        Route::post('/pdf', [ExportController::class, 'exportPDF'])->name('pdf');
        Route::post('/excel', [ExportController::class, 'exportExcel'])->name('excel');
        Route::post('/csv', [ExportController::class, 'exportCSV'])->name('csv');
    });
});
