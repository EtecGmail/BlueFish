<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with('produto')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('vendas.index', compact('vendas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produto_id' => ['required', 'exists:produtos,id'],
            'quantidade' => ['required', 'integer', 'min:1'],
        ], [
            'produto_id.required' => 'Selecione um produto válido.',
            'produto_id.exists' => 'O produto informado não foi encontrado.',
            'quantidade.required' => 'Informe a quantidade desejada.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade mínima é 1.',
        ]);

        $produto = Produto::findOrFail($validated['produto_id']);
        $quantidade = (int) $validated['quantidade'];
        $valorTotal = round($produto->preco * $quantidade, 2);

        Venda::create([
            'user_id' => $request->user()->id,
            'produto_id' => $produto->id,
            'quantidade' => $quantidade,
            'valor_total' => $valorTotal,
            'status' => 'concluida',
        ]);

        return redirect()
            ->route('vendas.index')
            ->with('sucesso', 'Compra registrada com sucesso!');
    }
}
