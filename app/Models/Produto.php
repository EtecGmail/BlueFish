<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome', 'descricao', 'preco', 'imagem', 'categoria', 
        'estoque', 'status', 'data_criacao', 'data_atualizacao'
    ];

    public $timestamps = false;
}