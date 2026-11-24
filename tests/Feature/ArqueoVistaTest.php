<?php

namespace Tests\Feature;

use Illuminate\Auth\GenericUser;
use Tests\TestCase;

class ArqueoVistaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(new GenericUser([
            'id' => 1,
            'codUsuario' => 1,
            'nombres' => 'Usuario de prueba',
        ]), 'web');
    }

    /**
     * @dataProvider escenariosArqueo
     */
    public function test_presenta_los_importes_correctos(
        $movimientos,
        $efectivoEsperado,
        $transferenciaEsperada,
        $diferenciaEsperada
    ) {
        $html = view('caja.apertura_cierre.report', [
            'caja' => (object) [
                'codCaja' => 1,
                'nombres' => 'Usuario de prueba',
                'fechaApertura' => '2030-01-11',
                'horaApertura' => '09:00:00',
                'montoApertura' => $movimientos['apertura'],
                'fechaCierre' => '2030-01-11',
                'horaCierre' => '22:00:00',
                'montoCierre' => $movimientos['cierre'],
            ],
            'datos' => (object) [
                'nombre' => 'El Golazo - Pruebas',
            ],
            'reserva' => [
                'efectivo' => $movimientos['reservaEfectivo'],
                'transferencia' => $movimientos['reservaTransferencia'],
            ],
            'venta' => [
                'efectivo' => $movimientos['ventaEfectivo'],
                'transferencia' => $movimientos['ventaTransferencia'],
            ],
            'ingreso' => (object) [
                'importe' => $movimientos['ingreso'],
            ],
            'egreso' => (object) [
                'importe' => $movimientos['egreso'],
            ],
            'listaEgreso' => [
                $movimientos['egreso'], 0, 0,
            ],
            'producto' => collect(),
            'fechaHora' => '2030-01-11 22:00:00',
        ])->render();

        $documento = new \DOMDocument();

        // Cargar el HTML para consultar las celdas del reporte.
        $estadoAnterior = libxml_use_internal_errors(true);

        try {
            $documento->loadHTML(
                '<?xml encoding="UTF-8">' . $html
            );
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($estadoAnterior);
        }

        $xpath = new \DOMXPath($documento);

        $celdaEfectivo = $xpath->query(
            "//td[normalize-space(.)='EFECTIVO EN CAJA:']"
            . "/following-sibling::td[1]"
        );

        $this->assertSame(1, $celdaEfectivo->length);

        $this->assertSame(
            $efectivoEsperado,
            trim($celdaEfectivo->item(0)->textContent)
        );

        $texto = preg_replace(
            '/\s+/u',
            ' ',
            $documento->textContent
        );

        $this->assertStringContainsString(
            'Transferencia = ' . $transferenciaEsperada,
            $texto
        );

        $this->assertStringContainsString(
            'Efectivo = ' . $diferenciaEsperada,
            $texto
        );
    }

    public function escenariosArqueo(): array
    {
        return [
            'movimientos mixtos con cierre exacto' => [
                [
                    'apertura' => 200,
                    'reservaEfectivo' => 100,
                    'reservaTransferencia' => 80,
                    'ventaEfectivo' => 50,
                    'ventaTransferencia' => 40,
                    'ingreso' => 20,
                    'egreso' => 30,
                    'cierre' => 340,
                ],
                '340.00', '120.00', '0.00',
            ],
            'transferencias no aumentan el efectivo' => [
                [
                    'apertura' => 200,
                    'reservaEfectivo' => 0,
                    'reservaTransferencia' => 80,
                    'ventaEfectivo' => 0,
                    'ventaTransferencia' => 40,
                    'ingreso' => 0,
                    'egreso' => 0,
                    'cierre' => 200,
                ],
                '200.00', '120.00', '0.00',
            ],
            'diferencia entre efectivo esperado y declarado' => [
                [
                    'apertura' => 200,
                    'reservaEfectivo' => 100,
                    'reservaTransferencia' => 0,
                    'ventaEfectivo' => 50,
                    'ventaTransferencia' => 0,
                    'ingreso' => 20,
                    'egreso' => 30,
                    'cierre' => 330,
                ],
                '340.00', '0.00', '10.00',
            ],
        ];
    }
}