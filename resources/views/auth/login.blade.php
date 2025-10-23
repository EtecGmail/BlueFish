@extends('layouts.app')

@section('title', 'Login - Bluefish')

@section('content')
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
          <h1>Login</h1>
          <p>Entre com suas credenciais</p>
      </div>

      <form class="auth-form" method="POST" action="{{ route('login') }}" id="loginForm">
          @csrf
          <div class="form-group">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" required>
              <span id="emailFeedback" class="form-text text-danger" style="display: none;">Por favor, insira um email válido.</span>
          </div>
          <div class="form-group">
              <label for="password">Senha</label>
              <input type="password" id="password" name="password" required>
              <span id="passwordFeedback" class="form-text text-danger" style="display: none;">A senha é obrigatória.</span>
          </div>
          <div class="form-check">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Lembrar-me</label>
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
@endsection

@section('scripts')
<script>
    // Validação simples em JavaScript (opcional)
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const emailFeedback = document.getElementById('emailFeedback');
        const passwordFeedback = document.getElementById('passwordFeedback');
        
        emailInput.addEventListener('input', function() {
            // Validação básica de email
            const re = /^(([^<>()\\.,;:\s@"]+(\.[^<>()\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test(String(this.value).toLowerCase())) {
                emailFeedback.style.display = 'block';
            } else {
                emailFeedback.style.display = 'none';
            }
        });
    });
</script>
@endsection