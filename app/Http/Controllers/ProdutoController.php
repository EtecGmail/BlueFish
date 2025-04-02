<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
}