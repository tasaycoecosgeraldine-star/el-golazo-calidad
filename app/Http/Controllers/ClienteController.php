<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ClienteFormRequest;

use App\Models\Cliente;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Exception;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        $query=trim($request->get('searchText'));
        $paginate = 15;
        $query = $query == 'TODO' ? '' : $query;
        if($request){
            $cliente = DB::table('cliente')
            ->orwhere('nombres', 'LIKE', '%' . $query . '%')
            ->orwhere('numDocumento', 'LIKE', '%' . $query . '%')
            ->orwhere('email', 'LIKE', '%' . $query . '%')
            ->orwhere('estado', 'LIKE', '%' . $query . '%')
            ->orwhere('telefono', 'LIKE', '%' . $query . '%')
            ->orderByDesc('codCliente')
            ->paginate($paginate);
             return view('registro.cliente.index',["cliente"=>$cliente,"searchText"=>$query, "paginate"=>$paginate]);
        }
    }
    public function create()
    {
        // $autor = DB::table('')->get();
        return view('registro.cliente.create');
    }
    public function store(ClienteFormRequest $request)
    {
        try{
            $mytime = Carbon::now('America/Lima');
            $fecha_hora = $mytime->toDateTimeString();
            $cliente = new Cliente;
            $cliente->nombres =  ucwords($request->get('nombres'));
            $cliente->numDocumento = $request->get('numDocumento');
            $cliente->creacion = $fecha_hora;
            $cliente->direccion = $request->get('direccion');
            $cliente->email = $request->get('email');
            $cliente->fechNac = $request->get('fechaNac');
            $cliente->telefono = $request->get('telefono');
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $file->move(public_path() . '/Imagenes/Fotos/', $file->getClientOriginalName());
                $cliente->foto = $file->getClientOriginalName();
            }
            $cliente->estado = 'ACTIVO';
            $cliente->save();
            // return Redirect::to('registro/cliente');
            return Redirect::back()->with(['success' => '¡Satisfactorio!, Cliente agregado correctamente.']);
        }catch(Exception $e){
            return redirect()->back()->with(['error' => 'Ocurrió un error al procesar su petición.']);
        }
    }
    public function update(ClienteFormRequest $request, $id)
    {
        try{
            $cliente = Cliente::findOrFail($id);
            $cliente->nombres =  ucwords($request->get('nombres'));
            $cliente->numDocumento = $request->get('numDocumento');
            $cliente->direccion = $request->get('direccion');
            $cliente->email = $request->get('email');
            $cliente->fechNac = $request->get('fechaNac');
            $cliente->telefono = $request->get('telefono');
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $file->move(public_path() . '/Imagenes/Fotos/', $file->getClientOriginalName());
                $cliente->foto = $file->getClientOriginalName();
            }
            $cliente->update();
            return Redirect::to('registro/cliente')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('registro/cliente')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }
    public function show($id)
    {
        $n_id = substr($id, 1);
        $vuser = DB::table('cliente')
            ->where('codCliente', '=', $n_id)
            ->first();
        if (isset($vuser->estado)) {
            if ($vuser->estado == 'ACTIVO') {
                $estado = "INACTIVO";
            } else {
                $estado = "ACTIVO";
            }
        }

        $paciente = Cliente::findOrFail($n_id);
        $paciente->estado = $estado;
        $paciente->update();
        return Redirect::to('registro/cliente');
    }
    public function edit( $id)
    {
        return view("registro.cliente.edit", ["cliente" => Cliente::findOrFail($id)]);
    }



    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = Cliente::findOrFail($id);

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

    public function listPdf($id){

        $id=$id=='TODO'?'':$id;
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fecha_hora = $mytime->toDateTimeString();
        $cliente = DB::table('cliente as c')
        ->Where(function ($q)  use ($id) {
            $q->orwhere('nombres', 'LIKE', '%' . $id . '%')
            ->orwhere('genero', 'LIKE', '%' . $id . '%')
            ->orwhere('numDocumento', 'LIKE', '%' . $id . '%');
        })
        ->orderByDesc('codCliente')
        ->get();
        $localidad = DB::table('localidad')->where('codLocalidad', auth()->user()->codLocalidad)->first();

        $pdf = \PDF::loadView('registro/cliente.list', ["cliente"=>$cliente,  "id"=>$id, "localidad"=>$localidad,
                    "fecha_hora"=>$fecha_hora])
        ->setPaper('a4', 'landscape');
        return $pdf->stream();

    }
}
