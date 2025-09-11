<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produtos - Bluefish</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="navbar">
            <div class="links">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/pexe.png') }}" alt="Bluefish - O Frescor do Mar">
                </a>
                <a href="{{ url('/') }}">Início</a>
                <a href="{{ route('produtos.index') }}">Nossa Seleção</a>
                <a href="{{ route('contato.form') }}">Fale Conosco</a>
            </div>
            <div class="login">
                @auth
                    <span class="welcome-message">
                        Olá, {{ auth()->user()->name }}! Mergulhe nos melhores sabores do mar.
                    </span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-btn" title="Sair da conta" style="background:none;border:none;color:inherit;cursor:pointer;">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login.form') }}" class="login-link" title="Entre para sentir o frescor do mar">
                        <i class="fas fa-user"></i> Entrar
                    </a>
                @endauth
            </div>
        </div>


  <div class="container">
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
                    <button class="btn btn-secondary">
                        <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                    </button>
                </div>
            </div>
        @endforeach
    </div>
  </div>

  <footer>
      <div class="footer-content">
          <div class="footer-section">
              <h3>Sobre a Bluefish</h3>
              <p>Somos especialistas em produtos do mar de alta qualidade, oferecendo o melhor da pesca para nossos clientes.</p>
          </div>
          <div class="footer-section">
              <h3>Contato</h3>
              <p><i class="fas fa-phone"></i> (11) 1234-5678</p>
              <p><i class="fas fa-envelope"></i> contato@bluefish.com</p>
              <p><i class="fas fa-map-marker-alt"></i> São Paulo, SP</p>
          </div>
          <div class="footer-section">
              <h3>Redes Sociais</h3>
              <div class="social-links">
                  <a href="#"><i class="fab fa-facebook"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-linkedin"></i></a>
              </div>
          </div>
      </div>
  </footer>

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
</body>
</html>