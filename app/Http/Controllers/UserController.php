<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::orderBy('name')->get();

        return inertia('Users', [
            'users' => $users,
        ]);
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'role' => 'required|in:admin,supervisor,technician,collaborator',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Perfil do usuário atualizado com sucesso.');
    }
}
