<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CitaFormRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Rango1;

use App\Models\Registro;
use Carbon\Carbon;

class ReporteRango1Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $start = Carbon::now()->startOfYear()->toDateString();

        if ($request) {
            $query = trim($request->get('searchText'));
            $query2 = trim($request->get('searchText2'));
            $query3 = trim($request->get('searchText3'));
            $query4 = trim($request->get('searchText4'));

            $query = empty($query) ? $start : $query;
            $query2 = empty($query2) ? $fecha : $query2;

            $query3 = $query3 == 'TODO' ? '' : $query3;
            $query4 = $query4 == 'TODO' ? '' : $query4;

            $ventas = DB::table('venta as v')
                ->join('cliente as c', 'v.codCliente', '=', 'c.codCliente')
                ->select(
                    'codVenta',
                    'fechVenta',
                    'horaVenta',
                    'totalVenta',
                    'v.estado',
                    'c.nombres as nomCliente'
                )

                ->whereBetween('fechVenta', [$query, $query2])
                ->Where(function ($q)  use ($query3) {
                    $q->orWhere('horaVenta', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('c.nombres', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('v.estado', 'LIKE', '%' . $query3 . '%');
                })
                ->orderByDesc('fechVenta')
                ->orderByDesc('horaVenta')
                ->paginate(15);


            return view('reporte.rango1.index', ["ventas" => $ventas, "fecha" => $fecha, "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3, "searchText4" => $query4]);
        }
    }


    public function show($id)
    {
        // obtenemos el id y el diagnostico separado por guiones
        $n_id = explode('_', substr($id, 1));

        // echo $n_id[0] . ' ' . $n_id[1];
        $registro = DB::table('registro')
            ->where('codRegistro', '=', $n_id[0])
            ->first();
        if (isset($registro->estado)) {
            if ($registro->estado == 'CONFIRMADO') {
                $estado = "SIN CONFIRMAR";
            }
        }

        $cita2 = Registro::findOrFail($n_id[0]);
        $cita2->estado = $estado;
        $cita2->diagnostico = $n_id[1];
        $cita2->update();
        return Redirect::to('reporte/rango1');
    }


    public function reportPdf($id, $id2, $id3, $id4)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fecha_hora = $mytime->toDateTimeString();
        $start = Carbon::now()->startOfYear()->toDateString();

        if (empty($id)) {
            $id = $start;
        }
        if (empty($id2)) {
            $id2 = $fecha;
        }
        if ($id3 == 'TODO') {
            $id3 = '';
        }
        $id3 = $id3 == 'TODO' ? '' : $id3;
        $id4 = $id4 == 'TODO' ? '' : $id4;


        $ventas = DB::table('venta as v')
            ->join('cliente as c', 'v.codCliente', '=', 'c.codCliente')
            ->select(
                'codVenta',
                'fechVenta',
                'horaVenta',
                'totalVenta',
                'v.estado',
                'c.nombres as nomCliente'
            )

            ->whereBetween('fechVenta', [$id, $id2])
            ->Where(function ($q)  use ($id3) {
                $q->orWhere('horaVenta', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('c.nombres', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('v.estado', 'LIKE', '%' . $id3 . '%');
            })
            ->orderByDesc('fechVenta')
            ->orderByDesc('horaVenta')
            ->get();



        $empresa = DB::table('empresa')->first();
        $pdf = \PDF::loadView('reporte/rango1.report', [
            "ventas" => $ventas, "empresa" => $empresa, "fecha_hora" => $fecha_hora,
            "id" => $id, "id2" => $id2, "id3" => $id3, "id3" => $id3, "id4" => $id4
        ]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function reportExcel($f1, $f2, $f3, $f4)
    {
        return Excel::download(new Rango1($f1, $f2, $f3, $f4), 'ReporteFechaVentas.xlsx');
    }
}
