<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthInterfaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_has_a_password_visibility_control(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('data-password-toggle', false)
            ->assertSee('data-password-target="password"', false)
            ->assertSee('aria-label="Mostrar contraseña"', false)
            ->assertSee('bi bi-eye', false);
    }

    public function test_registration_page_has_password_visibility_controls_for_both_password_fields(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('data-password-toggle', false)
            ->assertSee('data-password-target="password"', false)
            ->assertSee('data-password-target="password-confirm"', false)
            ->assertSee('aria-label="Mostrar contraseña"', false)
            ->assertSee('bi bi-eye', false);
    }

    public function test_authenticated_user_sees_logout_confirmation_before_submitting_logout(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('clientes.index'))
            ->assertOk()
            ->assertSee('data-bs-target="#logoutConfirmationModal"', false)
            ->assertSee('id="logoutConfirmationModal"', false)
            ->assertSee('¿Está seguro de que desea cerrar sesión?', false)
            ->assertSee(route('logout'), false)
            ->assertSee('name="_token"', false);
    }
}
