<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $produto->nome }} - Bluefish</title>
  @php($hasViteManifest = file_exists(public_path('build/manifest.json')))
  @if($hasViteManifest)
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  @endif
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


  <div class="container produto-detalhes">
      <h1>{{ $produto->nome }}</h1>
      <div class="produto-imagem-detalhe">
          <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}">
      </div>
      <div class="produto-info-detalhe">
          <p>{{ $produto->descricao }}</p>
          <p class="preco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
          @auth
              <form action="{{ route('vendas.store') }}" method="POST" class="produto-compra-form">
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
</body>
</html>