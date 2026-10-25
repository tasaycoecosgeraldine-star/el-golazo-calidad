<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe de Cita {{$cita->nomConsul}}</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.85em;
        }
        table{
            width: 100%; border-collapse: collapse;
        }
        .data{
            float: right; margin: 2% 0% 0% 0%;
        }
        tbody td {
            padding: 3px; border: 0px solid rgb(37, 87, 134);
        }

    </style>
</head>
<body>
    <div class="encabezado">
        <img src="../public/logo/{{$empresa->logo}}" alt="" width="80" height="80">
        <p class="data">
            {{$empresa->nomEmpresa}} <br>
            Dirección: {{$empresa->direccion}}
        </p>
    </div>
    <table>

        <tbody>
            <tr>
                <td style="font-weight: bold">Paciente: </td>
                <td><span>{{$cita->nomPaciente}}</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Consultorio: </td>
                <td><span>{{$cita->nomConsul}}</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Doctor: </td>
                <td><span>{{$cita->nomUsuario}}</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Fecha de Cita: </td>
                <td><span>{{$cita->fechaCita}}</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Asunto: </td>
                <td><span>{{$cita->asunto}}</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Hora Inicio: </td>
                <td><span>{{$cita->horaCita}}</span></td>
            </tr>

            <tr>
                <td style="font-weight: bold">Hora Final: </td>
                <td><span>{{$cita->horaFinal}}</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Indicaciones: </td>
                <td><span>{{$cita->indicaciones}}</span></td>
            </tr>
            <tr>
                <td style="font-weight: bold">Estado: </td>
                <td><span>{{$cita->estado}}</span></td>
            </tr>

        </tbody>

    </table>
    <hr>
    <h4>Diagnostico / Receta:</h4>
    <p>
        {{$cita->diagnostico}}
    </p>
    <hr>
</body>
</html>
