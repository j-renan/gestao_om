<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Order::with(['user', 'tecnico']);

        if ($user->role === 'collaborator') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'technician') {
            $query->where('tecnico_id', $user->id);
        }
        // Admin and Supervisor see all

        $orders = $query->orderBy('created_at', 'desc')->get();

        $technicians = [];
        if (in_array($user->role, ['admin', 'supervisor'])) {
            $technicians = User::where('role', 'technician')->orderBy('name')->get();
        }

        return inertia('Orders', [
            'orders' => $orders,
            'technicians' => $technicians,
        ]);
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'collaborator'])) {
            abort(403, 'Ação não permitida para o seu perfil.');
        }

        $validated = $request->validate([
            'solicitante' => 'required|string|max:255',
            'ni' => 'required|max:255',
            'tipo_manutencao' => 'required|string',
            'prioridade' => 'required|string',
            'gestor_responsavel' => 'nullable|string|max:255',
            'prazo' => 'required|date',
        ]);

        $order = Order::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'Pendente',
        ]);

        return redirect()->route('orders')->with('success', 'Ordem de manutenção criada com sucesso!');
    }

    public function update(Request $request, Order $order)
    {
        if (!in_array(Auth::user()->role, ['admin', 'supervisor', 'technician'])) {
            abort(403);
        }

        $validated = $request->validate([
            'tecnico_id' => 'nullable|exists:users,id',
            'status' => 'nullable|string|in:Pendente,Em Andamento,Finalizada',
        ]);

        // Technicians can only update status
        if (Auth::user()->role === 'technician') {
            unset($validated['tecnico_id']);
        }

        $order->update($validated);

        return back()->with('success', 'Ordem atualizada com sucesso.');
    }
}
