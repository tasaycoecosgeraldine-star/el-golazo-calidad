<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Reservas</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }
        table {
            border-collapse: collapse; border-color: rgb(0, 0, 0);
            width: 100%;
        }
        td {
            padding: 3px; border: 1px solid rgb(37, 87, 134);
        }
        th {
            padding: 3px; border: 1px solid rgb(37, 87, 134);
            background: #eaf3fa;
            color: #12446b;
        }
        .data{
        float: right;
        margin: 2% 0% 0% 0%;
        }
    </style>
</head>
<body>
   
        <div>
            <img src="../public/Logo/{{$empresa->logo}}" alt="" width="80" height="80">
            <p class="data">
                {{$empresa->nombre}} <br>
                Dirección: {{$empresa->direccion}} <br>
            <br>{{$fecha_hora}} <br>
            </p>
        </div>
   
    <div colspan="3">
        Criterio de Busqueda: {{$id}} - {{$id2}}
    </div>
    <div style="background: #165a92; color: #ffffff; text-align: center; padding: 3px; margin-bottom: 5px">
        <span>Listado de Reservas</span>
    </div>
    <table>
        <tr>
            <th>Nro.</th>
            <th>Fecha Registro</th>
            <th>Hora Inicio</th>
            <th>Hora Final</th>
        @if (auth()->user()->tipo == 'ADMINISTRADOR')
            <th>Localidad</th>
        @endif
            <th>Cliente</th>
            <th>Usuario</th>
            <th>Pago</th>
            <th>Estado</th>

        </tr>
        @php($cont = 1)
        @php($total_pago = 0)
        @foreach ($registro as $r)
        @php($explod_nomCliente = explode(' ', $r->nomCliente))
        @php($explod_nomUsuario = explode(' ', $r->nomUsuario))
        <tr>
            <td align="center">{{ $cont++ }}</td>
            <td>{{ date('d/m/Y', strtotime($r->fechRegistro)) }}</td>
            <td>{{ $r->horainicio }}</td>
            <td>{{ $r->horafinal }}</td>
        @if (auth()->user()->tipo == 'ADMINISTRADOR')
            <td>{{ $r->nomLocalidad }}</td>
        @endif
            <td>
                @if (count($explod_nomCliente)>1)
                    {{ $explod_nomCliente[0] }} {{ $explod_nomCliente[1] }}
                @else
                    {{ $r->nomCliente }}
                @endif
            </td>
            <td>
                @if (count($explod_nomUsuario)>1)
                    {{ $explod_nomUsuario[0] }} {{ $explod_nomUsuario[1] }}
                @else
                    {{ $r->nomUsuario }}
                @endif
            </td>
            <td align="center">
                @if ($r->estado == 'CONFIRMADO')
                    <span style="background: #5edbfae1; padding: 30px 10px 30px 10px">{{ $r->estado}}
                    </span>
                @elseif ($r->estado == 'SIN CONFIRMAR')
                    <span style="background: #fa5e5ee1; padding: 30px 10px 30px 10px; color: #ffffff">{{ $r->estado}}</span>
                @endif
            </td>
            <td align="right">{{ $r->pago }}</td>
            @php($total_pago += $r->pago)
        </tr>
    @endforeach
        <tr>
            @if (auth()->user()->tipo == 'ADMINISTRADOR')
                <td colspan="7" style="border: 0px"></td>
            @else
                <td colspan="6" style="border: 0px"></td>
            @endif
            <th align="right">Total </th>
            <th align="right">{{number_format($total_pago, 2)}}</th>
        </tr>
    </table>
</body>
</html>
