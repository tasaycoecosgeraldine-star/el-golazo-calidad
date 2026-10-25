<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
</head>

<body>
    <table>
        <thead>
            <tr>


                <th colspan="6" align="center" style="font-weight: bold; color: #0e975e">

                    Reporte de Ventas
                </th>
            </tr>
            <tr>
                <th style="background-color: #0e975e; color: #ffffff">N°</th>
                <th style="background-color: #0e975e; color: #ffffff">COD</th>
                <th style="background-color: #0e975e; color: #ffffff">Fecha</th>
                <th style="background-color: #0e975e; color: #ffffff">Hora</th>
                <th style="background-color: #0e975e; color: #ffffff">Cliente</th>
                {{-- <th>Estado</th> --}}

                <th style="background-color: #0e975e; color: #ffffff">Total</th>
            </tr>
        </thead>
        <tbody>
            @php($cont = 1)
            @php($total_venta = 0)
            @foreach ($ventas as $c)
                @php($explod_nomCliente = explode(' ', $c->nomCliente))
                <tr>
                    <td align="center" style="border: 1px solid #0d815a">{{ $cont++ }}</td>
                    <td style="border: 1px solid #0d815a"># {{ $c->codVenta }}</td>
                    <td align="center" style="border: 1px solid #0d815a">{{ date('d/m/Y', strtotime($c->fechVenta)) }}
                    </td>
                    <td align="center" style="border: 1px solid #0d815a">{{ $c->horaVenta }}</td>
                    <td style="border: 1px solid #0d815a">
                        @if (count($explod_nomCliente) > 1)
                            {{ $explod_nomCliente[0] }} {{ $explod_nomCliente[1] }}
                        @else
                            {{ $c->nomCliente }}
                        @endif
                    </td>
                    {{-- <td>{{ $c->estado }}</td> --}}

                    <td align="right" style="border: 1px solid #0d815a">{{ $c->totalVenta }}</td>
                    @php($total_venta += $c->totalVenta)
                </tr>
            @endforeach
            <tr>

                <td colspan="4"></td>

                <th style="border: 1px solid #0d815a">TOTAL</th>
                <th style="text-align: right; border: 1px solid #0d815a">{{ number_format($total_venta, 2) }}</th>
            </tr>
        </tbody>
    </table>
</body>

</html>
