<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminExamController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Exam;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. Landing Page & Public Routes
Route::get('/', function () {
    return view('welcome');
});
Route::get('/packages', [ExamController::class, 'index'])->name('exam.index');
Route::post('/api/tripay-webhook', [OrderController::class, 'webhook']);

// 2. Auth Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
// 3. User / Siswa Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $purchasedExams = Exam::with('userExams')->get();
        return view('dashboard', compact('purchasedExams'));
    })->name('dashboard');

    // Exam Engine
    Route::get('/exam/{examId}', [ExamController::class, 'show'])->name('exam.show');
    Route::post('/exam/{userExamId}/finish', [ExamController::class, 'finish'])->name('exam.finish');
    Route::get('/exam/result/{userExamId}', [ExamController::class, 'result'])->name('exam.result');
    Route::get('/exam/leaderboard/{examId}', [ExamController::class, 'leaderboard'])->name('exam.leaderboard');

    // Tripay Payment
    Route::get('/checkout/{examId}', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{examId}', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/order/{reference}', [OrderController::class, 'detail'])->name('order.detail');

    // Tiket Kendala
    Route::post('/tickets', function (Request $request) {
        $request->validate(['subject' => 'required', 'message' => 'required']);
        Ticket::create(['user_id' => Auth::id(), 'subject' => $request->subject, 'message' => $request->message]);
        return back()->with('success', 'Laporan Anda berhasil dikirim ke Admin.');
    })->name('ticket.store');

    // 4. Afiliator Dashboard
    Route::get('/affiliate/dashboard', [AffiliateController::class, 'dashboard'])->name('affiliate.dashboard');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// 5. Super Admin & Tutor Routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::post('/users/{id}/role', [AdminController::class, 'userUpdateRole'])->name('users.updateRole');

    // Tickets Management
    Route::get('/tickets', [AdminController::class, 'ticketsIndex'])->name('tickets.index');
    Route::post('/tickets/{id}/status', [AdminController::class, 'ticketUpdateStatus'])->name('tickets.updateStatus');

    // AI Question Generator (Accessible by Admin & Tutor)
    Route::get('/exams/create', [AdminExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [AdminExamController::class, 'store'])->name('exams.store');
});
