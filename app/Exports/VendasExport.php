<?php

namespace App\Exports;

use App\Models\Venda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VendasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Venda::with(['user', 'produto'])->get();
    }

    /**
     * @param Venda $venda
     * @return array
     */
    public function map($venda): array
    {
        return [
            $venda->id,
            $venda->created_at->format('d/m/Y H:i'),
            $venda->user->name,
            $venda->produto->nome,
            $venda->quantidade,
            $venda->preco_unitario,
        ];
    }

    public function headings(): array
    {
        return [
            'ID da Venda',
            'Data',
            'Cliente',
            'Produto',
            'Quantidade',
            'Preço Unitário',
        ];
    }
}
