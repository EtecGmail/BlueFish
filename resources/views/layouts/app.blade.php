<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bluefish')</title>
    @php($hasViteManifest = file_exists(public_path('build/manifest.json')))
    @if($hasViteManifest)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @endif
    @stack('styles')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="@yield('body-class')">
    <a href="#conteudo-principal" class="skip-link">Ir para o conteúdo principal</a>

    <header class="navbar" id="navbar" data-navbar data-open="false">
        <div class="navbar__inner">
            <a href="{{ url('/') }}" class="navbar__brand">
                <img src="{{ asset('img/pexe.png') }}" alt="Bluefish">
                <span class="sr-only">Bluefish - O frescor do mar para o seu negócio</span>
            </a>

            <button type="button" class="navbar__toggle" data-navbar-toggle aria-expanded="false" aria-controls="menu-principal">
                <span class="sr-only">Alternar navegação</span>
                <span class="navbar__toggle-icon" aria-hidden="true"></span>
            </button>

            <nav class="navbar__menu" id="menu-principal" aria-label="Menu principal">
                <ul class="navbar__list">
                    <li><a class="navbar__link" href="{{ url('/') }}">Início</a></li>
                    <li><a class="navbar__link" href="{{ route('produtos.index') }}">Nossa Seleção</a></li>
                    <li><a class="navbar__link" href="{{ route('contato.form') }}">Fale Conosco</a></li>
                    @auth
                        <li><a class="navbar__link" href="{{ route('vendas.index') }}">Minhas Compras</a></li>
                        @if(auth()->user()->is_admin ?? false)
                            <li><a class="navbar__link" href="{{ route('admin.dashboard') }}">Painel Admin</a></li>
                        @endif
                    @endauth
                </ul>

                <div class="navbar__actions">
                    @auth
                        <span class="welcome-message" role="status">
                            Olá, {{ auth()->user()->name }}! Aproveite o melhor do mar.
                        </span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                                <span>Sair</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <span>Entrar</span>
                        </a>
                        <a href="{{ route('register.form') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-user-plus" aria-hidden="true"></i>
                            <span>Criar conta</span>
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main id="conteudo-principal" class="page-content @yield('main-class')">
        @if(session('sucesso') || session('erro') || $errors->any())
            <div class="page-shell">
                @if(session('sucesso'))
                    <div class="alert alert-success" role="status" aria-live="polite">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        {{ session('sucesso') }}
                    </div>
                @endif

                @if(session('erro'))
                    <div class="alert alert-error" role="alert" aria-live="assertive">
                        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                        {{ session('erro') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error" role="alert" aria-live="assertive">
                        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        @hasSection('full-width')
            @yield('full-width')
        @endif

        @hasSection('content')
            <div class="page-shell">
                @yield('content')
            </div>
        @endif
    </main>

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

    @yield('scripts')
</body>
</html>
