<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte por rango de Fecha de Ventas</title>
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
            Criterio de Busqueda: {{ $id }} - {{ $id2 }} - {{ $id3 }}
        </div>
        <div style="background: #235aa3; color: #ffffff; text-align: center; padding: 3px; margin-bottom: 10px">
            <span>Reporte por rango de Fecha de Ventas</span>
        </div>
    </header>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>COD</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                {{-- <th>Estado</th> --}}

                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php($cont = 1)
            @php($total_venta = 0)
            @foreach ($ventas as $c)
                @php($explod_nomCliente = explode(' ', $c->nomCliente))
                <tr>
                    <td align="center">{{ $cont++ }}</td>
                    <td># {{ $c->codVenta }}</td>
                    <td align="center">{{ date('d/m/Y', strtotime($c->fechVenta)) }}</td>
                    <td align="center">{{ $c->horaVenta }}</td>
                    <td>
                        @if (count($explod_nomCliente) > 1)
                            {{ $explod_nomCliente[0] }} {{ $explod_nomCliente[1] }}
                        @else
                            {{ $c->nomCliente }}
                        @endif
                    </td>
                    {{-- <td>{{ $c->estado }}</td> --}}

                    <td align="right">{{ number_format($c->totalVenta, 2) }}</td>
                    @php($total_venta += $c->totalVenta)
                </tr>
            @endforeach
            <tr>

                <td colspan="4" style="border: 0px"></td>

                <th>TOTAL</th>
                <th style="text-align: right">{{ number_format($total_venta, 2) }}</th>
            </tr>
        </tbody>
    </table>
</body>

</html>
