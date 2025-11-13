<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    /**
     * Lista todos os produtos (para a página /produtos).
     */
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }

    /**
     * Mostra os detalhes de um produto (para /produto/{id}).
     */
    public function show($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.show', compact('produto'));
    }

    /**
     * Registra uma nova venda para o produto especificado.
     */
    public function comprar(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        Venda::create([
            'user_id' => Auth::id(),
            'produto_id' => $produto->id,
            'quantidade' => 1, // Simplificado para 1 unidade por compra
            'preco_unitario' => $produto->preco,
        ]);

        return redirect()->route('produtos.index')->with('sucesso', 'Compra realizada com sucesso!');
    }
}
