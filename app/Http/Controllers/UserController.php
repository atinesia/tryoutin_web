<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Halaman Dashboard Utama Siswa
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // 1. Ambil ID paket yang sudah dibeli & lunas (PAID) oleh user ini
        $paidExamIds = Order::where('user_id', $userId)
            ->where('status', 'PAID')
            ->pluck('exam_id');

        // 2. Ambil data Exam berdasarkan ID tersebut beserta relasi userExams milik user ini saja
        $purchasedExams = Exam::whereIn('id', $paidExamIds)
            ->with(['userExams' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->latest()
            ->get();

        return view('dashboard', compact('purchasedExams'));
    }
}
