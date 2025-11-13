<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome', 'descricao', 'preco', 'imagem', 'categoria',
        'estoque', 'status',
    ];

    public $timestamps = true;

    public function vendas(): HasMany
    {
        return $this->hasMany(Venda::class);
    }
}
