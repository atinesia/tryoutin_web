<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Dashboard Ringkasan Super Admin
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalExams = Exam::count();
        $totalRevenue = Order::where('status', 'PAID')->sum('amount');
        $pendingTickets = Ticket::where('status', 'OPEN')->count();

        $recentOrders = Order::with(['user', 'exam'])->latest()->take(5)->get();
        $tickets = Ticket::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalExams',
            'totalRevenue',
            'pendingTickets',
            'recentOrders',
            'tickets'
        ));
    }

    /**
     * Manajemen User
     */
    public function usersIndex()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function userUpdateRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|in:admin,user,tutor,affiliate']);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return back()->with('success', "Role user {$user->name} berhasil diperbarui menjadi {$request->role}.");
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'role'     => 'required|in:admin,user,tutor,affiliate',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'User baru berhasil ditambahkan!');
    }

    /**
     * Manajemen Tiket Kendala
     */
    public function ticketsIndex()
    {
        $tickets = Ticket::with('user')->latest()->paginate(15);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function ticketUpdateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:OPEN,IN_PROGRESS,RESOLVED']);

        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => $request->status]);

        return back()->with('success', 'Status tiket kendala berhasil diperbarui.');
    }
}
