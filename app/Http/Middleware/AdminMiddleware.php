<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Jika belum login sama sekali, arahkan ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Jika sudah login tetapi bukan Admin/Tutor, lempar ke dashboard user
        if (!Auth::user()->isAdmin() && Auth::user()->role !== 'tutor') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses halaman Admin/Tutor.');
        }

        // 2. Jika bukan admin, tendang kembali ke katalog dengan pesan error
        return redirect()->route('exam.index')->with('error', 'Anda tidak memiliki hak akses halaman Admin.');
    }
}
