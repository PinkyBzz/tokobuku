<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->latest()->paginate(12);
        
        // User statistics
        $totalUsers = User::count();
        $activeUsers = User::whereNotNull('email_verified_at')->count();
        $adminUsers = User::where('role', 'admin')->count();
            
        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'adminUsers'));
    }

    public function toggleRole(User $user)
    {
        // Don't allow changing own role
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah role Anda sendiri!');
        }
        
        // Toggle between admin and user
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();
        
        return redirect()->back()->with('success', 'Role user berhasil diubah!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Don't allow deletion of admin users
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus admin!');
        }
        
        // Check if user has orders
        if ($user->orders()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus user yang memiliki pesanan!');
        }
        
        $user->delete();
        
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}
