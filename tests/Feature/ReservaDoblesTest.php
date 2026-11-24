<?php

namespace Tests\Feature;

use App\Http\Controllers\RegistroController;
use Illuminate\Auth\GenericUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ReservaDoblesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (
            config('database.default') !== 'sqlite' ||
            config('database.connections.sqlite.database') !== ':memory:'
        ) {
            throw new \RuntimeException(
                'Estas pruebas requieren SQLite en memoria.'
            );
        }

        Schema::create('localidad', function (Blueprint $table) {
            $table->increments('codLocalidad');
            $table->decimal('precioDia', 10, 2);
            $table->decimal('precioNoche', 10, 2);
        });

        Schema::create('registro', function (Blueprint $table) {
            $table->increments('codRegistro');
            $table->unsignedInteger('codUsuario');
            $table->unsignedInteger('codCliente');
            $table->unsignedInteger('codLocalidad');
            $table->date('fechRegistro');
            $table->time('horainicio');
            $table->time('horafinal');
            $table->string('duracion');
            $table->string('tarifa');
            $table->decimal('costoTarifa', 10, 2);
            $table->string('estado');
            $table->text('comentario')->nullable();
        });

        DB::table('localidad')->insert([
            'codLocalidad' => 1,
            'precioDia' => 80,
            'precioNoche' => 100,
        ]);

        $this->actingAs(new GenericUser([
            'id' => 1,
            'codUsuario' => 1,
            'email' => 'qa@example.test',
        ]), 'web');
    }

    public function test_stub_de_horario_ocupado_impide_guardar()
    {
        // Stub parcial: respuesta predefinida de disponibilidad.
        $controlador = $this->getMockBuilder(RegistroController::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['validarFecha'])
            ->getMock();

        $controlador->method('validarFecha')
            ->willReturn(false);

        $respuesta = $controlador->guardar($this->solicitud());

        $datos = $respuesta->getData(true);

        $this->assertFalse($datos['ok']);

        $this->assertSame(
            'El registro interfiere con otra reserva o la fecha seleccionada es menor a la fecha actual',
            $datos['mensaje']
        );

        $this->assertSame(0, DB::table('registro')->count());
    }

    public function test_mock_verifica_consulta_y_guarda_reserva_disponible()
    {
        // Mock parcial: verificar la interacción con validarFecha().
        $controlador = $this->getMockBuilder(RegistroController::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['validarFecha'])
            ->getMock();

        $controlador->expects($this->once())
            ->method('validarFecha')
            ->with(
                -1,
                1,
                '2030-01-11',
                '18:00:00',
                '19:00:00'
            )
            ->willReturn(true);

        $respuesta = $controlador->guardar($this->solicitud());

        $datos = $respuesta->getData(true);

        $this->assertTrue($datos['ok']);

        $this->assertSame(1, DB::table('registro')->count());

        $this->assertDatabaseHas('registro', [
            'codRegistro' => $datos['mensaje'],
            'codUsuario' => 1,
            'codCliente' => 1,
            'codLocalidad' => 1,
            'fechRegistro' => '2030-01-11',
            'horainicio' => '18:00:00',
            'horafinal' => '19:00:00',
            'tarifa' => 'noche',
            'costoTarifa' => 100,
            'estado' => 'SIN CONFIRMAR',
        ]);
    }

    private function solicitud(): Request
    {
        return Request::create('/registro/guardar', 'POST', [
            'ddlLocalidad' => 1,
            'ddlClientes' => 1,
            'txtFecha' => '2030-01-11',
            'txtHoraInicial' => '18:00:00',
            'txtHoraFinal' => '19:00:00',
            'txtTiempo' => '60',
            'txtTarifa' => 'noche',
            'txtComentario' => 'Reserva de prueba con doble parcial',
        ]);
    }
}