<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Vendas</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Relatório de Vendas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendas as $venda)
                <tr>
                    <td>{{ $venda->id }}</td>
                    <td>{{ $venda->created_at->format('d/m/Y') }}</td>
                    <td>{{ $venda->user->name }}</td>
                    <td>{{ $venda->produto->nome }}</td>
                    <td>{{ $venda->quantidade }}</td>
                    <td>R$ {{ number_format($venda->preco_unitario, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
