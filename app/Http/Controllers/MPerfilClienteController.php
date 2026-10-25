<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ClienteFormRequest;
use Illuminate\Support\Carbon;
use App\Models\Cliente;
use Exception;

use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
class MPerfilClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function index(Request $request)
    {
        if ($request) {
            $cliente = DB::table('cliente')
            ->Where('codCliente', auth()->guard('client')->user()->codCliente)
            ->first();
            return view('configuracion.mi_perfil_c.index',["cliente"=>$cliente]);

        }
    }

    public function update(ClienteFormRequest $request,$id)
    {
        try {
            $usuario=Cliente::findOrFail($id);
            $usuario->nombres=$request->get('nombres');
            $usuario->numDocumento=$request->get('numDocumento');
            $usuario->direccion=$request->get('direccion');
            $usuario->telefono=$request->get('telefono');
            $usuario->email=$request->get('email');
            if ($request->get('password') != ''){
                $usuario->password = bcrypt($request->get('password'));
            }

            $filePath = !empty($usuario->foto) ? public_path() . '/Imagenes/Fotos/'. $usuario->foto : -1;
            if($request->hasFile('foto')){
                $file = $request->file('foto');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('Imagenes/Fotos/' . $filename));
                $usuario->foto = $filename;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $usuario->update();
            return Redirect::to('configuracion/mi_perfil_c')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/mi_perfil_c')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }

}
