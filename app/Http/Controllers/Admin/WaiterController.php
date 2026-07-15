<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WaiterController extends Controller
{
    public function index()
    {
        $waiters = User::where('role', 'waiter')->orderBy('name')->get();
        return view('admin.waiters.index', compact('waiters'));
    }

    public function create()
    {
        return view('admin.waiters.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'waiter',
        ]);

        return redirect()->route('admin.waiters.index')
            ->with('success', 'Serveur créé avec succès.');
    }

    public function destroy(User $waiter)
    {
        if ($waiter->isAdmin()) {
            return back()->with('error', 'Impossible de supprimer un administrateur.');
        }

        $waiter->delete();

        return redirect()->route('admin.waiters.index')
            ->with('success', 'Serveur supprimé.');
    }
}
