<?php use App\Http\Controllers\ReporteRangoController as RC;?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="11" align="center" style="font-weight: bold; color: #0e975e">
                Reporte por rango de Fecha de Alquiler/Reserva
                </th>
            </tr>
            <tr>
                <th style="background-color: #0e975e; color: #ffffff">N°</th>
                <th style="background-color: #0e975e; color: #ffffff">COD</th>
                <th style="background-color: #0e975e; color: #ffffff">Fecha</th>
                <th style="background-color: #0e975e; color: #ffffff">H. Inicio</th>
                <th style="background-color: #0e975e; color: #ffffff">H. Final</th>
                <th style="background-color: #0e975e; color: #ffffff">Localidad</th>
                <th style="background-color: #0e975e; color: #ffffff">Cliente</th>
                <th style="background-color: #0e975e; color: #ffffff">Usuario</th>
                <th style="background-color: #0e975e; color: #ffffff">Estado</th>
            </tr>
        </thead>
        <tbody>
            @php($cont = 1)
            @php($total_pago = 0)
            @foreach ($registro as $c)
                <tr>
                    <td align="center" style="border: 1px solid #0d815a">{{ $cont++ }}</td>
                    <td style="border: 1px solid #0d815a"># {{ $c->codRegistro }}</td>
                    <td align="center" style="border: 1px solid #0d815a">{{ date('d/m/Y', strtotime($c->fechRegistro)) }}</td>
                    <td style="border: 1px solid #0d815a">{{ $c->horainicio }}</td>
                    <td style="border: 1px solid #0d815a">{{ $c->horafinal }}</td>
                    <td style="border: 1px solid #0d815a">{{ $c->nomLocalidad}}</td>
                    <td style="border: 1px solid #0d815a">{{ $c->nomCliente }}</td>
                    <td style="border: 1px solid #0d815a">{{ $c->nomUsuario }}</td>
                    <td style="border: 1px solid #0d815a; color: {{RC::estadoPago($c->codRegistro) ? '#21ddb4' : '#ee4848'}}">
                        @if (RC::estadoPago($c->codRegistro))
                           {{ 'PAGADO' }}
                        @else
                            {{ 'ADEUDA' }}
                        @endif
                    </td>
                </tr>
            @endforeach
                {{-- <tr>
                    <td colspan="10" style="border: 0px"></td>
                    <th style="border: 1px solid #0d815a">TOTAL</th>
                    <th style="text-align: right; border: 1px solid #0d815a">{{number_format($total_pago, 2)}}</th>
                </tr> --}}
        </tbody>
    </table>
</body>
</html>
