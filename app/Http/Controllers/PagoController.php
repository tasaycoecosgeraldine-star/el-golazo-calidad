<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Localidad;

class PagoController extends Controller
{
    //
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


            $registro = DB::table('pagos as p')
                ->join('registro as r', 'p.codRegistro', '=', 'r.codRegistro')
                ->join('cliente as c', 'r.codCliente', '=', 'c.codCliente')
                ->join('localidad as l', 'r.codLocalidad', 'l.codLocalidad')
                ->select(
                	'idPago',
                    'r.codRegistro',
                    'fechRegistro',
                    'horainicio',
                    'horafinal',
                    'r.estado',
                    'duracion',
                    'nomLocalidad',
                    'c.nombres as nomCliente',
                    'metodoPago',
                    'importePago',
                    'r.codLocalidad'
                )
                ->whereBetween('fechRegistro', [$query, $query2])
                ->Where(function ($q)  use ($query3) {
                    $q->orWhere('horainicio', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('horafinal', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('c.nombres', 'LIKE', '%' . $query3 . '%')
                        ->orWhere('r.estado', 'LIKE', '%' . $query3 . '%');
                })
                ->Where('r.codLocalidad', $query4 == "" ? "!=" : "=", $query4)
                ->orderByDesc('fechRegistro')
                ->orderByDesc('horainicio')
                ->paginate(50);
        
            $localidades = Localidad::orderBy('nomLocalidad')->get();

            return view('reporte.pago.index', [
                "registro" => $registro, "fecha" => $fecha, "localidades" => $localidades,
                "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3, "searchText4" => $query4
            ]);
        }
    }
}
