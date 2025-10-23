<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produto;
use App\Models\Contato;
use Illuminate\Support\Facades\Schema;

class AdminController extends \Illuminate\Routing\Controller
{
    public function dashboard()
    {
        $stats = [
            'usuarios' => User::count(),
            'produtos' => Produto::count(),
            'contatos' => (class_exists(Contato::class) && Schema::hasTable('contatos')) ? Contato::count() : 0,
        ];

        // Top 5 produtos por preço (exemplo para gráficos)
        $topProdutos = Produto::select(['nome', 'preco'])
            ->orderBy('preco', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($p) {
                return [
                    'nome' => $p->nome,
                    'preco' => (float) $p->preco,
                ];
            });

        // Fallback simples: se vazio, mantém array vazio

        // Tabela recente (exemplo simples)
        $recentes = Produto::select(['id', 'nome', 'preco', 'updated_at'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'topProdutos' => $topProdutos,
            'recentes' => $recentes,
        ]);
    }
}


