<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produto;
use App\Models\Contato;
use App\Models\Venda;
use Illuminate\Support\Facades\Schema;

class AdminController extends \Illuminate\Routing\Controller
{
    public function dashboard()
    {
        $stats = [
            'usuarios' => User::count(),
            'produtos' => Produto::count(),
            'contatos' => (class_exists(Contato::class) && Schema::hasTable('contatos')) ? Contato::count() : 0,
            'vendas' => (class_exists(Venda::class) && Schema::hasTable('vendas')) ? Venda::count() : 0,
            'faturamento' => (class_exists(Venda::class) && Schema::hasTable('vendas')) ? (float) Venda::sum('valor_total') : 0.0,
        ];

        $topProdutos = collect();

        if (class_exists(Venda::class) && Schema::hasTable('vendas')) {
            $topProdutos = Venda::query()
                ->selectRaw('produtos.nome, SUM(vendas.quantidade) as quantidade_total, SUM(vendas.valor_total) as valor_total')
                ->join('produtos', 'vendas.produto_id', '=', 'produtos.id')
                ->groupBy('produtos.id', 'produtos.nome')
                ->orderByDesc('quantidade_total')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'nome' => $item->nome,
                        'quantidade' => (int) $item->quantidade_total,
                        'valor_total' => (float) $item->valor_total,
                    ];
                });
        }

        if ($topProdutos->isEmpty()) {
            $topProdutos = Produto::select(['nome', 'preco'])
                ->orderBy('preco', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($p) {
                    return [
                        'nome' => $p->nome,
                        'quantidade' => 0,
                        'valor_total' => (float) $p->preco,
                    ];
                });
        }

        $recentes = collect();

        if (class_exists(Venda::class) && Schema::hasTable('vendas')) {
            $recentes = Venda::with(['produto', 'user'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();
        }

        return view('admin.dashboard', [
            'stats' => $stats,
            'topProdutos' => $topProdutos,
            'recentes' => $recentes,
        ]);
    }
}


