@extends('layouts.app')

@section('title', $produto->nome . ' - Bluefish')

@section('content')
    <article class="produto-detalhes">
        <div class="produto-imagem-detalhe">
            <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}">
        </div>
        <div class="produto-info-detalhe">
            <header>
                <h1>{{ $produto->nome }}</h1>
                <p class="preco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            </header>
            <p>{{ $produto->descricao }}</p>

            @auth
                <form action="{{ route('vendas.store') }}" method="POST" class="produto-compra-form" aria-label="Comprar {{ $produto->nome }}">
                    @csrf
                    <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                    <label class="quantidade-label" for="quantidade-produto">Quantidade</label>
                    <input
                        type="number"
                        id="quantidade-produto"
                        name="quantidade"
                        value="1"
                        min="1"
                        class="quantidade-input"
                        required
                    >
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                        <span>Adicionar ao pedido</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login.form') }}" class="btn btn-primary">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    <span>Entre para comprar</span>
                </a>
            @endauth
        </div>
    </article>
@endsection
