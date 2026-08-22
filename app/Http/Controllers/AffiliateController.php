<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Ambil semua user yang mendaftar menggunakan referral_code milik user ini
        $referredUsers = User::where('referred_by', $user->referral_code)->pluck('id');
        
        $totalReferred = $referredUsers->count();
        
        // Hitung total transaksi sukses dari user rujukan
        $orders = Order::whereIn('user_id', $referredUsers)->where('status', 'PAID')->get();
        $totalSales = $orders->sum('amount');
        
        // Komisi 20%
        $totalCommission = $totalSales * 0.20;

        $referralLink = route('register') . '?ref=' . $user->referral_code;

        return view('affiliate.dashboard', compact('user', 'totalReferred', 'totalSales', 'totalCommission', 'referralLink', 'orders'));
    }
}
