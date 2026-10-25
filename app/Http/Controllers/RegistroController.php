<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Registro;


class RegistroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        if ($request) {
            $cliente = DB::table('cliente')->where('estado', 'ACTIVO')
                ->orderByDesc('codCliente')
                ->get();

            $localidad = DB::table('localidad')->get();
            $caja = DB::table('caja')->where('montoCierre', '=', null)->first();

            return view('registro.registro.index', ["cliente" => $cliente, "localidad" => $localidad, "searchText" => $query, "caja" => $caja]);
        }
    }

    public function validarFecha($id, $codLocalidad, $fecha, $horaInicial, $horaFinal)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha_actual = $mytime->toDateString();
        $hora_actual = $mytime->toTimeString();

        $registro = Registro::select("*")
            ->whereDate('fechRegistro', '=', $fecha)
            ->where('codRegistro', '!=', $id)
            ->where('codLocalidad', '=', $codLocalidad)
            ->Where(function ($q)  use ($horaInicial, $horaFinal) {
                $q->orwhereBetween('horainicio', [$horaInicial, $horaFinal])
                    ->orWhereBetween('horafinal', [$horaInicial, $horaFinal]);
            })
            ->first();
        if (strtotime($fecha . $horaInicial) < strtotime($fecha_actual . $hora_actual)) {
            $registro = 1;
        }
        return $registro == null ? true : false;
    }


    public function guardar(Request $request)
    {
        $input = $request->all();
        // Obtenemos el precio de la tarifa
        $localidad = Localidad::where('codLocalidad', $input["ddlLocalidad"])->first();

        if (empty($input["txtTarifa"])) {
            return response()->json(["ok" => false, "mensaje" => "Seleccione una tarifa."]);
        }

        if (empty($input["ddlClientes"])) {
            return response()->json(["ok" => false, "mensaje" => "Seleccione un cliente."]);
        }

        if ($this->validarFecha(-1, $input["ddlLocalidad"], $input["txtFecha"], $input["txtHoraInicial"], $input["txtHoraFinal"])) {
            $agenda = Registro::create([
                "codUsuario" => auth()->user()->codUsuario,
                // "codUsuario" => '1',
                "codCliente" => $input["ddlClientes"],
                "codLocalidad" => $input["ddlLocalidad"],
                // "codCaja" => '7',
                "fechRegistro" => $input["txtFecha"],
                "horainicio" => $input["txtHoraInicial"],
                "horafinal" => $input["txtHoraFinal"],
                "duracion" => $input["txtTiempo"],
                "tarifa" => $input["txtTarifa"],
                "costoTarifa" => $input["txtTarifa"] == 'día' ? $localidad->precioDia : $localidad->precioNoche,
                "estado" => 'SIN CONFIRMAR',
                "comentario" => $input["txtComentario"]
            ]);

            return response()->json(["ok" => true, "mensaje" =>$agenda->codRegistro]);
        } else {
            return response()->json(["ok" => false, "mensaje" => "El registro interfiere con otra reserva o la fecha seleccionada es menor a la fecha actual"]);
        }
    }

    public function listar($id)
    {

        $registro = DB::table('registro as r')

            ->join('cliente as c', 'r.codCliente', '=', 'c.codCliente')
            ->join('localidad as l', 'r.codLocalidad', '=', 'l.codLocalidad')
            ->select(
                'codRegistro',
                'fechRegistro',
                'horainicio',
                'horafinal',
                'r.estado as estadoRegistro',
                'comentario',
                'duracion',
                'tarifa',
                // 'c.nombres as nomCliente', 'r.codCliente','codUsuario', 'pago')
                'c.nombres as nomCliente',
                'r.codCliente',
                'l.codLocalidad',
                'l.nomLocalidad',
                'codUsuario',
            )
            ->where('r.codLocalidad', $id)
            ->get();


        $nueva_agenda = [];
        foreach ($registro as $value) {
            $nueva_agenda[] = [
                "id" => $value->codRegistro,
                "start" => $value->fechRegistro . " " . $value->horainicio,
                "end" => $value->fechRegistro . " " . $value->horafinal,
                "title" => $value->estadoRegistro . " - " . $value->nomCliente,
                "backgroundColor" => $value->estadoRegistro == 'SIN CONFIRMAR' ? "#F86569" : "#20c997",
                "textColor" => "#fff",
                "extendedProps" => [
                    "codRegistro" => $value->codRegistro,
                    "codCliente" => $value->codCliente,
                    "codLocalidad" => $value->codLocalidad,
                    "nomLocalidad" => $value->nomLocalidad,
                    "tarifa" => $value->tarifa,
                    "comentario" => $value->comentario,
                    "duracion" => $value->duracion,
                    "estado" => $value->estadoRegistro,
                ]
            ];
        }
        return response()->json($nueva_agenda);
    }

    public function editar(Request $request)
    {
        $input = $request->all();
        if ($this->validarFecha($input["id"], $input["ddlLocalidad_r"], $input["txtFecha"], $input["txtHoraInicial"], $input["txtHoraFinal"])) {
            $agenda = Registro::findOrFail($input["id"]);
            $agenda->fechRegistro = $input["txtFecha"];
            $agenda->horainicio = $input["txtHoraInicial"];
            $agenda->horafinal = $input["txtHoraFinal"];
            $agenda->update();
            return response()->json(["ok" => true]);
        } else {
            return response()->json(["ok" => false, "mensaje" => "El registro interfiere con otra reserva o la fecha seleccionada es menor a la fecha actual"]);
        }
        // $agenda->duracion = date('H:i:s', strtotime ('+' . $input["txtTiempo_e"] . ' minute' , strtotime ('00:00:00')));
    }

    public function editar2(Request $request)
    {
        $input = $request->all();
        $reg_ant = DB::table('registro')->where('codRegistro', $input["id_e"])->first();
        $localidad = Localidad::where('codLocalidad', $reg_ant->codLocalidad)->first();

        if ($reg_ant->fechRegistro != $input["txtFecha_e"] || $reg_ant->horainicio != $input["txtHoraInicial_e"] || $reg_ant->horafinal != $input["txtHoraFinal_e"]) {
            if ($this->validarFecha($input["id_e"], $reg_ant->codLocalidad, $input["txtFecha_e"], $input["txtHoraInicial_e"], $input["txtHoraFinal_e"])) {
                $agenda = Registro::findOrFail($input["id_e"]);
                // $agenda->pago = $input["txtPago_e"];
                $agenda->codCliente = $input["ddlClientes_e"];
                $agenda->fechRegistro = $input["txtFecha_e"];
                $agenda->horainicio = $input["txtHoraInicial_e"];
                $agenda->horafinal = $input["txtHoraFinal_e"];
                $agenda->duracion = $input["txtTiempo_e"];
                $agenda->tarifa = $input["txtTarifa_e"];
                $agenda->costoTarifa = $input["txtTarifa_e"] == 'día' ? $localidad->precioDia : $localidad->precioNoche;
                $agenda->comentario = $input["txtComentario_e"];
                $agenda->update();
                return response()->json(["ok" => true]);
            } else {
                return response()->json(["ok" => false, "mensaje" => "El registro interfiere con otra reserva o la fecha seleccionada es menor a la fecha actual"]);
            }
        } else {
            // if ($this->validarFecha($input["id_e"], $reg_ant->codLocalidad, $input["txtFecha_e"], $input["txtHoraInicial_e"], $input["txtHoraFinal_e"])) {
            $agenda = Registro::findOrFail($input["id_e"]);
            // $agenda->pago = $input["txtPago_e"];
            $agenda->codCliente = $input["ddlClientes_e"];
            $agenda->fechRegistro = $input["txtFecha_e"];
            $agenda->horainicio = $input["txtHoraInicial_e"];
            $agenda->horafinal = $input["txtHoraFinal_e"];
            $agenda->duracion = $input["txtTiempo_e"];
            $agenda->tarifa = $input["txtTarifa_e"];
            $agenda->costoTarifa = $input["txtTarifa_e"] == 'día' ? $localidad->precioDia : $localidad->precioNoche;
            $agenda->comentario = $input["txtComentario_e"];
            $agenda->update();
            return response()->json(["ok" => true]);
            // }else {
            //     return response()->json(["ok" => false]);
            // }
        }
    }

    public  static function nombreLocalidad($id)
    {
        $localidad = Localidad::where('codLocalidad', $id)->first();
        return isset($localidad->codLocalidad) ? $localidad : '';
    }
    public function exportPdf($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        $registro = DB::table('registro as r')
            ->join('localidad as l', 'r.codLocalidad', 'l.codLocalidad')
            ->join('cliente as c', 'r.codCliente', 'c.codCliente')
            ->where('codRegistro', $id)->first();

        $pdf = \PDF::loadView('registro/registro.report', ["registro" => $registro, "fechaHora" => $fechaHora])
            ->setPaper('b7', 'portrait');
        return $pdf->stream('Reserva #' . $registro->codRegistro . '.pdf');
    }
}
