<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listados de Productos</title>
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
        Criterio de Busqueda: {{$id}}
    </div>
    <div style="background: #165a92; color: #ffffff; text-align: center; padding: 3px; margin-bottom: 5px">
        <span>Listado de Productos</span>
    </div>
    <table>
        <tr>
            <th>Nro.</th>
            <th>Nombre</th>
            <th>Stock</th>
            <th>Categoría</th>
            {{-- <th>Descripción</th> --}}
        {{-- @if (auth()->user()->tipo == 'ADMINISTRADOR')
            <th>Localidad</th>
        @endif --}}
            <th>Precio</th>
        </tr>
        @php($cont = 1)
        @foreach ($producto as $p)
        @php($explod_nomProducto = explode(' ', $p->nomProducto))
        <tr>
            <td align="center">{{ $cont++ }}</td>
            <td>{{ $p->nomProducto  }}</td>
            <td align="center">{{ $p->stock  }}</td>
            <td align="center">{{ $p->nomCategoria  }}</td>
            {{-- <td align="center">{{ $p->descripcion  }}</td> --}}
        {{-- @if (auth()->user()->tipo == 'ADMINISTRADOR')
            <td>{{ $p->nomLocalidad  }}</td>
        @endif --}}
            <td align="right">{{ $p->Precio  }}</td>
        </tr>
    @endforeach
    </table>
</body>
</html>
