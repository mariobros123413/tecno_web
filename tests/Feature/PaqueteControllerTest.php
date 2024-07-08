<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Paquete;
use Illuminate\Support\Facades\Redirect;


class PaqueteControllerTest extends TestCase
{
    use RefreshDatabase; // Utilizamos RefreshDatabase para asegurarnos de que las pruebas no afecten a la base de datos principal

    /**
     * Test para la función store en el controlador PaqueteController.
     *
     * @return void
     */
    public function test_paquete_creation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.paquete.store'), [
            'dimensiones' => '10x10x5',
            'peso' => 2.5,
        ]);

        $response->assertRedirect(route('admin.paquete.create')); // Verifica que se redirige correctamente
        $response->assertSessionHasNoErrors(); // Verifica que no hay errores en la sesión

        $paquete = Paquete::latest()->first(); // Obtiene el último paquete creado

        $this->assertNotNull($paquete); // Verifica que se ha creado un paquete
        $this->assertSame('10x10x5', $paquete->dimensiones); // Verifica las dimensiones del paquete

        // Convierte el peso del paquete a una cadena con un formato específico ('2.5')
        $formattedPeso = number_format($paquete->peso, 1, '.', ''); // Formatea el peso a 1 decimal sin separador de miles
        $this->assertSame('2.5', $formattedPeso); // Verifica el peso del paquete
    }
}
