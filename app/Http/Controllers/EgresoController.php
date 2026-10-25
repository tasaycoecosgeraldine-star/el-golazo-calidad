<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EgresoFormRequest;
use Carbon\Carbon;

use App\Models\Egreso;
use Exception;

class EgresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        $query2 = trim($request->get('searchText2'));
        $query3 = trim($request->get('searchText3'));
        if ($request) {

            $egreso = DB::table('egreso as e')
                ->join('caja as c', 'e.codCaja', 'c.codCaja')
                ->where('tipo', 'LIKE', '%' . $query . '%')
                ->where('estado', 'LIKE', '%' . $query2 . '%')
                ->Where(function ($q)  use ($query3) {
                    $q->orwhere('entregadoA', 'LIKE', '%' . $query3 . '%')
                        ->orwhere('motivo', 'LIKE', '%' . $query3 . '%')
                        ->orwhere('importe', 'LIKE', '%' . $query3 . '%');
                })
                // ->where('montoCierre', null)
                ->paginate(10);
            $localidad = DB::table('localidad')->where('nomLocalidad', '!=', 'TODO')->get();

            $estado = ['APROBADO', 'ANULADO'];
            $tipo = ['Compras', 'Servicios', 'Remuneraciones'];
            $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
            return view('caja.egreso.index', [
                "egreso" => $egreso, "estado" => $estado, "tipo" => $tipo, "caja" => $caja,
                "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3
            ]);
        }
    }
    public function create()
    {
        return view('caja.egreso.create');
    }
    public function store(EgresoFormRequest $request)
    {
        try {
            $mytime = Carbon::now('America/Lima');
            $hora = $mytime->toTimeString();
            $fecha = $mytime->toDateString();
            $caja = DB::table('caja')->where('montoCierre', null)->first();

            $ingreso = new Egreso();
            $ingreso->horaEgreso =  $hora;
            $ingreso->fechaEgreso = $fecha;
            $ingreso->tipo = $request->get('tipo');
            $ingreso->entregadoA = $request->get('entregadoA');
            $ingreso->motivo = $request->get('motivo');
            $ingreso->importe = $request->get('importe');
            $ingreso->estado = 'APROBADO';
            $ingreso->codCaja = $caja->codCaja;
            $ingreso->save();
            return Redirect::to('caja/egreso')->with(['success' => 'Se ha agregado correctamente']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = Egreso::findOrFail($id);
                $docu->estado = 'ANULADO';
                if ($docu->update()) {
                    return response()->json([
                        'success' => true,
                        'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => '¡Error!, No se pudo eliminar.',
                    ]);
                }
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros.',
                ]);
            }
        }
    }
}
