<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bluefish - Home</title>
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

    <div class="container">
        <h1>Bem-vindo à Bluefish</h1>
        <p>Seu site de produtos do mar de alta qualidade.</p>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Sobre a Bluefish</h3>
                <p>Somos especialistas em produtos do mar e pesca.</p>
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