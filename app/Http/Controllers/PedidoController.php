<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente')->get();

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();

        return view('pedidos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        Pedido::create($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado');
    }

    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::all();

        return view('pedidos.edit', compact('pedido', 'clientes'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $pedido->update($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado');
    }

    // Reporte de todos los pedidos (Paso 10)
    public function reporteTodos()
    {
        $pedidos = Pedido::with('cliente')->get();

        return view('reportes.pedidos', compact('pedidos'));
    }

    public function reportePdf(): Response
    {
        $rows = Pedido::query()
            ->with('cliente')
            ->orderBy('Id_Pedido')
            ->get()
            ->map(static fn (Pedido $pedido): array => [
                $pedido->Id_Pedido,
                Carbon::parse($pedido->FechaPedido)->format('d/m/Y h:i A'),
                Carbon::parse($pedido->FechaEntrega)->format('d/m/Y h:i A'),
                $pedido->cliente->Nombre.' '.$pedido->cliente->Apellido,
                $pedido->Observaciones ?? 'Ninguna',
            ])
            ->all();

        return SnappyPdf::loadView('reportes.pdf', [
            'title' => 'Reporte de pedidos',
            'subtitle' => 'Pedidos registrados y sus clientes',
            'headers' => ['ID', 'Fecha del pedido', 'Fecha de entrega', 'Cliente', 'Observaciones'],
            'rows' => $rows,
            'generatedAt' => now(config('app.timezone'))->format('d/m/Y h:i A'),
        ])
            ->setPaper('a4', 'landscape')
            ->setOption('encoding', 'UTF-8')
            ->download('reporte-pedidos.pdf');
    }

    // Reporte pedidos por cliente (Paso 9)
    public function reportePorCliente(Request $request)
    {
        $clientes = Cliente::all();
        $pedidos = [];

        if ($request->has('Id_Cliente') && $request->Id_Cliente != '') {
            $pedidos = Pedido::where('Id_Cliente', $request->Id_Cliente)->get();
        }

        return view('reportes.por_cliente', compact('clientes', 'pedidos'));
    }

    public function reportePorClientePdf(Request $request): Response
    {
        $validated = $request->validate([
            'Id_Cliente' => ['required', 'integer', 'exists:clientes,Id_Cliente'],
        ]);
        $cliente = Cliente::findOrFail($validated['Id_Cliente']);
        $rows = Pedido::query()
            ->where('Id_Cliente', $cliente->Id_Cliente)
            ->orderBy('Id_Pedido')
            ->get()
            ->map(static fn (Pedido $pedido): array => [
                $pedido->Id_Pedido,
                Carbon::parse($pedido->FechaPedido)->format('d/m/Y h:i A'),
                Carbon::parse($pedido->FechaEntrega)->format('d/m/Y h:i A'),
                $pedido->Observaciones ?? 'Ninguna',
            ])
            ->all();

        return SnappyPdf::loadView('reportes.pdf', [
            'title' => 'Reporte de pedidos por cliente',
            'subtitle' => $cliente->Nombre.' '.$cliente->Apellido,
            'headers' => ['ID pedido', 'Fecha del pedido', 'Fecha de entrega', 'Observaciones'],
            'rows' => $rows,
            'generatedAt' => now(config('app.timezone'))->format('d/m/Y h:i A'),
        ])
            ->setPaper('a4', 'landscape')
            ->setOption('encoding', 'UTF-8')
            ->download('reporte-pedidos-cliente-'.$cliente->Id_Cliente.'.pdf');
    }
}
