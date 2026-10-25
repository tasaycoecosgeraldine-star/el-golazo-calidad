<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva #{{$registro->codRegistro}}</title>
    @php($medidaTicket = 180)
    <style>
         * {
            font-size: 12px;
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
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
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

        .ticket {
            margin: 0;
            padding: 0;
        }

        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="ticket centrado">
        <h1>{{$registro->nomLocalidad}}</h1>
        <h2>Reserva #{{$registro->codRegistro}}</h2>
        <p>{{$registro->nombres}}</p>
        <h2>{{$fechaHora}}</h2>
    <table>
        <thead>
            <tr class="centrado">
                <th class="cantidad">MIN</th>
                <th class="producto">FECHA</th>
                <th class="precio">H INI - H FINAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$registro->duracion}}</td>
                <td>{{date('d/m/Y', strtotime($registro->fechRegistro))}}</td>
                <td>{{$registro->horainicio}} - {{$registro->horafinal}}</td>
            </tr>
        </tbody>
        <tr>
            {{-- <td colspan="3" align="center">
                @if (!empty($registro->imgComprobante))
                    <img src="../public/imgComprobante/{{$registro->imgComprobante}}" alt="" width="90%" height="135">
                @endif
            </td> --}}
            <td colspan="3">{{$registro->comentario}}</td>
        </tr>
        <tr>
            <td class="cantidad"></td>
            <td class="producto">
                <strong>PAGO</strong>
            </td>
            <td class="precio">
                {{$registro->pago}}
            </td>
        </tr>
    </table>
    <p class="centrado">¡GRACIAS POR SU PREFERENCIA!
        <br>CWILSOFT</p>
    </div>
</body>
</html>
