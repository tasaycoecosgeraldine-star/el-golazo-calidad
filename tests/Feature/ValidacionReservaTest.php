<?php

namespace Tests\Feature;

use App\Http\Controllers\RegistroController;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ValidacionReservaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Evitar que estas pruebas trabajen sobre la base local.
        if (
            config('database.default') !== 'sqlite' ||
            config('database.connections.sqlite.database') !== ':memory:'
        ) {
            throw new \RuntimeException(
                'Estas pruebas requieren SQLite en memoria.'
            );
        }

        // Fecha fija para que el resultado no dependa del día de ejecución.
        Carbon::setTestNow(
            Carbon::create(2030, 1, 10, 12, 0, 0, 'America/Lima')
        );

        // Estructura mínima requerida por validarFecha().
        Schema::create('registro', function (Blueprint $table) {
            $table->increments('codRegistro');
            $table->unsignedInteger('codLocalidad');
            $table->date('fechRegistro');
            $table->time('horainicio');
            $table->time('horafinal');
        });

        DB::table('registro')->insert([
            'codRegistro' => 1,
            'codLocalidad' => 1,
            'fechRegistro' => '2030-01-11',
            'horainicio' => '18:00:00',
            'horafinal' => '20:00:00',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    /**
     * @dataProvider escenariosDeHorario
     */
    public function test_valida_disponibilidad_de_horarios(
        $localidad,
        $inicio,
        $fin,
        $esperado
    ) {
        $controlador = new RegistroController();

        $resultado = $controlador->validarFecha(
            -1,
            $localidad,
            '2030-01-11',
            $inicio,
            $fin
        );

        $this->assertSame($esperado, $resultado);
    }

    public function escenariosDeHorario(): array
    {
        return [
            'permite un horario libre' => [
                1, '21:00:00', '22:00:00', true,
            ],
            'rechaza un horario identico' => [
                1, '18:00:00', '20:00:00', false,
            ],
            'rechaza un cruce al inicio' => [
                1, '17:00:00', '19:00:00', false,
            ],
            'rechaza un cruce al final' => [
                1, '19:00:00', '21:00:00', false,
            ],
            'rechaza un horario contenido en otra reserva' => [
                1, '18:30:00', '19:00:00', false,
            ],
            'permite el mismo horario en otra localidad' => [
                2, '18:00:00', '20:00:00', true,
            ],
        ];
    }

    public function test_rechaza_una_fecha_pasada()
    {
        $controlador = new RegistroController();

        $resultado = $controlador->validarFecha(
            -1,
            1,
            '2030-01-09',
            '15:00:00',
            '16:00:00'
        );

        $this->assertFalse($resultado);
    }

    public function test_excluye_la_propia_reserva_al_validar_una_edicion()
    {
        $controlador = new RegistroController();

        $resultado = $controlador->validarFecha(
            1,
            1,
            '2030-01-11',
            '18:00:00',
            '20:00:00'
        );

        $this->assertTrue($resultado);
    }
}