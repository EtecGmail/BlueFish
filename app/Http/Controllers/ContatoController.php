<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contato;
use Illuminate\Routing\Controller;

class ContatoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email',
            'telefone' => 'nullable',
            'assunto' => 'required',
            'mensagem' => 'required'
        ]);

        Contato::create($request->all());

        return redirect()->back()->with('sucesso', 'Mensagem enviada com sucesso!');
    }
}
