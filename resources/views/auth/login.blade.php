@extends('layouts.app')

@section('title', 'Login - Bluefish')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('body-class', 'auth-page')

@section('content')
    <div class="card auth-card">
        <div class="auth-card__header">
            <a href="{{ url('/') }}" class="auth-card__logo" aria-label="Voltar para a página inicial">
                <img src="{{ asset('img/pexe.png') }}" alt="Bluefish">
            </a>
            <h1 class="auth-card__title">Acessar minha conta</h1>
            <p class="auth-card__subtitle">Bem-vindo de volta! Insira seus dados para continuar.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="admin-form">
            @csrf
            <div class="form-field">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-field">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
        </form>
    </div>
@endsection