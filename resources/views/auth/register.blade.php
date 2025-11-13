@extends('layouts.app')

@section('title', 'Criar conta - Bluefish')

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
            <h1 class="auth-card__title">Criar nova conta</h1>
            <p class="auth-card__subtitle">Preencha os dados para começar a comprar.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="admin-form">
            @csrf
            <div class="form-field">
                <label for="name">Nome completo</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="form-field">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-field">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-field">
                <label for="password_confirmation">Confirmar senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Criar conta</button>
            </div>
        </form>
    </div>
@endsection
