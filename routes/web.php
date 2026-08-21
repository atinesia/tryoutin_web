<?php

use App\Http\Controllers\AdminExamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


// Halaman Katalog Pilih Paket Tryout (Dapat diakses Publik/Auth)
Route::get('/packages', [ExamController::class, 'index'])->name('exam.index');

// --- GUEST ROUTES (Belum Login) ---
Route::middleware('guest')->group(function () {
    // 1. URL '/' hanya untuk menampilkan halaman login (GET)
    Route::get('/', [AuthController::class, 'showLoginForm']);

    // 2. Berikan nama 'login' pada rute GET /login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // 3. Tambahkan rute POST /login untuk memproses submit form login
    Route::post('/login', [AuthController::class, 'login']);

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    // Pastikan rute logout ini ada di dalam middleware auth dan memiliki ->name('logout')
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/exam/{id}', [ExamController::class, 'show'])->name('exam.show');
    Route::post('/api/exam/save-answer', [ExamController::class, 'saveAnswer']);
    Route::get('/exam/{id}/finish', [ExamController::class, 'finish'])->name('exam.finish');
    Route::get('/exam/{id}/result', [ExamController::class, 'result'])->name('exam.result');

    Route::get('/admin/exams/create', [AdminExamController::class, 'create'])->name('admin.exams.create');
    Route::post('/admin/exams', [AdminExamController::class, 'store'])->name('admin.exams.store');

    Route::get('/checkout/{examId}', [OrderController::class, 'checkout'])->name('checkout');
});
