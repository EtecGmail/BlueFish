<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Bluefish</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
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

  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
          <h1>Criar Conta</h1>
          <p>Preencha seus dados para criar sua conta</p>
      </div>

      {{-- Exibição dos erros de validação --}}
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      {{-- Exibição das mensagens de sessão --}}
      @if(session('sucesso'))
          <div class="alert alert-success">
              <i class="fas fa-check-circle"></i>
              {{ session('sucesso') }}
          </div>
      @endif

      <form class="auth-form" method="POST" action="{{ route('register') }}" id="registroForm">
          @csrf
          <div class="form-group">
              <label for="nome">Nome Completo</label>
              <input type="text" id="nome" name="name" value="{{ old('name') }}" required>
          </div>
          <div class="form-group">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" required>
          </div>
          <div class="form-group">
              <label for="password">Senha</label>
              <input type="password" id="password" name="password" required>
              <span id="senhaFeedback" class="form-text text-danger" style="display: none;">A senha deve ter pelo menos 6 caracteres.</span>
          </div>
          <div class="form-group">
              <label for="password_confirmation">Confirmar Senha</label>
              <input type="password" id="password_confirmation" name="password_confirmation" required>
              <span id="confirmarSenhaFeedback" class="form-text text-danger" style="display: none;">As senhas não coincidem.</span>
          </div>
          <button type="submit" class="btn btn-primary">Criar Conta</button>
      </form>
      <div class="auth-divider">
          <span>ou</span>
      </div>
      <div class="social-login">
          <button class="social-btn google"><i class="fab fa-google"></i> Google</button>
          <button class="social-btn facebook"><i class="fab fa-facebook-f"></i> Facebook</button>
      </div>
      <div class="auth-links">
          <p>Já tem uma conta? <a href="{{ route('login.form') }}">Faça login</a></p>
      </div>
    </div>
  </div>

  <footer>
      <div class="footer-content">
          <div class="footer-section">
              <h3>Sobre a Bluefish</h3>
              <p>Somos especialistas em produtos do mar de alta qualidade.</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        const senhaInput = document.getElementById('password');
        const confirmarSenhaInput = document.getElementById('password_confirmation');
        const senhaFeedback = document.getElementById('senhaFeedback');
        const confirmarSenhaFeedback = document.getElementById('confirmarSenhaFeedback');

        senhaInput.addEventListener('input', function() {
            if (this.value.length < 6) {
                senhaFeedback.style.display = 'block';
            } else {
                senhaFeedback.style.display = 'none';
            }
        });

        confirmarSenhaInput.addEventListener('input', function() {
            if (this.value !== senhaInput.value) {
                confirmarSenhaFeedback.style.display = 'block';
            } else {
                confirmarSenhaFeedback.style.display = 'none';
            }
        });
    });
  </script>
</body>
</html>