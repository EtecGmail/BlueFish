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

        $user = $request->user();

        if (! $user->is_admin) {
            $intended = $request->session()->get('url.intended');

            if ($intended && Str::startsWith($intended, url('/admin'))) {
                $request->session()->forget('url.intended');
            }
        }

        if ($user->is_admin) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended('/')->with('sucesso', 'Login realizado com sucesso!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefone' => 'nullable|string|max:20',
            'senha' => 'required|min:6',
            'confirmar_senha' => 'required|same:senha',
            'termos' => 'accepted',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'telefone.max' => 'O telefone deve ter no máximo 20 caracteres.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'confirmar_senha.required' => 'Você precisa confirmar a senha.',
            'confirmar_senha.same' => 'As senhas não conferem.',
            'termos.accepted' => 'Você precisa aceitar os termos para prosseguir.',
        ]);

        User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'aceitou_termos_em' => now(),
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
