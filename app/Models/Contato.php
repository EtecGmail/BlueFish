<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contatos';

    protected $fillable = [
        'nome', 'email', 'telefone', 'assunto', 'mensagem', 'status',
        'data_envio', 'data_atualizacao'
    ];

    public $timestamps = false;
}