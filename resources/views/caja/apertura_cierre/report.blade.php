<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CIERRE DE CAJA #{{$caja->codCaja}}</title>
    @php($medidaTicket = 260)
    <style>
         * {

            font-size: 10px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 2px;
        }

        td,
        th,
        tr,
        table {
            /* border-top: 1px solid black; */
            border-collapse: collapse;
            margin: 0 auto;
            width: 100%;
        }

        td.precio {
            text-align: right;
            font-size: 11px;
        }

        td.cantidad {
            font-size: 11px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }

        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: {{$medidaTicket}}px;
            max-width: {{$medidaTicket}}px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 0;
            padding: 0;
        }

        /* .ticket {
            margin: 0;
            padding: 0;
        } */

        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <br><br>
<h4>ARQUEO DE CAJA</h4>
<h4>CIERRE DE CAJA #{{$caja->codCaja}}</h4>
@php($estado_caja = is_null($caja->montoCierre) ? 'ABIERTO' : 'CERRADO')
<p>ESTADO: {{$estado_caja}}</p>
<div class="ticket">
    <table>
        <tr>
            <td>ENCARGADO:</td>
            <td>{{$caja->nombres}}</td>
        </tr>
        <tr>
            <td>LOCALIDAD:</td>
            <td>{{$datos->nombre}}</td>
        </tr>
        <tr>
            <td>FECHA APERTURA:</td>
            <td>{{$caja->fechaApertura}} {{$caja->horaApertura}}</td>
        </tr>
        <tr>
            <td>FECHA CIERRE:</td>
            <td>{{$caja->fechaCierre}} {{$caja->horaCierre}}</td>
        </tr>
    </table>
    <h4>== DINERO EN CAJA ==</h4>
    <table>
        <tr>
            <td>APERTURA DE CAJA:</td>
            <td align="right">{{$caja->montoApertura}}</td>
        </tr>
        {{-- <tr>
            <td>RESERVAS WEB:</td>
            @php($reserva_efe_web = !isset($registro_web->pago) ? 0 : $registro_web->pago)
            <td align="right">+ {{number_format($reserva_efe_web, 2)}}</td>
        </tr> --}}
        <tr>
            <td>R EFECTIVO:</td>
            <td align="right">+ {{number_format($reserva['efectivo'], 2)}}</td>
        </tr>
        <tr>
            <td>R. TRANSFERENCIA:</td>
            <td align="right">+ {{number_format($reserva['transferencia'], 2)}}</td>
        </tr>
        <tr>
            <td>V. EFECTIVO:</td>
            <td align="right">+ {{number_format($venta['efectivo'], 2)}}</td>
        </tr>
        <tr>
            <td>V. TRANSFERENCIA:</td>
            <td align="right">+ {{number_format($venta['transferencia'], 2)}}</td>
        </tr>
        <tr>
            <td>INGRESOS EXTRA:</td>
            @php($importe = !isset($ingreso->importe) ? 0 : $ingreso->importe)
            <td align="right">+ {{number_format($importe, 2)}}</td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000">EGRESOS / GASTOS:</td>
            @php($egreso_importe = !isset($egreso->importe) ? 0 : $egreso->importe)
            <td align="right" style="border-bottom: 1px solid #000000">- {{number_format($egreso_importe, 2)}} </td>
        </tr>
        <tr>
            <td>EFECTIVO EN CAJA:</td>
            {{-- @php($efectivo =$reserva_efe + $reserva_efe_web + $caja->montoApertura + $venta->totalVenta + $ingreso->importe - $egreso->importe) --}}
            @php($efectivo = $reserva['efectivo'] + $venta['efectivo'] + $caja->montoApertura + $ingreso->importe - $egreso->importe)
            <td align="right">{{number_format($efectivo, 2)}} </td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000">EFECTIVO EN CIERRE:</td>
            @php($salida = !isset($caja->montoCierre) ? 0 : $caja->montoCierre)
            <td align="right" style="border-bottom: 1px solid #000000">{{number_format($salida, 2)}}</td>
        </tr>
        <tr>
            @php($faltante = $efectivo - $salida)
            <td></td>
            <td align="right">Efectivo = {{number_format($faltante, 2)}}</td>
        </tr>
        <tr>
            @php($transferencia = $reserva['transferencia'] + $venta['transferencia'])
            <td></td>
            <td align="right">Transferencia = {{ number_format($transferencia, 2) }}</td>
        </tr>
    </table>
    <br>
    <h4>== ENTRADAS EFECTIVO ==</h4>
    <table>
        <tr>
            <td>ENTRADA DE DINERO</td>
            <td align="right">{{number_format($ingreso->importe, 2)}}</td>
        </tr>
    </table>
    <br>
    <h4>== SALIDAS EFECTIVO ==</h4>
    <table>
        <tr>
            <td>COMPRAS</td>
            <td align="right">{{number_format($listaEgreso[0], 2)}}</td>
        </tr>
        <tr>
            <td>SERVICIOS</td>
            <td align="right">{{number_format($listaEgreso[1], 2)}}</td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000">REMUNERACIONES</td>
            <td align="right" style="border-bottom: 1px solid #000000">{{number_format($listaEgreso[2], 2)}}</td>
        </tr>
        <tr>
            <td>TOTAL SALIDAS</td>
            @php($totalEgreso = number_format($listaEgreso[0] + $listaEgreso[1] + $listaEgreso[2], 2))
            <td align="right">= {{$totalEgreso}}</td>
        </tr>
    </table>
    <br>
    <h4>== PRODUCTOS VENDIDOS ==</h4>
    <table>
        <tr>
            <th>PRODUCTO</th>
            <th align="center">CANT.</th>
            <th align="center">P. U.</th>
            <th align="center">DESC.</th>
            <th align="center">IMP.</th>
        </tr>
        @foreach ($producto as $item)
            <tr>
                <td>{{$item->nomProducto}}</td>
                <td align="center">{{$item->cantidad}}</td>
                <td align="right">{{$item->precioVenta}}</td>
                <td align="right">{{$item->descuento}}</td>
                @php($imp = ($item->cantidad * $item->precioVenta) - $item->descuento)
                <td align="right">{{number_format($imp, 2)}}</td>
            </tr>
        @endforeach
    </table>
    <br>
    <table>
        <tr><td><h4>DATOS DE IMPRESION</h4></td></tr>
        <tr><td><h4>USUARIO: {{auth()->user()->nombres}}</h4></td></tr>
        <tr><td><h4>FECHA: {{ date('d/m/Y h:i:s A', strtotime($fechaHora)) }}</h4></td></tr>
    </table>
    <br> <br>
        <p><h4>---------------------------</h4></p>
        <h4>{{auth()->user()->nombres}}</h4>

</div>

</body>
</html>
