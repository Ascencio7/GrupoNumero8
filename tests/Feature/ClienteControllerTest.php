<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_a_customer_also_deletes_its_orders_but_preserves_other_customers(): void
    {
        $this->actingAs(User::factory()->create());
        $cliente = Cliente::create([
            'Nombre' => 'Cliente',
            'Apellido' => 'Con pedidos',
            'Fecha_Nac' => '1990-04-02 00:00:00',
        ]);
        $otroCliente = Cliente::create([
            'Nombre' => 'Otro',
            'Apellido' => 'Cliente',
            'Fecha_Nac' => '1992-05-03 00:00:00',
        ]);
        $pedido = Pedido::create([
            'FechaPedido' => '2026-11-07 08:15:00',
            'FechaEntrega' => '2026-11-09 16:45:00',
            'Observaciones' => null,
            'Id_Cliente' => $cliente->Id_Cliente,
        ]);
        $otroPedido = Pedido::create([
            'FechaPedido' => '2026-11-07 09:15:00',
            'FechaEntrega' => '2026-11-09 17:45:00',
            'Observaciones' => null,
            'Id_Cliente' => $otroCliente->Id_Cliente,
        ]);

        $response = $this->delete(route('clientes.destroy', $cliente->Id_Cliente));

        $response->assertRedirect(route('clientes.index'));
        $response->assertSessionHas('success', 'Cliente y sus pedidos eliminados');
        $this->assertDatabaseMissing('clientes', ['Id_Cliente' => $cliente->Id_Cliente]);
        $this->assertDatabaseMissing('pedidos', ['Id_Pedido' => $pedido->Id_Pedido]);
        $this->assertDatabaseHas('clientes', ['Id_Cliente' => $otroCliente->Id_Cliente]);
        $this->assertDatabaseHas('pedidos', [
            'Id_Pedido' => $otroPedido->Id_Pedido,
            'Id_Cliente' => $otroCliente->Id_Cliente,
        ]);
    }
}
