<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Mensual</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                {{-- <th>Id</th> --}}
                <th style="background-color: #0e975e; color: #ffffff">N°</th>
                <th style="background-color: #0e975e; color: #ffffff">Fecha</th>
                <th style="background-color: #0e975e; color: #ffffff">Reservas</th>
                <th style="background-color: #0e975e; color: #ffffff">Ventas</th>
                <th style="background-color: #0e975e; color: #ffffff">Ingresos</th>
                <th style="background-color: #0e975e; color: #ffffff">Egresos</th>
                <th style="background-color: #0e975e; color: #ffffff">Total</th>
            </tr>
        </thead>
    @php($estilos_celda = 'text-align: right; border: 1px solid #0d815a')
    @php($total_reserva = 0)
    @php($total_ventas = 0)
    @php($total_ingreso= 0)
    @php($total_egreso = 0)
    @php($contador = 0)
    @foreach ($array_fechas as $item)
    @php($contador += 1)
    @php($valor_item = explode('_', $item))
        <tr>
            <td align="center" style="border: 1px solid #0d815a">{{$contador}}</td>
            <td align="center" style="border: 1px solid #0d815a">{{ date('d/m/Y', strtotime($valor_item[0]))}}</td>
            @if ($valor_item[0] <= $fecha)
                <td style="{{$estilos_celda}}"> {{number_format($valor_item[1], 2)}}</td>
                <td style="{{$estilos_celda}}"> {{number_format($valor_item[2], 2)}}</td>
                <td style="{{$estilos_celda}}"> {{number_format($valor_item[3], 2)}}</td>
                <td style="{{$estilos_celda}}"> {{number_format($valor_item[4], 2)}}</td>
                <td style="{{$estilos_celda}}"> {{number_format(floatval($valor_item[1]) + floatval($valor_item[2]) + floatval($valor_item[3]) - floatval($valor_item[4]), 2)}}</td>
            @else
                <td style="{{$estilos_celda}}"></td><td style="{{$estilos_celda}}"></td><td style="{{$estilos_celda}}"></td><td style="{{$estilos_celda}}"></td><td style="{{$estilos_celda}}"></td>
            @endif
        </tr>
        @php($total_reserva += floatval($valor_item[1]))
        @php($total_ventas += floatval($valor_item[2]))
        @php($total_ingreso += floatval($valor_item[3]))
        @php($total_egreso += floatval($valor_item[4]))
    @endforeach
        <tr style="font-weight: bold">
            <td style="border: 0px" colspan="2"></td>
            <td style="{{$estilos_celda}}"> {{number_format($total_reserva,2)}}</td>
            <td style="{{$estilos_celda}}"> {{floatval($total_ventas)}}</td>
            <td style="{{$estilos_celda}}"> {{number_format($total_ingreso,2)}}</td>
            <td style="{{$estilos_celda}}"> {{number_format($total_egreso,2)}}</td>
            <td style="{{$estilos_celda}}"> {{number_format($total_reserva + $total_ventas + $total_ingreso - $total_egreso, 2)}}</td>
        </tr>
    </table>
</body>
</html>
