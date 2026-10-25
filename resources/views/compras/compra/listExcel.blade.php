<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de Compras</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="4">Listado de Compras de: {{ date('d/m/Y', strtotime($inicio)) }} hasta {{ date('d/m/Y', strtotime($fin)) }}</td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <td style="border: 1px solid #194670; background: #194670; color: #ffffff">FECHA</td>
                <td style="border: 1px solid #194670; background: #194670; color: #ffffff">HORA</td>
                <td style="border: 1px solid #194670; background: #194670; color: #ffffff">PROVEEDOR</td>
                <td style="border: 1px solid #194670; background: #194670; color: #ffffff" align="right">TOTAL</td>
            </tr>
        </thead>
        @php($total = 0)
        @foreach ($ingresos as $ing)
            <tr>
                <td style="border: 1px solid #194670">{{ date('d/m/Y', strtotime($ing->fecCom)) }} </td>
                <td style="border: 1px solid #194670">{{ date('H:i:s', strtotime($ing->fecCom)) }}</td>
                <td style="border: 1px solid #194670">{{ $ing->nomPro }}</td>
                <td style="border: 1px solid #194670" align="right">{{ $ing->total }}</td>
            </tr>
            @php($total += $ing->total)
        @endforeach
        <tr>
            <td colspan="2"></td>
            <td style="border: 1px solid #194670">TOTAL</td>
            <td style="border: 1px solid #194670">{{ $total }}</td>
        </tr>
    </table>
</body>

</html>
