<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de Compras</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }

        table {
            /* margin-left: auto;
            margin-right: auto; */
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
            /* background: rgb(146, 142, 142); */
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
    <table>
        <thead>
            <tr style="background: #2d5a96; color: #ffffff">
                <td style="text-align: center" colspan="3">
                    Listado de Compras de: <strong>{{ date('d/m/Y', strtotime($inicio)) }}</strong> hasta <strong>{{ date('d/m/Y', strtotime($fin)) }}</strong>
                </td>
            </tr>
        </thead>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>FECHA</th>
                <th>HORA</th>
                <th>PROVEEDOR</th>
                <th align="right">TOTAL</th>
            </tr>
        </thead>
        @php($cont = 1)
        @php($total = 0)
        @foreach ($ingresos as $ing)
            <tr>
                <td>{{ $cont++ }}</td>
                <td>{{ date('d/m/Y', strtotime($ing->fecCom)) }} </td>
                <td>{{ date('H:i:s', strtotime($ing->fecCom))  }}</td>
                <td>{{ $ing->nomPro }}</td>
                <td align="right">{{ $ing->total }}</td>
            </tr>
            @php($total += $ing->total)
        @endforeach
        <tr>
            <td style="border: none" colspan="3"></td>
            <td align="right">TOTAL</td>
            <td align="right">{{ number_format($total, 2) }}</td>
        </tr>
    </table>
</body>

</html>
