<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado');
    }

    public function destroy(Cliente $cliente)
    {
        DB::transaction(function () use ($cliente): void {
            $cliente->pedidos()->delete();
            $cliente->delete();
        });

        return redirect()->route('clientes.index')->with('success', 'Cliente y sus pedidos eliminados');
    }

    // Reporte de todos los clientes (Paso 10)
    public function reporteTodos()
    {
        $clientes = Cliente::all();

        return view('reportes.clientes', compact('clientes'));
    }

    public function reportePdf(): Response
    {
        $rows = Cliente::query()
            ->orderBy('Id_Cliente')
            ->get()
            ->map(static fn (Cliente $cliente): array => [
                $cliente->Id_Cliente,
                $cliente->Nombre.' '.$cliente->Apellido,
                Carbon::parse($cliente->Fecha_Nac)->format('d/m/Y h:i A'),
            ])
            ->all();

        return SnappyPdf::loadView('reportes.pdf', [
            'title' => 'Reporte de clientes',
            'subtitle' => 'Directorio de clientes registrados',
            'headers' => ['ID', 'Nombre completo', 'Fecha de nacimiento'],
            'rows' => $rows,
            'generatedAt' => now(config('app.timezone'))->format('d/m/Y h:i A'),
        ])
            ->setPaper('a4')
            ->setOption('encoding', 'UTF-8')
            ->download('reporte-clientes.pdf');
    }
}
