<?php

namespace Tests\Feature;

use Illuminate\Auth\GenericUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CajaTest extends TestCase
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
            $table->time('horaApertura');
            $table->date('fechaApertura');
            $table->decimal('montoApertura', 10, 2);
            $table->time('horaCierre')->nullable();
            $table->date('fechaCierre')->nullable();
            $table->decimal('montoCierre', 10, 2)->nullable();
            $table->unsignedInteger('codUsuario');
        });

        $this->actingAs(new GenericUser([
            'id' => 1,
            'codUsuario' => 1,
            'email' => 'qa@example.test',
        ]), 'web');
    }

    /**
     * @dataProvider montosValidos
     */
    public function test_abre_caja_con_monto_valido($monto)
    {
        $respuesta = $this->from('/caja/apertura_cierre')
            ->post('/caja/apertura_cierre', [
                'montoApertura' => $monto,
            ]);

        $respuesta->assertRedirect('/caja/apertura_cierre');
        $respuesta->assertSessionHas('flash');

        $this->assertDatabaseHas('caja', [
            'montoApertura' => $monto,
            'codUsuario' => 1,
            'montoCierre' => null,
        ]);
    }

    /**
     * @dataProvider montosInvalidos
     */
    public function test_rechaza_apertura_invalida($monto)
    {
        $respuesta = $this->from('/caja/apertura_cierre')
            ->post('/caja/apertura_cierre', [
                'montoApertura' => $monto,
            ]);

        $respuesta->assertSessionHasErrors('montoApertura');

        $this->assertSame(0, DB::table('caja')->count());
    }

    /**
     * @dataProvider montosValidos
     */
    public function test_cierra_caja_con_monto_valido($monto)
    {
        $this->crearCajaAbierta();

        $respuesta = $this->from('/caja/apertura_cierre')
            ->put('/caja/apertura_cierre/1', [
                'montoCierre' => $monto,
            ]);

        $respuesta->assertRedirect('/caja/apertura_cierre');
        $respuesta->assertSessionHas('success');

        $caja = DB::table('caja')->where('codCaja', 1)->first();

        $this->assertEquals($monto, $caja->montoCierre);
        $this->assertNotNull($caja->fechaCierre);
        $this->assertNotNull($caja->horaCierre);
    }

    /**
     * @dataProvider montosInvalidos
     */
    public function test_rechaza_cierre_invalido_y_conserva_caja_abierta($monto)
    {
        $this->crearCajaAbierta();

        $respuesta = $this->from('/caja/apertura_cierre')
            ->put('/caja/apertura_cierre/1', [
                'montoCierre' => $monto,
            ]);

        $respuesta->assertSessionHasErrors('montoCierre');

        $this->assertDatabaseHas('caja', [
            'codCaja' => 1,
            'montoCierre' => null,
            'fechaCierre' => null,
            'horaCierre' => null,
        ]);
    }

    public function montosValidos(): array
    {
        return [
            'monto positivo' => [200],
            'monto cero' => [0],
        ];
    }

    public function montosInvalidos(): array
    {
        return [
            'monto vacio' => [''],
            'monto negativo' => [-10],
            'monto no numerico' => ['texto'],
        ];
    }

    private function crearCajaAbierta(): void
    {
        DB::table('caja')->insert([
            'codCaja' => 1,
            'horaApertura' => '09:00:00',
            'fechaApertura' => '2030-01-11',
            'montoApertura' => 200,
            'codUsuario' => 1,
        ]);
    }
}