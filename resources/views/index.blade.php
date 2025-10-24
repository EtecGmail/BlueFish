@extends('layouts.app')

@section('title', 'Bluefish - Home')

@section('body-class', 'home-page')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Bem-vindo à BlueFish</h1>
                <p class="hero-subtitle">Fornecedora de peixes frescos para todos os mercados e lojas</p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ route('produtos.index') }}" class="btn btn-primary">Ver Nossos Produtos</a>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-primary">Fazer Login</a>
                    @endauth
                    <a href="{{ route('contato.form') }}" class="btn btn-secondary">Fale Conosco</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('img/pescador.jpg') }}" alt="Pescador BlueFish">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Sobre a BlueFish</h2>
                    <p class="about-description">
                        A BlueFish é uma fornecedora especializada em peixes frescos, atendendo mercados, 
                        lojas e estabelecimentos comerciais com produtos do mar de alta qualidade. 
                        Nossa missão é levar o frescor do oceano até sua mesa.
                    </p>
                    <div class="features-grid">
                        <div class="feature-item">
                            <i class="fas fa-fish"></i>
                            <h3>Peixes Frescos</h3>
                            <p>Selecionados diariamente pelos melhores pescadores</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-truck"></i>
                            <h3>Entrega Rápida</h3>
                            <p>Entregamos em todo o território nacional</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <h3>Qualidade Garantida</h3>
                            <p>Produtos certificados e de origem confiável</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-store"></i>
                            <h3>Para Mercados</h3>
                            <p>Atendemos mercados, lojas e estabelecimentos</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="{{ asset('img/peixe.jpg') }}" alt="Peixes frescos BlueFish">
                </div>
            </div>
        </div>
    </section>

    <!-- Products Preview Section -->
    <section class="products-preview">
        <div class="container">
            <h2>Nossos Produtos</h2>
            <p class="section-subtitle">Conheça nossa seleção de peixes frescos</p>
            <div class="products-grid">
                <div class="product-preview">
                    <img src="{{ asset('img/salmao.jpg') }}" alt="Salmão">
                    <h3>Salmão Fresco</h3>
                    <p>Salmão do Atlântico, perfeito para qualquer ocasião</p>
                </div>
                <div class="product-preview">
                    <img src="{{ asset('img/atum.jpg') }}" alt="Atum">
                    <h3>Atum</h3>
                    <p>Atum fresco, ideal para sashimi e pratos especiais</p>
                </div>
                <div class="product-preview">
                    <img src="{{ asset('img/camarao.jpg') }}" alt="Camarão">
                    <h3>Camarão</h3>
                    <p>Camarões frescos, perfeitos para diversos pratos</p>
                </div>
            </div>
            @auth
                <div class="text-center">
                    <a href="{{ route('produtos.index') }}" class="btn btn-primary">Ver Todos os Produtos</a>
                </div>
            @else
                <div class="text-center">
                    <a href="{{ route('login.form') }}" class="btn btn-primary">Faça Login para Ver Produtos</a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Contact CTA Section -->
    <section class="contact-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Interessado em Nossos Produtos?</h2>
                <p>Entre em contato conosco e descubra como podemos atender seu estabelecimento</p>
                @auth
                    <a href="{{ route('contato.form') }}" class="btn btn-primary">Fale Conosco</a>
                @else
                    <a href="{{ route('login.form') }}" class="btn btn-primary">Faça Login para Contatar</a>
                @endauth
            </div>
        </div>
    </section>
@endsection