<?php use App\Http\Controllers\ReporteRangoController as RC;?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte por rango de Fecha de Alquiler / Reserva</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.85em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .data {
            float: right;
            margin: 2% 0% 0% 0%;
        }

        th {
            padding: 3px;
            border: 1px solid rgb(37, 87, 134);
            background: #eaf3fa;
            color: #12446b;
        }

        tbody td {
            padding: 3px;
            border: 1px solid rgb(37, 87, 134);
        }

        .badge {
            padding: 10px;
            text-decoration: none;
        }

        .teal{
            background: #21ddb4;
        }

        .danger{
            background: #ee4848;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <header>
        <div>
            <img src="../public/Logo/{{ $empresa->logo }}" alt="" width="80" height="80">
            <p class="data">
                {{ $empresa->nombre }} <br>
                Dirección: {{ $empresa->direccion }} <br>
                <br>{{ $fecha_hora }} <br>
            </p>
        </div>
        <div colspan="3">
            Criterio de Busqueda: {{ $id }} - {{ $id2 }} - {{ $id3 }}
        </div>
        <div style="background: #235aa3; color: #ffffff; text-align: center; padding: 3px; margin-bottom: 10px">
            <span>Reporte por rango de Fecha de Alquiler / Reserva</span>
        </div>
    </header>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>COD</th>
                <th>Fecha</th>
                <th>H. Inicio - H. Final</th>
                <th>C. Deportivo</th>
                <th>Cliente</th>
                <th>Usuario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @php($cont = 1)
            @php($total_pago = 0)
            @foreach ($registro as $c)
                <tr>
                    <td align="center">{{ $cont++ }}</td>
                    <td align="center"># {{ $c->codRegistro }}</td>
                    <td align="center">{{ date('d/m/Y', strtotime($c->fechRegistro)) }}</td>
                    <td align="center">{{ $c->horainicio }}-{{ $c->horafinal }}</td>
                    <td>{{ $c->nomLocalidad }}</td>
                    <td>{{ $c->nomCliente }}</td>
                    <td>{{ $c->nomUsuario }}</td>
                    <td align="center">
                        @if (RC::estadoPago($c->codRegistro))
                            <span class="btn badge teal">
                                {{ 'PAGADO' }}
                            </span>
                        @else
                            <span class="btn badge danger">
                                {{ 'ADEUDA' }}
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
            {{-- <tr>
                <td colspan="6" style="border: 0px"></td>
                <th>TOTAL</th>
                <th style="text-align: right">{{ number_format($total_pago, 2) }}</th>
            </tr> --}}
        </tbody>
    </table>
</body>

</html>
