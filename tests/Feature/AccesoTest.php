<?php

namespace Tests\Feature;

use Tests\TestCase;

class AccesoTest extends TestCase
{
    public function test_la_pantalla_de_login_carga_correctamente()
    {
        $respuesta = $this->get('/');

        $respuesta->assertStatus(200);
        $respuesta->assertSee('INICIAR SESIÓN');
    }

    public function test_el_login_rechaza_campos_vacios()
    {
        $respuesta = $this->from('/')->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $respuesta->assertRedirect('/');
        $respuesta->assertSessionHasErrors([
            'email',
            'password',
        ]);

        $this->assertGuest('web');
    }

    public function test_el_login_rechaza_un_correo_con_formato_invalido()
    {
        $respuesta = $this->from('/')->post('/login', [
            'email' => 'correo-invalido',
            'password' => 'ClaveDePrueba123!',
        ]);

        $respuesta->assertRedirect('/');
        $respuesta->assertSessionHasErrors('email');

        $this->assertGuest('web');
    }
}