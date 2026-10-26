<?php

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Preparar datos solo en SQLite en memoria.
        if (
            config('database.default') === 'sqlite' &&
            config('database.connections.sqlite.database') === ':memory:'
        ) {
            Schema::create('empresa', function (Blueprint $table) {
                $table->increments('idEmpresa');
                $table->string('nombre', 50);
                $table->string('direccion', 50)->nullable();
                $table->string('telefono', 20)->nullable();
                $table->string('simboloMoneda', 3);
                $table->string('logo', 191)->nullable();
                $table->string('ruc', 15)->nullable();
            });

            DB::table('empresa')->insert([
                'nombre' => 'El Golazo - Pruebas',
                'direccion' => 'Dirección de prueba',
                'telefono' => '000000000',
                'simboloMoneda' => 'S/',
                'logo' => null,
                'ruc' => null,
            ]);
        }
    }
}