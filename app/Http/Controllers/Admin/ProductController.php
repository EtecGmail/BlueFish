<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Produto::query();

        if ($request->filled('status') && $request->status !== 'todos') {
            $query->where('status', $request->status);
        }

        if ($request->filled('busca')) {
            $busca = $request->string('busca')->trim()->toString();
            if ($busca === '') {
                $busca = null;
            }

            if ($busca) {
                $query->where(function ($inner) use ($busca) {
                    $inner->where('nome', 'like', "%{$busca}%")
                        ->orWhere('descricao', 'like', "%{$busca}%")
                        ->orWhere('categoria', 'like', "%{$busca}%");
                });
            }
        }

        $produtos = $query->orderBy('nome')->paginate(10)->withQueryString();

        return view('admin.products.index', [
            'produtos' => $produtos,
            'filtros' => [
                'status' => $request->input('status', 'todos'),
                'busca' => $request->filled('busca') ? trim((string) $request->input('busca')) : '',
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'produto' => new Produto([
                'status' => 'ativo',
                'estoque' => 0,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validateProduto($request);

        Produto::create($dados);

        return redirect()
            ->route('admin.products.index')
            ->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    public function edit(Produto $produto): View
    {
        return view('admin.products.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto): RedirectResponse
    {
        $dados = $this->validateProduto($request);

        $produto->update($dados);

        return redirect()
            ->route('admin.products.index')
            ->with('sucesso', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto): RedirectResponse
    {
        if ($produto->vendas()->exists()) {
            return redirect()
                ->route('admin.products.index')
                ->with('erro', 'Não é possível excluir produtos vinculados a vendas. Atualize o status para inativo.');
        }

        $produto->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('sucesso', 'Produto removido com sucesso.');
    }

    protected function validateProduto(Request $request): array
    {
        return $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:2000'],
            'preco' => ['required', 'numeric', 'min:0'],
            'imagem' => ['nullable', 'string', 'max:1024'],
            'categoria' => ['nullable', 'string', 'max:255'],
            'estoque' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:ativo,inativo'],
        ], [
            'nome.required' => 'Informe o nome do produto.',
            'descricao.required' => 'Descreva brevemente o produto.',
            'preco.required' => 'Informe o preço.',
            'preco.numeric' => 'O preço deve ser um número válido.',
            'estoque.integer' => 'O estoque deve ser um número inteiro.',
            'status.in' => 'Selecione um status válido.',
        ]);
    }
}
