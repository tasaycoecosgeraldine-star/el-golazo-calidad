<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Registro;
use App\Http\Requests\RegistroFormRequest;

class ListadoRegistroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $query = trim($request->get('searchText'));
        $query2 = trim($request->get('searchText2'));
        $query3 = trim($request->get('searchText3'));

        $query = empty($query) ? $fecha : $query;

        $query2 = $query2 == 'TODO' ? '': $query2;
        $query3 = $query3 == 'TODO' ? '': $query3;
        // $query3 = auth()->user()->tipo == 'DOCTOR' ? auth()->user()->nombres: $query3;
        if ($request) {
            if(auth()->user()->tipo == 'ADMINISTRADOR'){
                $registro = DB::table('registro as r')
                ->join('usuario as u', 'r.codUsuario','=', 'u.codUsuario')
                ->join('cliente as c', 'r.codCliente','=', 'c.codCliente')
                ->join('localidad as l', 'r.codLocalidad','=', 'l.codLocalidad')
                ->select('codRegistro', 'fechRegistro', 'horainicio', 'horafinal', 'r.estado', 'nomLocalidad', 'pago',
                'u.nombres as nomUsuario', 'c.nombres as nomCliente', 'comentario', 'imgComprobante', 'r.tipo')
                ->orderByDesc('fechRegistro')
                ->orderByDesc('horainicio')
                ->where('fechRegistro', 'LIKE', '%' . $query . '%')
                ->where('l.nomLocalidad', 'LIKE', '%' . $query3 . '%')
                ->Where(function ($q)  use ($query2) {
                    $q->orwhere('c.nombres', 'LIKE', '%' . $query2 . '%')
                    ->orwhere('horainicio', 'LIKE', '%' . $query2 . '%')
                    ->orwhere('horafinal', 'LIKE', '%' . $query2 . '%')
                    ->orwhere('r.tipo', 'LIKE', '%' . $query2 . '%')
                    ->orwhere('r.estado', 'LIKE', '%' . $query2 . '%');
                })
                ->paginate(10);
            }else{
                $registro = DB::table('registro as r')
                ->join('usuario as u', 'r.codUsuario','=', 'u.codUsuario')
                ->join('cliente as c', 'r.codCliente','=', 'c.codCliente')
                ->join('localidad as l', 'r.codLocalidad','=', 'l.codLocalidad')
                ->select('codRegistro', 'fechRegistro', 'horainicio', 'horafinal', 'r.estado', 'nomLocalidad', 'pago',
                'u.nombres as nomUsuario', 'c.nombres as nomCliente', 'comentario', 'imgComprobante', 'r.tipo')
                ->orderByDesc('fechRegistro')
                ->orderByDesc('horainicio')
                ->where('fechRegistro', 'LIKE', '%' . $query . '%')
                ->where('l.codLocalidad', auth()->user()->codLocalidad)
                ->Where(function ($q)  use ($query2) {
                    $q->orwhere('c.nombres', 'LIKE', '%' . $query2 . '%')
                    ->orwhere('horainicio', 'LIKE', '%' . $query2 . '%')
                    ->orwhere('horafinal', 'LIKE', '%' . $query2 . '%')
                    ->orwhere('r.tipo', 'LIKE', '%' . $query2 . '%')
                    ->orwhere('r.estado', 'LIKE', '%' . $query2 . '%');
                })
                ->paginate(10);
            }


            $query2 = empty($query2) ? 'TODO': $query2;
            $query3 = empty($query3) ? 'TODO': $query3;

            $localidad = DB::table('localidad')->where('nomLocalidad', '!=','TODO')->get();

            return view('registro.listado.index', ["registro" => $registro, "fecha" => $fecha, "localidad"=>$localidad,
             "searchText" => $query, "searchText2" => $query2, "searchText3" => $query3]);
        }
    }

    public function update(RegistroFormRequest $request, $id)
    {
        try {
            $registro = Registro::findOrFail($id);
            $registro->pago = $request->get('pago');
            $registro->metodoPago = $request->get('metodoPago');
            $registro->estado = $request->get('estado');
            $registro->comentario = $request->get('comentario');
            if ($request->hasFile('imgComprobante')) {
                $file = $request->file('imgComprobante');
                $file->move(public_path() . '/imgComprobante', $file->getClientOriginalName());
                $registro->imgComprobante = $file->getClientOriginalName();
            }
            $registro->update();
            return redirect()->back()->with(['success' => 'Se ha Confirmado correctamente la reserva']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/localidad')->with(['error' => 'Ocurrió un error al procesar su petición']);
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

    public function listPdf($id, $id2, $id3){
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fecha_hora = $mytime->toDateTimeString();
        $id = empty($id) ? $fecha : $id;
        $id2 = $id2 == 'TODO' ? '': $id2;
        $id3 = $id3 == 'TODO' ? '': $id3;

        if(auth()->user()->tipo == 'ADMINISTRADOR'){
            $registro = DB::table('registro as r')
            ->join('usuario as u', 'r.codUsuario','=', 'u.CodUsuario')
            ->join('cliente as c', 'r.codCliente','=', 'c.codCliente')
            ->join('localidad as l', 'r.codLocalidad','=', 'l.codLocalidad')
            ->select('codRegistro', 'fechRegistro', 'horainicio', 'horafinal', 'r.estado', 'nomLocalidad', 'pago',
            'u.nombres as nomUsuario', 'c.nombres as nomCliente', 'comentario', 'imgComprobante')
            ->orderByDesc('fechRegistro')
            ->orderByDesc('horainicio')
            ->where('fechRegistro', 'LIKE', '%' . $id . '%')
            ->where('l.nomLocalidad', 'LIKE', '%' . $id3 . '%')
            ->Where(function ($q)  use ($id2) {
                $q->orwhere('c.nombres', 'LIKE', '%' . $id2 . '%')
                ->orwhere('horainicio', 'LIKE', '%' . $id2 . '%')
                ->orwhere('horafinal', 'LIKE', '%' . $id2 . '%')
                ->orwhere('r.estado', 'LIKE', '%' . $id2 . '%');
                })->get();
        }else{
            $registro = DB::table('registro as r')
            ->join('usuario as u', 'r.codUsuario','=', 'u.CodUsuario')
            ->join('cliente as c', 'r.codCliente','=', 'c.codCliente')
            ->join('localidad as l', 'r.codLocalidad','=', 'l.codLocalidad')
            ->select('codRegistro', 'fechRegistro', 'horainicio', 'horafinal', 'r.estado', 'nomLocalidad', 'pago',
            'u.nombres as nomUsuario', 'c.nombres as nomCliente', 'comentario', 'imgComprobante')
            ->orderByDesc('fechRegistro')
            ->orderByDesc('horainicio')
            ->where('fechRegistro', 'LIKE', '%' . $id . '%')
            ->where('l.codLocalidad', auth()->user()->codLocalidad)
            ->Where(function ($q)  use ($id2) {
                $q->orwhere('c.nombres', 'LIKE', '%' . $id2 . '%')
                ->orwhere('horainicio', 'LIKE', '%' . $id2 . '%')
                ->orwhere('horafinal', 'LIKE', '%' . $id2 . '%')
                ->orwhere('r.estado', 'LIKE', '%' . $id2 . '%');
                })->get();
        }
        $empresa = DB::table('empresa')->first();

        $pdf = \PDF::loadView('registro/listado.list', ["registro"=>$registro, "empresa"=> $empresa, "id"=>$id, "id2"=>$id2,
                    "fecha_hora"=>$fecha_hora])
        ->setPaper('a4', 'landscape');
        return $pdf->stream();

    }


}
