<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_clients_report_downloads_a_monochrome_pdf_with_twelve_hour_times(): void
    {
        $this->actingAs(User::factory()->create());
        config()->set('app.timezone', 'America/El_Salvador');
        $this->travelTo(CarbonImmutable::parse('2026-11-07 20:00:00', 'UTC'));
        Cliente::create([
            'Nombre' => 'Lucia',
            'Apellido' => 'Gomez',
            'Fecha_Nac' => '1990-04-02 14:05:00',
        ]);
        PDF::fake();

        $response = $this->get(route('reportes.clientes.pdf'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename="reporte-clientes.pdf"');
        PDF::assertViewIs('reportes.pdf');
        PDF::assertSee('02/04/1990 02:05 PM');
        PDF::assertSee('color: #111;');
        PDF::assertSee('Generado: 07/11/2026 02:00 PM');
    }

    public function test_orders_report_includes_customer_and_twelve_hour_dates(): void
    {
        $this->actingAs(User::factory()->create());
        $cliente = Cliente::create([
            'Nombre' => 'Carlos',
            'Apellido' => 'Lopez',
            'Fecha_Nac' => '1990-04-02 00:00:00',
        ]);
        Pedido::create([
            'FechaPedido' => '2026-11-07 14:05:00',
            'FechaEntrega' => '2026-11-08 09:30:00',
            'Observaciones' => 'Entregar por la tarde',
            'Id_Cliente' => $cliente->Id_Cliente,
        ]);
        PDF::fake();

        $response = $this->get(route('reportes.pedidos.pdf'));

        $response->assertOk();
        $response->assertHeader('Content-Disposition', 'attachment; filename="reporte-pedidos.pdf"');
        PDF::assertViewHas('headers', ['ID', 'Fecha del pedido', 'Fecha de entrega', 'Cliente', 'Observaciones']);
        PDF::assertSee('07/11/2026 02:05 PM');
        PDF::assertSee('08/11/2026 09:30 AM');
        PDF::assertSee('Carlos Lopez');
    }

    public function test_customer_orders_report_downloads_only_the_selected_customers_orders(): void
    {
        $this->actingAs(User::factory()->create());
        $cliente = Cliente::create([
            'Nombre' => 'Ana',
            'Apellido' => 'Perez',
            'Fecha_Nac' => '1992-01-03 00:00:00',
        ]);
        Pedido::create([
            'FechaPedido' => '2026-11-07 08:15:00',
            'FechaEntrega' => '2026-11-09 16:45:00',
            'Observaciones' => null,
            'Id_Cliente' => $cliente->Id_Cliente,
        ]);
        PDF::fake();

        $response = $this->get(route('reportes.por_cliente.pdf', ['Id_Cliente' => $cliente->Id_Cliente]));

        $response->assertOk();
        $response->assertHeader('Content-Disposition', 'attachment; filename="reporte-pedidos-cliente-'.$cliente->Id_Cliente.'.pdf"');
        PDF::assertSee('Ana Perez');
        PDF::assertSee('07/11/2026 08:15 AM');
        PDF::assertSee('09/11/2026 04:45 PM');
        PDF::assertSee('Ninguna');
    }

    public function test_customer_orders_pdf_requires_an_existing_customer(): void
    {
        $this->actingAs(User::factory()->create());
        PDF::fake();

        $response = $this->get(route('reportes.por_cliente.pdf', ['Id_Cliente' => 999]));

        $response->assertSessionHasErrors('Id_Cliente');
    }

    public function test_pdf_reports_require_authentication(): void
    {
        PDF::fake();

        $response = $this->get(route('reportes.clientes.pdf'));

        $response->assertRedirect(route('login'));
    }

    public function test_delete_buttons_open_a_named_confirmation_modal(): void
    {
        $this->actingAs(User::factory()->create());
        $cliente = Cliente::create([
            'Nombre' => 'Luis',
            'Apellido' => 'Garcia',
            'Fecha_Nac' => '1990-04-02 00:00:00',
        ]);
        Pedido::create([
            'FechaPedido' => '2026-11-07 08:15:00',
            'FechaEntrega' => '2026-11-09 16:45:00',
            'Observaciones' => null,
            'Id_Cliente' => $cliente->Id_Cliente,
        ]);

        $this->get(route('clientes.index'))
            ->assertOk()
            ->assertSee('data-bs-target="#deleteConfirmationModal"', false)
            ->assertSee('id="deleteConfirmationModal"', false)
            ->assertSee('Eliminar registro', false)
            ->assertSee('aria-label="Eliminar registro de cliente"', false)
            ->assertSee('data-delete-message="¿Está seguro de que desea eliminar este cliente? Esta acción no se puede deshacer."', false)
            ->assertDontSee('window.confirm', false);

        $this->get(route('pedidos.index'))
            ->assertOk()
            ->assertSee('data-bs-target="#deleteConfirmationModal"', false)
            ->assertSee('id="deleteConfirmationModal"', false)
            ->assertSee('Eliminar registro', false)
            ->assertSee('aria-label="Eliminar registro de pedido"', false)
            ->assertSee('data-delete-message="¿Está seguro de que desea eliminar este pedido? Esta acción no se puede deshacer."', false)
            ->assertDontSee('window.confirm', false);
    }

    public function test_report_pages_link_to_their_pdf_downloads(): void
    {
        $this->actingAs(User::factory()->create());
        $cliente = Cliente::create([
            'Nombre' => 'Sofia',
            'Apellido' => 'Lopez',
            'Fecha_Nac' => '1990-04-02 00:00:00',
        ]);

        $this->get(route('reportes.clientes'))
            ->assertOk()
            ->assertSee(route('reportes.clientes.pdf'), false);

        $this->get(route('reportes.pedidos'))
            ->assertOk()
            ->assertSee(route('reportes.pedidos.pdf'), false);

        $this->get(route('reportes.por_cliente', ['Id_Cliente' => $cliente->Id_Cliente]))
            ->assertOk()
            ->assertSee(route('reportes.por_cliente.pdf', ['Id_Cliente' => $cliente->Id_Cliente]), false);
    }
}
