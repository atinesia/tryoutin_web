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
        // Berikan izin jika user adalah Admin ATAU Tutor
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->role === 'tutor')) {
            return $next($request);
        }

        // 2. Jika bukan admin, tendang kembali ke katalog dengan pesan error
        return redirect()->route('exam.index')->with('error', 'Anda tidak memiliki hak akses halaman Admin.');
    }
}
