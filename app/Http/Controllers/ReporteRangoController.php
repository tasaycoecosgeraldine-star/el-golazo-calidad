<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CitaFormRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Rango;
use App\Http\Requests\PagoRequest;
use App\Models\AperturaCierre;
use App\Models\Localidad;
use App\Models\Pago;
use App\Models\Registro;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ReporteRangoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

        if ($request) {
            $query = empty($request->get('searchText')) ? date('Y-m-01', strtotime($fecha)) : $request->get('searchText');
            $query2 = empty($request->get('searchText2')) ? date('Y-m-t', strtotime($fecha)) : $request->get('searchText2');
            $query3 = trim($request->get('searchText3'));
            $query4 = trim($request->get('searchText4'));
           


            $registro = DB::table('registro as r')
                ->join('usuario as u', 'r.codUsuario', '=', 'u.codUsuario')
                ->join('cliente as c', 'r.codCliente', '=', 'c.codCliente')
                ->join('localidad as l', 'r.codLocalidad', 'l.codLocalidad')
                ->select(
                    'codRegistro',
                    'fechRegistro',
                    'horainicio',
                    'horafinal',
                    'r.estado',
                    'duracion',
                    'nomLocalidad',
                    'u.nombres as nomUsuario',
                    'c.nombres as nomCliente',
                    'r.comentario',
                    'r.codLocalidad'
                )
                ->whereBetween('fechRegistro', [$query, $query2])
                ->Where(function ($q)  use ($query3) {
                    $q->orWhere('horainicio', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('horafinal', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('c.nombres', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('u.nombres', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('r.estado', 'LIKE', '%' . $query3 . '%');
                })
                ->Where('r.codLocalidad', $query4 == "" ? "!=" : "=", $query4)
                ->orderByDesc('fechRegistro')
                ->orderByDesc('horainicio')
                ->paginate(15);
            $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
            $localidades = Localidad::orderBy('nomLocalidad')->get();

            return view('reporte.rango.index', [
                "registro" => $registro, "fecha" => $fecha, "localidades" => $localidades, "caja" => $caja,
                "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3, "searchText4" => $query4
            ]);
        }
    }


    public function show($id)
    {
        $registro = DB::table('registro as r')
            ->join('usuario as u', 'r.codUsuario', '=', 'u.codUsuario')
            ->join('cliente as c', 'r.codCliente', '=', 'c.codCliente')
            ->join('localidad as l', 'r.codLocalidad', 'l.codLocalidad')
            ->where('codRegistro', $id)
            ->first();

        $metodoPago = ['EFECTIVO', 'TRANSFERENCIA'];

        $pagos = Pago::where('codRegistro', $id)
            ->orderByDesc('fechaPago')
            ->get();

        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();

        return view('reporte.rango.pago', compact("registro", "metodoPago", "pagos", "caja"));
    }

    public function store_pago(PagoRequest $request)
    {
        $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
        $mytime = Carbon::now('America/Lima');
        $fecha_hora = $mytime->toDateTimeString();
        try {
            $pago = new Pago();
            $pago->fechaPago = $fecha_hora;
            $pago->metodoPago = $request->get('metodoPago');
            $pago->importePago = $request->get('importePago');
            $pago->codRegistro = $request->get('codRegistro');
            $pago->codCaja = $caja->codCaja;
            $pago->save();
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
        return redirect()->back()->with(['success' => '¡Satisfactorio!, Pago agregado correctamente.']);
    }

    public function eliminarPago($id)
    {
        try {
            // Obtener el pago a eliminar
            $pago = Pago::findOrFail($id);
            $pago->delete();
            return redirect()->back()->with('success', 'Pago eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error al eliminar el pago.');
        }
    }

    public static function valElimPago ($id){
        $pago = Pago::findOrfail($id);
        $caja = AperturaCierre::where('codCaja', $pago->codCaja)->first();
        return $caja->fechaCierre == null ? true : false;
    }

    public static function estadoPago ($id){
        $registro = Registro::findOrfail($id);
        $pagos = Pago::where('codRegistro', $id)
            ->select(DB::raw('SUM(importePago) as total'))
            ->first();
        $pagos = isset($pagos->total) ? $pagos->total : 0;

        return $pagos >=  $registro->costoTarifa ? true : false;
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
        $id3 = $id3 == '-1' ? '' : $id3;
        $id4 = $id4 == '-1' ? '' : $id4;


        $registro = DB::table('registro as r')
            ->join('usuario as u', 'r.codUsuario', '=', 'u.codUsuario')
            ->join('cliente as c', 'r.codCliente', '=', 'c.codCliente')
            ->join('localidad as l', 'r.codLocalidad', '=', 'l.codLocalidad')
            ->select(
                'codRegistro',
                'fechRegistro',
                'horainicio',
                'horafinal',
                'r.estado',
                'duracion',
                'nomLocalidad',
                'u.nombres as nomUsuario',
                'c.nombres as nomCliente',
                'r.comentario',
                'r.codLocalidad',
            )

            ->whereBetween('fechRegistro', [$id, $id2])
            ->Where(function ($q)  use ($id3) {
                $q->orWhere('horainicio', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('horafinal', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('c.nombres', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('u.nombres', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('r.estado', 'LIKE', '%' . $id3 . '%');
            })
            ->Where('r.codLocalidad', $id4 == "" ? "!=" : "=", $id4)
            ->orderByDesc('fechRegistro')
            ->orderByDesc('horainicio')
            ->get();


        $empresa = DB::table('empresa')->first();
        $pdf = \PDF::loadView('reporte.rango.report', [
            "registro" => $registro, "empresa" => $empresa, "fecha_hora" => $fecha_hora,
            "id" => $id, "id2" => $id2, "id3" => $id3, "id4" => $id4
        ])
            ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function reportExcel($f1, $f2, $f3, $f4)
    {
        return Excel::download(new Rango($f1, $f2, $f3, $f4), 'ReporteFechaReservas.xlsx');
    }
}
