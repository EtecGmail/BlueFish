<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nome' => 'Salmão Fresco',
                'descricao' => 'Salmão do Atlântico',
                'preco' => 49.90,
                'imagem' => 'img/salmao.jpg',
            ],
            [
                'nome' => 'Atum',
                'descricao' => 'Atum fresco',
                'preco' => 39.90,
                'imagem' => 'img/atum.jpg',
            ],
        ];

        foreach ($items as $item) {
            Produto::updateOrCreate(['nome' => $item['nome']], $item);
        }
    }
}
