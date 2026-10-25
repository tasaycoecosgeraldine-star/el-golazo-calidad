<?php use App\Http\Controllers\InformeController; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de Personal Médico</title>
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
        <img src="../public/logo/{{$empresa->logo}}" alt="" width="80" height="80">
        <p class="data">
            {{$empresa->nomEmpresa}} <br>
            Dirección: {{$empresa->direccion}} <br>
            {{$fecha_hora}}
        </p>
    </div>
    <div colspan="3">
        Criterio de Busqueda: {{$id}}
    </div>
    <div style="background: #163864; color: #ffffff;
    text-align: center; padding: 8px; margin-bottom: 10px">
        <span>Lista de Personal Médico</span>
        {{-- <span>Pagos del {{InformeController::fechaCastellano($id)}} al {{InformeController::fechaCastellano($id2)}}</span> --}}
    </div>
    <table>
        <thead>
            <tr>
                <th>N° Documento</th>
                <th>Nombres</th>
                <th>N° Teléfono</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Consultorio</th>
            </tr>
        </thead>
            <tbody>
            @foreach ($usuario as $item)
                <tr>
                    <td>{{ strtoupper($item->numDocumento) }} </td>
                    @php($n = explode(' ', strtoupper($item->nombres)))
                        @if (count($n) > 2)
                            <td>{{$n[0]}} {{$n[1]}}</td>
                        @else
                            <td>{{$item->nombres}}</td>
                        @endif
                    <td>{{ $item->telefono}}</td>
                    <td>{{ $item->email}}</td>
                    <td>{{ $item->tipo}}</td>
                    <td>{{ $item->nomConsul}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </body>

    </html>
