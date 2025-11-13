<?php

namespace App\Http\Controllers;

use App\Exports\VendasExport;
use App\Models\User;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;

class AdminController extends \Illuminate\Routing\Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'stats' => $this->getStats(),
            'chartData' => $this->getChartData(),
            'vendasRecentes' => $this->getVendasRecentes(),
        ]);
    }

    private function getStats(): array
    {
        return [
            'usuarios' => User::count(),
            'produtos' => Produto::count(),
            'vendas' => Venda::count(),
        ];
    }

    private function getChartData(): array
    {
        $produtosMaisVendidos = Venda::select('produto_id', DB::raw('count(*) as total_vendas'))
            ->groupBy('produto_id')
            ->orderBy('total_vendas', 'desc')
            ->limit(5)
            ->with('produto')
            ->get();

        return [
            'labels' => $produtosMaisVendidos->map(fn($v) => $v->produto->nome),
            'data' => $produtosMaisVendidos->map(fn($v) => $v->total_vendas),
        ];
    }

    private function getVendasRecentes()
    {
        return Venda::with(['user', 'produto'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function exportExcel()
    {
        return Excel::download(new VendasExport, 'vendas.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new VendasExport, 'vendas.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportPdf()
    {
        $vendas = Venda::with(['user', 'produto'])->get();
        $html = view('admin.exports.vendas_pdf', compact('vendas'))->render();

        $options = new Options();
        $options->set('defaultFont', 'sans-serif');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('relatorio_vendas.pdf');
    }
}
