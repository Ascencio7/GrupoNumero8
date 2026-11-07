<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        $pedidos = [
            ['FechaPedido' => '2026-11-01 10:30:00', 'FechaEntrega' => '2026-11-05 14:00:00', 'Observaciones' => 'Entregar en la mañana', 'Id_Cliente' => 1],
            ['FechaPedido' => '2026-11-02 09:15:00', 'FechaEntrega' => '2026-11-06 16:30:00', 'Observaciones' => 'Llamar antes de llegar', 'Id_Cliente' => 2],
            ['FechaPedido' => '2026-11-02 11:45:00', 'FechaEntrega' => '2026-11-07 10:00:00', 'Observaciones' => 'Dejar con el portero', 'Id_Cliente' => 3],
            ['FechaPedido' => '2026-11-03 08:00:00', 'FechaEntrega' => '2026-11-08 12:00:00', 'Observaciones' => null, 'Id_Cliente' => 4],
            ['FechaPedido' => '2026-11-03 15:20:00', 'FechaEntrega' => '2026-11-09 09:30:00', 'Observaciones' => 'Empaque de regalo', 'Id_Cliente' => 5],
            ['FechaPedido' => '2026-11-04 13:10:00', 'FechaEntrega' => '2026-11-10 18:00:00', 'Observaciones' => 'Frágil', 'Id_Cliente' => 6],
            ['FechaPedido' => '2026-11-04 17:50:00', 'FechaEntrega' => '2026-11-11 11:15:00', 'Observaciones' => null, 'Id_Cliente' => 7],
            ['FechaPedido' => '2026-11-05 10:05:00', 'FechaEntrega' => '2026-11-12 15:45:00', 'Observaciones' => 'Cobro contra entrega', 'Id_Cliente' => 8],
            ['FechaPedido' => '2026-11-05 14:30:00', 'FechaEntrega' => '2026-11-13 08:00:00', 'Observaciones' => 'Urgente', 'Id_Cliente' => 9],
            ['FechaPedido' => '2026-11-06 09:00:00', 'FechaEntrega' => '2026-11-14 13:00:00', 'Observaciones' => 'Dejar en recepción', 'Id_Cliente' => 10],
            ['FechaPedido' => '2026-11-06 16:40:00', 'FechaEntrega' => '2026-11-15 17:30:00', 'Observaciones' => null, 'Id_Cliente' => 11],
            ['FechaPedido' => '2026-11-07 08:20:00', 'FechaEntrega' => '2026-11-16 10:30:00', 'Observaciones' => 'Entregar al vecino', 'Id_Cliente' => 12],
        ];

       
        foreach ($pedidos as &$pedido) {
            $pedido['created_at'] = now();
            $pedido['updated_at'] = now();
        }

        DB::table('pedidos')->insert($pedidos);
    }
}