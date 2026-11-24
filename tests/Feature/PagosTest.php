<?php

namespace Tests\Feature;

use Illuminate\Auth\GenericUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PagosTest extends TestCase
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

        Schema::create('caja', function (Blueprint $table) {
            $table->increments('codCaja');
            $table->decimal('montoCierre', 10, 2)->nullable();
        });

        Schema::create('registro', function (Blueprint $table) {
            $table->increments('codRegistro');
            $table->decimal('costoTarifa', 10, 2);
        });

        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('idPago');
            $table->dateTime('fechaPago');
            $table->string('metodoPago', 91);
            $table->decimal('importePago', 10, 2);
            $table->unsignedInteger('codRegistro');
            $table->unsignedInteger('codCaja');
        });

        DB::table('caja')->insert([
            'codCaja' => 1,
            'montoCierre' => null,
        ]);

        DB::table('registro')->insert([
            'codRegistro' => 1,
            'costoTarifa' => 100,
        ]);

        // Usuario de prueba sin consultar la tabla de usuarios.
        $this->actingAs(new GenericUser([
            'id' => 1,
            'codUsuario' => 1,
            'email' => 'qa@example.test',
        ]), 'web');
    }

    public function test_registra_un_pago_valido_en_la_caja_abierta()
    {
        $respuesta = $this->from('/reporte/rango/1')
            ->post('/store_pago', [
                'metodoPago' => 'EFECTIVO',
                'importePago' => 40,
                'codRegistro' => 1,
            ]);

        $respuesta->assertRedirect('/reporte/rango/1');
        $respuesta->assertSessionHas('success');

        $this->assertDatabaseHas('pagos', [
            'metodoPago' => 'EFECTIVO',
            'importePago' => 40,
            'codRegistro' => 1,
            'codCaja' => 1,
        ]);
    }

    /**
     * @dataProvider datosInvalidos
     */
    public function test_rechaza_datos_invalidos_sin_guardar_el_pago(
        $metodo,
        $importe,
        $campo
    ) {
        $respuesta = $this->from('/reporte/rango/1')
            ->post('/store_pago', [
                'metodoPago' => $metodo,
                'importePago' => $importe,
                'codRegistro' => 1,
            ]);

        $respuesta->assertRedirect('/reporte/rango/1');
        $respuesta->assertSessionHasErrors($campo);

        $this->assertSame(0, DB::table('pagos')->count());
    }

    public function datosInvalidos(): array
    {
        return [
            'metodo obligatorio' => ['', 40, 'metodoPago'],
            'importe obligatorio' => ['EFECTIVO', '', 'importePago'],
            'importe no numerico' => ['EFECTIVO', 'texto', 'importePago'],
            'importe negativo' => ['EFECTIVO', -10, 'importePago'],
            'importe cero' => ['EFECTIVO', 0, 'importePago'],
        ];
    }

    public function test_reserva_sin_pagos_no_esta_pagada()
    {
        $this->assertFalse(
            \App\Http\Controllers\ReporteRangoController::estadoPago(1)
        );
    }

    public function test_pago_parcial_no_completa_la_reserva()
    {
        $this->crearPago(40);

        $this->assertFalse(
            \App\Http\Controllers\ReporteRangoController::estadoPago(1)
        );
    }

    public function test_dos_abonos_completan_el_importe_de_la_reserva()
    {
        $this->crearPago(40);
        $this->crearPago(60);

        $this->assertTrue(
            \App\Http\Controllers\ReporteRangoController::estadoPago(1)
        );
    }

    private function crearPago($importe): void
    {
        DB::table('pagos')->insert([
            'fechaPago' => '2030-01-11 12:00:00',
            'metodoPago' => 'EFECTIVO',
            'importePago' => $importe,
            'codRegistro' => 1,
            'codCaja' => 1,
        ]);
    }
}