@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@push('styles')
<style>
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 1.5rem;
        text-align: center;
    }
    .card h3 {
        margin-top: 0;
        font-size: 1rem;
        color: #555;
    }
    .card p {
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
    }
    .chart-card, .table-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-top: 2rem;
    }
    .table-container {
        margin-top: 1rem;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    th {
        font-weight: 600;
    }
    .export-buttons {
        margin-bottom: 1rem;
        display: flex;
        gap: 0.5rem;
    }
    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        font-size: 0.875rem;
    }
    .btn-excel { background-color: #217346; }
    .btn-csv { background-color: #7a7a7a; }
    .btn-pdf { background-color: #b30b00; }
</style>
@endpush

@section('content')
<header class="dashboard-header">
    <h1>Dashboard</h1>
</header>

<main>
    <section class="card-grid" aria-label="Estatísticas gerais">
        <div class="card">
            <h3>Total de Usuários</h3>
            <p>{{ $stats['usuarios'] }}</p>
        </div>
        <div class="card">
            <h3>Total de Produtos</h3>
            <p>{{ $stats['produtos'] }}</p>
        </div>
        <div class="card">
            <h3>Total de Vendas</h3>
            <p>{{ $stats['vendas'] }}</p>
        </div>
    </section>

    <section class="chart-card" aria-label="Gráfico de produtos mais vendidos">
        <h2>Produtos Mais Vendidos</h2>
        <canvas id="produtosMaisVendidosChart" aria-label="Gráfico de barras mostrando os 5 produtos mais vendidos" style="position: relative; height: 40vh; width: 80vw;"></canvas>
    </section>

    <section class="table-card" aria-label="Tabela de vendas recentes">
        <h2>Vendas Recentes</h2>
        <div class="export-buttons">
            <a href="{{ route('admin.export.excel') }}" class="btn btn-excel">Exportar para Excel</a>
            <a href="{{ route('admin.export.csv') }}" class="btn btn-csv">Exportar para CSV</a>
            <a href="{{ route('admin.export.pdf') }}" class="btn btn-pdf">Exportar para PDF</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendasRecentes as $venda)
                        <tr>
                            <td>{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $venda->user->name }}</td>
                            <td>{{ $venda->produto->nome }}</td>
                            <td>R$ {{ number_format($venda->preco_unitario, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhuma venda registrada ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('produtosMaisVendidosChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Quantidade de Vendas',
                        data: @json($chartData['data']),
                        backgroundColor: 'rgba(0, 123, 255, 0.5)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    });
</script>
@endsection
