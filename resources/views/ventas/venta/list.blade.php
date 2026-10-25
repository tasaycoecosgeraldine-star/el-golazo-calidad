<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado Ventas</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }

        table {
            border-collapse: collapse;
            border-color: rgb(0, 0, 0);
            width: 100%;
        }

        td {
            padding: 3px;
            border: 1px solid rgb(37, 87, 134);
        }

        th {
            padding: 3px;
            border: 1px solid rgb(37, 87, 134);
            background: #eaf3fa;
            color: #12446b;
        }

        .data {
            float: right;
            margin: 2% 0% 0% 0%;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="width: 50%; border: none">
                @if (!empty($datos->logo))
                    <img src="../public/Logo/{{ $datos->logo }}" alt="" width="80" height="80">
                @endif
            </td>
            <td style="border: none">
                {{ $datos->nombre }} <br>
                Dirección: {{ $datos->direccion }} <br>
                <br>{{ date('d/m/Y H:i:s', strtotime($fecha_hora)) }} <br>
            </td>
        </tr>
    </table>
    <div colspan="3">
        Criterio de Busqueda: {{ $id }}
    </div>
    <div style="background: #165a92; color: #ffffff; text-align: center; padding: 3px; margin-bottom: 5px">
        <span>Listado de Ventas</span>
    </div>
    <table>
        <tr>
            <th>Nro.</th>
            <th>CodVenta</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Hora</th>
            {{-- <th>Estado</th> --}}
            <th>M. Pago</th>
            <th>Total de Venta</th>
            @php($cont = 1)
            @php($total_venta = 0)
            @foreach ($venta as $p)
                @php($explod_nombres = explode(' ', $p->nombres))
        <tr>
            <td align="center">{{ $cont++ }}</td>
            <td align="center"># {{ $p->codVenta }}</td>
            <td>{{ $p->nombres }}</td>
            <td align="center">{{ date('d/m/Y', strtotime($p->fechVenta)) }}</td>
            <td align="center">{{ $p->horaVenta }}</td>
            <td>{{ $p->metodoPago }}</td>
            <td align="right">{{ $p->totalVenta }}</td>
            @php($total_venta += $p->totalVenta)

        </tr>
        @endforeach
        <tr>
            <td colspan="5" style="border: 0px"></td>
            <th align="Center">TOTAL </th>
            <th align="right">{{ number_format($total_venta, 2) }}</th>
        </tr>
    </table>
</body>

</html>
