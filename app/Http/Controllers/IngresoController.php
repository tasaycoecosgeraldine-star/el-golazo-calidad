<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\IngresoFormRequest;
use Carbon\Carbon;

use App\Models\Ingreso;
use Exception;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        $query2 = trim($request->get('searchText2'));
        if ($request) {

            $ingreso = DB::table('ingreso as i')
                ->join('caja as c', 'i.codCaja', 'c.codCaja')
                ->where('estado', 'LIKE', '%' . $query . '%')
                ->Where(function ($q)  use ($query2) {
                    $q->orwhere('recibidoDe', 'LIKE', '%' . $query2 . '%')
                        ->orwhere('motivo', 'LIKE', '%' . $query2 . '%')
                        ->orwhere('importe', 'LIKE', '%' . $query2 . '%');
                })
                // ->where('montoCierre', null)
                ->paginate(10);
            $registro = [];
            $k = 0;

            $estado = ['APROBADO', 'ANULADO'];
            $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
            return view('caja.ingreso.index', [
                "ingreso" => $ingreso, "registro" => $registro, "estado" => $estado, "caja" => $caja,
                "searchText" => $query, "searchText2" => $query2
            ]);
        }
    }
    public function create()
    {
        return view('caja.ingreso.create');
    }
    public function store(IngresoFormRequest $request)
    {
        $caja = DB::table('caja')->where('montoCierre', null)->first();
        if (!isset($caja->codCaja)) {
            return redirect()->back()->with(['error' => 'Recuerde aperturar caja para poder continuar.']);
        }
        try {
            $mytime = Carbon::now('America/Lima');
            $hora = $mytime->toTimeString();
            $fecha = $mytime->toDateString();

            $ingreso = new Ingreso;
            $ingreso->horaIngreso =  $hora;
            $ingreso->fechaIngreso = $fecha;
            $ingreso->recibidoDe = $request->get('recibidoDe');
            $ingreso->motivo = $request->get('motivo');
            $ingreso->importe = $request->get('importe');
            $ingreso->estado = 'APROBADO';
            $ingreso->codCaja = $caja->codCaja;
            $ingreso->save();
            return Redirect::to('caja/ingreso')->with(['success' => 'Se ha agregado correctamente']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => 'Ocurrió un error al procesar su petición.']);
        }
    }
    public function edit($id)
    {
        return view("caja.ingreso.edit", ["ingreso" => Ingreso::findOrFail($id)]);
    }
    public function update(IngresoFormRequest $request, $id)
    {
        try {
            $ingreso = Ingreso::findOrFail($id);
            $ingreso->horaIngreso =  $request->get('horaIngreso');
            $ingreso->fechaIngreso = $request->get('fechaIngreso');
            $ingreso->recibidoDe = $request->get('recibidoDe');
            $ingreso->motivo = $request->get('motivo');
            $ingreso->importe = $request->get('importe');
            $ingreso->estado = $request->get('estado');
            $ingreso->codCaja = $request->get('codCaja');
            $ingreso->update();
            return Redirect::to('caja/ingreso')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/localidad')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = Ingreso::findOrFail($id);
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
