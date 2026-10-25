<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Clientes</title>
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
    @if (auth()->user()->tipo == 'PERSONAL')
        <div>
            <img src="../public/Logo/{{$localidad->logo}}" alt="" width="80" height="80">
            <p class="data">
                {{$localidad->nomLocalidad}} <br>
                Dirección: {{$localidad->direccion}} <br>
            <br>{{$fecha_hora}} <br>
            </p>
        </div>
    @endif
    <div colspan="3">
        Criterio de Busqueda: {{$id}}
    </div>
    <div style="background: #165a92; color: #ffffff; text-align: center; padding: 3px; margin-bottom: 5px">
        <span>Listado de Clientes</span>
    </div>
    <table>
        <tr>
            <th>Nro.</th>
            <th>N° Documento</th>
            <th>Nombres</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Dirección</th>


        </tr>
        @php($cont = 1)
        @foreach ($cliente as $p)
        @php($explod_nombres = explode(' ', $p->nombres))

        <tr>
            <td align="center">{{ $cont++ }}</td>
            <td align="center">{{ $p->numDocumento  }}</td>
            <td>{{ $p->nombres}}</td>
            <td>{{ $p->email}}</td>
            <td align="center">{{ $p->telefono}}</td>
            <td>{{ $p->direccion}}</td>
        </tr>
    @endforeach
    </table>
</body>
</html>
