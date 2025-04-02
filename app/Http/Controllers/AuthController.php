<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && password_verify($request->senha, $usuario->senha)) {
            Session::put('usuario_id', $usuario->id);
            Session::put('usuario_nome', $usuario->nome);

            // Adiciona mensagem de sucesso
            return redirect('/')->with('sucesso', 'Login realizado com sucesso!');
        }

        // Se falhou, mensagem de erro
        return redirect()->back()->with('erro', 'Email ou senha incorretos.');
    }

        public function register(Request $request)
    {
        // Validação com mensagens customizadas
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|min:6',
            'confirmar_senha' => 'required|same:senha'
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está em uso.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'confirmar_senha.required' => 'Você precisa confirmar a senha.',
            'confirmar_senha.same' => 'As senhas não conferem.'
        ]);

        try {
            Usuario::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'senha' => password_hash($request->senha, PASSWORD_DEFAULT),
                'telefone' => $request->telefone
            ]);

            return redirect('/login')->with('sucesso', 'Cadastro realizado com sucesso!');
        } catch (\Exception $e) {
            // Caso ocorra algum erro durante a inserção no banco, retorna com uma mensagem de erro
            return redirect()->back()->with('erro', 'Ocorreu um erro ao tentar realizar o cadastro: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Método de logout que zera a sessão e redireciona.
     */
    public function logout()
    {
        session()->flush();
        return redirect('/')->with('sucesso', 'Você saiu da sua conta.');
    }
}