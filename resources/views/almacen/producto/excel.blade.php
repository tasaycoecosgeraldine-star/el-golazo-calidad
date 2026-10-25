<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <table>
        <tr>
            @if (auth()->user()->tipo == 'ADMINISTRADOR')
                <th colspan="7" align="center" style="font-weight: bold; color: #0e975e">
            @else
                <th colspan="6" align="center" style="font-weight: bold; color: #0e975e">
            @endif
                Reporte de Productos
                </th>
        </tr>
        <tr>
            <th style="background-color: #0e975e; color: #ffffff">Nro.</th>
            <th style="background-color: #0e975e; color: #ffffff">Nombre</th>
            <th style="background-color: #0e975e; color: #ffffff">Stock</th>
            <th style="background-color: #0e975e; color: #ffffff">Categoría</th>
            {{-- <th style="background-color: #0e975e; color: #ffffff">Descripción</th> --}}
        {{-- @if (auth()->user()->tipo == 'ADMINISTRADOR')
            <th style="background-color: #0e975e; color: #ffffff">Localidad</th>
        @endif --}}
            <th style="background-color: #0e975e; color: #ffffff">Precio</th>
        </tr>
        @php($cont = 1)
        @foreach ($producto as $p)
        <tr>
            <td align="center" style="border: 1px solid #0d815a">{{ $cont++ }}</td>
            <td style="border: 1px solid #0d815a">{{ $p->nomProducto  }}</td>
            <td align="center" style="border: 1px solid #0d815a">{{ $p->stock  }}</td>
            <td align="center" style="border: 1px solid #0d815a">{{ $p->nomCategoria  }}</td>
            {{-- <td align="center" style="border: 1px solid #0d815a">{{ $p->descripcion  }}</td> --}}
        {{-- @if (auth()->user()->tipo == 'ADMINISTRADOR')
            <td style="border: 1px solid #0d815a">{{ $p->nomLocalidad  }}</td>
        @endif --}}
            <td align="right" style="border: 1px solid #0d815a">{{ $p->Precio  }}</td>
        </tr>
    @endforeach
    </table>
</body>
</html>
