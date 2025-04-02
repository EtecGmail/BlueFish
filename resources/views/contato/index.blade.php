<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Bluefish</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="navbar">
            <div class="links">
       
            <div class="login">
                @if(session()->has('usuario_id'))
                    <!-- Mensagem acolhedora e convidativa -->
                    <span class="welcome-message">
                        Olá, {{ session('usuario_nome') }}! Mergulhe nos melhores sabores do mar.
                    </span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                           <a href="{{ url('/') }}">
                    <img src="{{ asset('img/pexe.png') }}" alt="Bluefish - O Frescor do Mar">
                </a>
                <a href="{{ url('/') }}">Início</a>
                <a href="{{ route('produtos.index') }}">Nossa Seleção</a>
                <a href="{{ route('contato.form') }}">Fale Conosco</a>
            </div>      @csrf
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

    <div class="contato-container">
        <div class="container">
            <div class="contato-header">
                <h1>Fale Conosco</h1>
                <p>Entre em contato conosco para tirar suas dúvidas ou fazer um pedido</p>
            </div>

            {{-- Exibe mensagens de sucesso ou erro, se houver --}}
            @if(session('sucesso'))
                <div class="alert alert-success">
                    {{ session('sucesso') }}
                </div>
            @elseif(session('erro'))
                <div class="alert alert-danger">
                    {{ session('erro') }}
                </div>
            @endif

            <div class="contato-grid">
                <div class="contato-info">
                    <h2>Informações de Contato</h2>
                    <div class="contato-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="contato-item-info">
                            <h3>Endereço</h3>
                            <p>Rua das Pescarias, 123<br>Centro - São Paulo, SP</p>
                        </div>
                    </div>
                    <div class="contato-item">
                        <i class="fas fa-phone"></i>
                        <div class="contato-item-info">
                            <h3>Telefone</h3>
                            <p>(11) 1234-5678</p>
                        </div>
                    </div>
                    <div class="contato-item">
                        <i class="fas fa-envelope"></i>
                        <div class="contato-item-info">
                            <h3>E-mail</h3>
                            <p>contato@bluefish.com</p>
                        </div>
                    </div>
                    <div class="contato-item">
                        <i class="fas fa-clock"></i>
                        <div class="contato-item-info">
                            <h3>Horário de Atendimento</h3>
                            <p>Segunda a Sexta: 8h às 18h<br>Sábado: 8h às 13h</p>
                        </div>
                    </div>
                </div>

                <div class="contato-form">
                    <h2>Envie sua Mensagem</h2>
                    <form action="{{ route('contato.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="tel" id="telefone" name="telefone">
                        </div>
                        <div class="form-group">
                            <label for="assunto">Assunto</label>
                            <select id="assunto" name="assunto" required>
                                <option value="">Selecione um assunto</option>
                                <option value="duvida">Dúvida</option>
                                <option value="pedido">Pedido</option>
                                <option value="reclamacao">Reclamação</option>
                                <option value="sugestao">Sugestão</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mensagem">Mensagem</label>
                            <textarea id="mensagem" name="mensagem" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                    </form>
                </div>
            </div>

            <div class="contato-mapa">
                <h2>Nossa Localização</h2>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.197577494978!2d-46.652277!3d-23.550520!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDMzJzAxLjkiUyA0NsKwMzknMDguMiJX!5e0!3m2!1spt-BR!2sbr!4v1625761234567!5m2!1spt-BR!2sbr" 
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
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
        // Adicionar animação de fade-in aos elementos
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(element => {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>