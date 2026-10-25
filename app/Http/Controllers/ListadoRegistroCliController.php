<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Registro;
use App\Http\Requests\ConfirmarFormRequest;
use Exception;

class ListadoRegistroCliController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $start = date('Y-m-01', strtotime($fecha));
        $fecha = date('Y-m-t', strtotime($fecha));

        $query = trim($request->get('searchText'));
        $query2 = trim($request->get('searchText2'));
        $query3 = trim($request->get('searchText3'));

        $query = empty($query) ? $start : $query;
        $query2 = empty($query2) ? $fecha : $query2;
        $query3 = $query3 == 'TODO' ? '': $query3;

        if ($request) {
                $registro = DB::table('registro as r')
                ->join('usuario as u', 'r.codUsuario','=', 'u.codUsuario')
                ->join('cliente as c', 'r.codCliente','=', 'c.codCliente')
                ->join('localidad as l', 'r.codLocalidad','=', 'l.codLocalidad')
                ->select('codRegistro', 'fechRegistro', 'horainicio', 'horafinal', 'r.estado', 'nomLocalidad', 'pago',
                'u.nombres as nomUsuario', 'c.nombres as nomCliente', 'comentario', 'imgComprobante')
                // ->Where('fechRegistro', 'LIKE', '%' . $query . '%')
                ->whereBetween('fechRegistro', [$query, $query2])
                ->where('r.codCliente', auth()->guard('client')->user()->codCliente)
                ->Where(function ($q)  use ($query3) {
                    $q->orwhere('nomLocalidad', 'LIKE', '%' . $query3 . '%')
                    ->orwhere('horainicio', 'LIKE', '%' . $query3 . '%')
                    ->orwhere('horafinal', 'LIKE', '%' . $query3 . '%')
                    ->orwhere('r.estado', 'LIKE', '%' . $query3 . '%');
                })
                ->orderByDesc('fechRegistro')
                ->orderByDesc('horainicio')
                ->paginate(10);


            $query2 = empty($query2) ? 'TODO': $query2;

            $localidad = DB::table('localidad')->where('nomLocalidad', '!=','TODO')->get();

            return view('registroCliente.mis_reservas.index', ["registro" => $registro, "fecha" => $fecha, "localidad"=>$localidad,
             "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3]);
        }
    }
    public function update(ConfirmarFormRequest $request, $id)
    {
        try {
            $registro = Registro::findOrFail($id);
            $registro->pago = $request->get('pago');
            $registro->estado = 'CONFIRMADO';
            $registro->tipo = 'WEB';
            $registro->comentario = $request->get('comentario');
            if ($request->hasFile('imgComprobante')) {
                $file = $request->file('imgComprobante');
                $file->move(public_path() . '/imgComprobante', $file->getClientOriginalName());
                $registro->imgComprobante = $file->getClientOriginalName();
            }
            $registro->update();
            return redirect()->back()->with(['success' => $id]);
        } catch (Exception $e) {
            return Redirect::to('registroCliente/mis_reservas')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = Registro::findOrFail($id);

                if ($docu->delete()) {
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
