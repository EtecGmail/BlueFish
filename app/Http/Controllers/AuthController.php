<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Aceita tanto "senha" quanto "password" vindos do formulário
        $request->merge([
            'senha' => $request->filled('senha')
                ? $request->input('senha')
                : $request->input('password'),
        ]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required', 'string'],
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'senha.required' => 'O campo senha é obrigatório.',
        ]);

        $key = Str::lower($request->input('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Muitas tentativas de login. Tente novamente em {$seconds} segundos.",
            ]);
        }

        $remember = $request->boolean('remember');
        $password = $credentials['senha'];

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $password], $remember)) {
            RateLimiter::hit($key);

            throw ValidationException::withMessages([
                'email' => 'As credenciais fornecidas não conferem com nossos registros.',
            ]);
        }

        RateLimiter::clear($key);

        $request->session()->regenerate();

        // Redirecionamento condicional simples: se e-mail for domínio de admin, vai para o painel
        if (str_ends_with(Str::lower($request->email), '@admin.com')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended('/')->with('sucesso', 'Login realizado com sucesso!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'senha' => 'required|min:6',
            'confirmar_senha' => 'required|same:senha',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'confirmar_senha.required' => 'Você precisa confirmar a senha.',
            'confirmar_senha.same' => 'As senhas não conferem.',
        ]);

        User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->senha),
        ]);

        return redirect('/login')->with('sucesso', 'Cadastro realizado com sucesso!');
    }

    /**
     * Método de logout que zera a sessão e redireciona.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('sucesso', 'Você saiu da sua conta.');
    }
}
