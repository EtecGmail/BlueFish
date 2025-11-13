@extends('layouts.app')

@section('title', 'Criar conta - Bluefish')

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Criar conta</h1>
                <p>Preencha os dados para receber novidades e comprar com a Bluefish.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error" role="alert" aria-live="assertive">
                    <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('register') }}" id="registroForm" novalidate>
                @csrf
                <div class="form-group">
                    <label for="nome">Nome completo</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}" autocomplete="name" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail comercial</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" autocomplete="tel">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" autocomplete="new-password" minlength="6" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_senha">Confirme a senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" autocomplete="new-password" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="termos" name="termos" value="1" {{ old('termos') ? 'checked' : '' }} required>
                    <label for="termos">Concordo com os termos de uso e política de privacidade.</label>
                </div>
                <button type="submit" class="btn btn-primary">Criar conta</button>
            </form>

            <div class="auth-links">
                <p>Já tem uma conta? <a href="{{ route('login.form') }}">Acesse sua área</a></p>
            </div>
        </div>
    </div>
@endsection
