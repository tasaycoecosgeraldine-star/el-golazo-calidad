<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Mensual</title>
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
            Criterio de Busqueda: {{ $id }} - {{ $id2 }}
        </div>
        <div style="background: #235aa3; color: #ffffff; text-align: center; padding: 3px; margin-bottom: 10px">
            <span>Reporte Mensual</span>
        </div>
    </header>
    <table>
        <thead>
            <tr>
                {{-- <th>Id</th> --}}
                <th>N°</th>
                <th>Fecha</th>
                <th>Reservas</th>
                <th>Ventas</th>
                <th>Ingresos</th>
                <th>Egresos</th>
                <th>Total</th>
            </tr>
        </thead>
        @php($total_reserva = 0)
        @php($total_ventas = 0)
        @php($total_ingreso = 0)
        @php($total_egreso = 0)
        @php($contador = 0)
        @foreach ($array_fechas as $item)
            @php($contador += 1)
            @php($valor_item = explode('_', $item))
            <tr>
                <td align="center">{{ $contador }}</td>
                <td align="center">{{ date('d/m/Y', strtotime($valor_item[0])) }}</td>
                @if ($valor_item[0] <= $fecha)
                    <td style="text-align: right">+ $ {{ $valor_item[1] }}</td>
                    <td style="text-align: right">+ $ {{ $valor_item[2] }}</td>
                    <td style="text-align: right">+ $ {{ $valor_item[3] }}</td>
                    <td style="text-align: right">- $ {{ $valor_item[4] }}</td>
                    <td style="text-align: right">$
                        {{ number_format(floatval($valor_item[1]) + floatval($valor_item[2]) + floatval($valor_item[3]) - floatval($valor_item[4]), 2) }}
                    </td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            </tr>
            @php($total_reserva += floatval($valor_item[1]))
            @php($total_ventas += floatval($valor_item[2]))
            @php($total_ingreso += floatval($valor_item[3]))
            @php($total_egreso += floatval($valor_item[4]))
        @endforeach
        <tr style="font-weight: bold">
            <td style="border: 0px" colspan="2"></td>
            <td style="text-align: right">$ {{ number_format($total_reserva, 2) }}</td>
            <td style="text-align: right">$ {{ number_format($total_ventas, 2) }}</td>
            <td style="text-align: right">$ {{ number_format($total_ingreso, 2) }}</td>
            <td style="text-align: right">$ {{ number_format($total_egreso, 2) }}</td>
            <td style="text-align: right">$
                {{ number_format($total_reserva + $total_ventas + $total_ingreso - $total_egreso, 2) }}</td>
        </tr>
    </table>
</body>

</html>
