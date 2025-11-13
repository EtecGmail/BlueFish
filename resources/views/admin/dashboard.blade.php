@extends('layouts.admin')

@section('title', 'Dashboard - Bluefish')

@section('content')
    <div class="admin-container">
        <main class="admin-content">
            <div class="admin-header">
                <h1>Painel Administrativo</h1>
                <div class="admin-user">
                    <div style="width:40px;height:40px;border-radius:50%;background:#cfe1ff;"></div>
                    <div class="admin-user-info">
                        <div class="admin-user-name">{{ auth()->user()->name }}</div>
                        <div class="admin-user-role">Administrador</div>
                    </div>
                </div>
            </div>

            <section class="admin-stats">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Usuários</div>
                        <div class="stat-card-icon primary"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['usuarios'] }}</div>
                    <div class="stat-card-change positive">+0 hoje</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Produtos</div>
                        <div class="stat-card-icon success"><i class="fas fa-fish"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['produtos'] }}</div>
                    <div class="stat-card-change positive">+0 hoje</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Contatos</div>
                        <div class="stat-card-icon warning"><i class="fas fa-envelope"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['contatos'] }}</div>
                    <div class="stat-card-change">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Vendas</div>
                        <div class="stat-card-icon danger"><i class="fas fa-receipt"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['vendas'] }}</div>
                    <div class="stat-card-change positive">Faturamento R$ {{ number_format($stats['faturamento'], 2, ',', '.') }}</div>
                </div>
            </section>

            <section class="grid grid-2" style="margin-bottom: 2rem;">
                <div class="card">
                    <div class="card-content">
                        <h3 class="card-title">Peixes mais vendidos (Google Charts)</h3>
                        <div id="chart-pizza" style="width: 100%; height: 320px;"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h3 class="card-title">Volume de vendas por produto (ECharts)</h3>
                        <div id="chart-colunas" style="width: 100%; height: 320px;"></div>
                    </div>
                </div>
            </section>

            <section class="admin-table">
                <div class="admin-table-header">
                    <h2 class="admin-table-title">Últimas vendas</h2>
                    <div class="admin-table-actions">
                        <a href="{{ route('produtos.index') }}" class="btn btn-primary">Ver Produtos</a>
                        <a href="{{ route('contato.form') }}" class="btn btn-secondary">Criar Aviso</a>
                    </div>
                </div>
                <div class="admin-table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Cliente</th>
                                <th>Quantidade</th>
                                <th>Valor total</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentes as $venda)
                                <tr>
                                    <td>{{ optional($venda->produto)->nome ?? 'Produto removido' }}</td>
                                    <td>{{ optional($venda->user)->name ?? 'Cliente removido' }}</td>
                                    <td>{{ $venda->quantidade }}</td>
                                    <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                                    <td>{{ optional($venda->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($venda->produto)
                                            <a href="{{ route('produto.show', $venda->produto->id) }}" class="btn btn-primary">Ver produto</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Sem vendas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
@endsection

@section('scripts')
<script type="application/json" id="topProdutosData">{!! json_encode($topProdutos) !!}</script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
<script>
    // Dados do controller para os gráficos
    const topProdutosEl = document.getElementById('topProdutosData');
    const topProdutos = topProdutosEl ? JSON.parse(topProdutosEl.textContent || '[]') : [];

    // Google Charts - Pizza
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(function() {
        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Produto');
        data.addColumn('number', 'Quantidade');
        data.addRows(topProdutos.map(p => [p.nome, p.quantidade]));
        const options = {
            legend: { position: 'bottom' },
            chartArea: { width: '90%', height: '80%' }
        };
        const chart = new google.visualization.PieChart(document.getElementById('chart-pizza'));
        chart.draw(data, options);
    });

    // ECharts - Colunas
    const el = document.getElementById('chart-colunas');
    if (el) {
        const chart = echarts.init(el);
        const option = {
            tooltip: {
                trigger: 'axis',
                formatter: function(params) {
                    if (!params.length) {
                        return '';
                    }
                    const item = params[0];
                    const produto = topProdutos[item.dataIndex];
                    const valor = produto ? produto.valor_total : 0;
                    return `${item.name}<br/>Quantidade: ${item.value}<br/>Faturamento: R$ ${Number(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
                }
            },
            xAxis: {
                type: 'category',
                data: topProdutos.map(p => p.nome),
                axisLabel: { interval: 0 }
            },
            yAxis: { type: 'value' },
            series: [{
                type: 'bar',
                data: topProdutos.map(p => p.quantidade),
                itemStyle: { color: '#0066cc' }
            }],
            grid: { left: '3%', right: '4%', bottom: '10%', containLabel: true }
        };
        chart.setOption(option);
        window.addEventListener('resize', () => chart.resize());
    }
</script>
@endsection


