<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuarioFormRequest;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;


class MPerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $usuario = DB::table('usuario as u')
            ->select('codUsuario', 'numDocumento', 'tipo', 'u.telefono', 'u.direccion', 'email', 'u.nombres', 'u.foto')
            ->Where('u.codUsuario', '=', auth()->user()->codUsuario)
            ->first();
            return view('configuracion.mi_perfil.index',["usuario"=>$usuario]);

        }
    }

    public function update(UsuarioFormRequest $request,$id)
    {
        try {
            $usuario=User::findOrFail($id);
            $usuario->nombres=$request->get('nombres');
            $usuario->numDocumento=$request->get('numDocumento');
            $usuario->direccion=$request->get('direccion');
            $usuario->telefono=$request->get('telefono');
            $usuario->email=$request->get('email');
            if ($request->get('password') != ''){
                $usuario->password = bcrypt($request->get('password'));
            }

            if($request->hasFile('foto')){
                $file = $request->file('foto');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('Imagen/' . $filename));
                $usuario->foto = $filename;
            }
            $usuario->update();
            return Redirect::to('configuracion/mi_perfil')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/mi_perfil')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }
}
