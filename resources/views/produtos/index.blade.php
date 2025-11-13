@extends('layouts.app')

@section('title', 'Produtos - Bluefish')

@section('content')
    <div class="produtos-header fade-in">
        <h1>Nossos Produtos</h1>
        <p>Descubra nossa seleção de produtos frescos e de alta qualidade</p>
    </div>
    <div class="produtos-filtros fade-in">
        <div class="filtro-busca">
            <input type="text" id="busca" placeholder="Buscar produtos...">
            <i class="fas fa-search"></i>
        </div>
        <div class="filtro-ordem">
            <select id="ordem">
                <option value="nome">Nome</option>
                <option value="preco_asc">Menor Preço</option>
                <option value="preco_desc">Maior Preço</option>
            </select>
        </div>
    </div>
    <div class="grid produtos-grid">
        @foreach($produtos as $produto)
            <div class="card produto-card fade-in">
                <div class="produto-imagem">
                    <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}">
                    <div class="produto-overlay">
                        <a href="{{ route('produto.show', $produto->id) }}" class="btn btn-primary">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
                <div class="card-content">
                    <h3>{{ $produto->nome }}</h3>
                    <p class="descricao">{{ $produto->descricao }}</p>
                    <p class="preco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                    @auth
                        <form action="{{ route('vendas.store') }}" method="POST" class="produto-compra-form">
                            @csrf
                            <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                            <label class="quantidade-label" for="quantidade-{{ $produto->id }}">Quantidade</label>
                            <input
                                type="number"
                                id="quantidade-{{ $produto->id }}"
                                name="quantidade"
                                value="1"
                                min="1"
                                class="quantidade-input"
                                required
                            >
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-shopping-cart"></i> Comprar agora
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-secondary">
                            <i class="fas fa-sign-in-alt"></i> Faça login para comprar
                        </a>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
<script>
    // Animação de fade-in e funcionalidade de busca/ordenação
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach(element => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        });
        
        // Busca
        const busca = document.getElementById('busca');
        const cards = document.querySelectorAll('.produto-card');
        busca.addEventListener('input', function() {
            const termo = this.value.toLowerCase();
            cards.forEach(card => {
                const nome = card.querySelector('h3').textContent.toLowerCase();
                const descricao = card.querySelector('.descricao').textContent.toLowerCase();
                card.style.display = (nome.includes(termo) || descricao.includes(termo)) ? 'block' : 'none';
            });
        });

        // Ordenação
        const ordem = document.getElementById('ordem');
        const grid = document.querySelector('.produtos-grid');
        ordem.addEventListener('change', function() {
            const cardsArray = Array.from(document.querySelectorAll('.produto-card'));
            cardsArray.sort((a, b) => {
                switch(this.value) {
                    case 'nome':
                        return a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent);
                    case 'preco_asc':
                        return parseFloat(a.querySelector('.preco').textContent.replace('R$ ', '').replace('.', '').replace(',', '.')) -
                               parseFloat(b.querySelector('.preco').textContent.replace('R$ ', '').replace('.', '').replace(',', '.'));
                    case 'preco_desc':
                        return parseFloat(b.querySelector('.preco').textContent.replace('R$ ', '').replace('.', '').replace(',', '.')) -
                               parseFloat(a.querySelector('.preco').textContent.replace('R$ ', '').replace('.', '').replace(',', '.'));
                }
            });
            cardsArray.forEach(card => grid.appendChild(card));
        });
    });
</script>
@endsection