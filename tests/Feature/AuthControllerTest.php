<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase; // Para usar la base de datos en memoria y limpiarla en cada test

    /**
     * Test de registro exitoso.
     */
    public function test_registro_exitoso()
    {
        // Datos de prueba para el registro
        $data = [
            'name' => 'Usuario de Prueba',
            'email' => 'usuario@prueba.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Llamar al endpoint de registro
        $response = $this->postJson('/api/registro', $data);

        // Verificar que el usuario fue creado y se devuelve el token
        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);

        // Verificar que el usuario existe en la base de datos
        $this->assertDatabaseHas('users', [
            'email' => 'usuario@prueba.com',
        ]);
    }

    /**
     * Test de registro con errores de validación.
     */
    public function test_registro_falla_por_validacion()
    {
        // Datos de prueba incompletos
        $data = [
            'name' => '',
            'email' => 'correo-invalido',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ];

        // Llamar al endpoint de registro
        $response = $this->postJson('/api/registro', $data);

        // Verificar que se devuelven errores de validación
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * Test de registro con un correo duplicado.
     */
    public function test_registro_falla_por_correo_duplicado()
    {
        // Crear un usuario en la base de datos
        User::factory()->create([
            'email' => 'usuario@prueba.com',
        ]);

        // Datos de prueba con un correo ya registrado
        $data = [
            'name' => 'Nuevo Usuario',
            'email' => 'usuario@prueba.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Llamar al endpoint de registro
        $response = $this->postJson('/api/registro', $data);

        // Verificar que se devuelve un error de validación
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }
}
