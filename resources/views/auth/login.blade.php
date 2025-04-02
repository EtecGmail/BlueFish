<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Bluefish</title>
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
            @if(session()->has('usuario_id'))
                <!-- Mensagem acolhedora e convidativa -->
                <span class="welcome-message">
                    Olá, {{ session('usuario_nome') }}! Mergulhe nos melhores sabores do mar.
                </span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Sair da conta" style="background:none;border:none;color:inherit;cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            @else
                <!-- Incentivo para entrar e descobrir os produtos -->
                <a href="{{ route('login.form') }}" class="login-link" title="Entre para sentir o frescor do mar">
                    <i class="fas fa-user"></i> Entrar
                </a>
            @endif
        </div>
    </div>

  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
          <h1>Login</h1>
          <p>Entre com suas credenciais</p>
      </div>

      @if(session('erro'))
          <div class="alert alert-danger">
              <i class="fas fa-exclamation-circle"></i>
              {{ session('erro') }}
          </div>
      @elseif(session('sucesso'))
          <div class="alert alert-success">
              <i class="fas fa-check-circle"></i>
              {{ session('sucesso') }}
          </div>
      @endif

      <form class="auth-form" method="POST" action="{{ route('login') }}" id="loginForm">
          @csrf
          <div class="form-group">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" required>
              <span id="emailFeedback" class="form-text text-danger" style="display: none;">Por favor, insira um email válido.</span>
          </div>
          <div class="form-group">
              <label for="senha">Senha</label>
              <input type="password" id="senha" name="senha" required>
              <span id="senhaFeedback" class="form-text text-danger" style="display: none;">A senha é obrigatória.</span>
          </div>
          <div class="form-check">
              <input type="checkbox" id="lembrar" name="lembrar">
              <label for="lembrar">Lembrar-me</label>
          </div>
          <button type="submit" class="btn btn-primary">Entrar</button>
      </form>
      <div class="auth-divider">
          <span>ou</span>
      </div>
      <div class="social-login">
          <button class="social-btn google"><i class="fab fa-google"></i> Google</button>
          <button class="social-btn facebook"><i class="fab fa-facebook-f"></i> Facebook</button>
      </div>
      <div class="auth-links">
          <p>Não tem uma conta? <a href="{{ route('register.form') }}">Registre-se</a></p>
          <p><a href="#">Esqueceu sua senha?</a></p>
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
    // Validação simples em JavaScript (opcional)
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const senhaInput = document.getElementById('senha');
        const emailFeedback = document.getElementById('emailFeedback');
        const senhaFeedback = document.getElementById('senhaFeedback');
        emailInput.addEventListener('input', function() {
            // Validação básica de email
            const re = /^(([^<>()\\.,;:\s@"]+(\.[^<>()\\.,;:\s@"]+)*)|(".+"))@(([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test(String(this.value).toLowerCase())) {
                emailFeedback.style.display = 'block';
            } else {
                emailFeedback.style.display = 'none';
            }
        });
    });
  </script>
</body>
</html>