<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
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
}
