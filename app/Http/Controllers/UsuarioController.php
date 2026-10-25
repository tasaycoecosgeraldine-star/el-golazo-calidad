<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuarioFormRequest;
use App\Http\Requests\UsuarioEditFormRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;


class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        if ($request) {
            $paginate = 15;
            $tipos = ['PERSONAL', 'ADMINISTRADOR'];
            $query = trim($request->get('searchText'));
            $usuario = DB::table('usuario as u')
                ->select(
                    'nombres',
                    'numDocumento',
                    'password',
                    'creacion',
                    'u.direccion',
                    'fechaNac',
                    'email',
                    'u.telefono',
                    'tipo',
                    'foto',
                    'estado',
                    'u.codUsuario',
                )
                ->orwhere('nombres', 'LIKE', '%' . $query . '%')
                ->orwhere('tipo', 'LIKE', '%' . $query . '%')
                ->paginate(15);
            return view('acceso.usuario.index', ["tipos" => $tipos, "usuario" => $usuario, "paginate" => $paginate, "searchText" => $query]);
        }
    }


    public function edit($id)
    {
        $tipos = ['ADMINISTRADOR', 'PERSONAL'];
        $localidad = DB::table('localidad')
            ->where('nomLocalidad', '!=', 'TODO')
            ->get();

        return view("acceso.usuario.edit", [
            "usuario" => User::findOrFail($id), "tipos" => $tipos,
            "localidad" => $localidad
        ]);
    }



    public function update(UsuarioFormRequest $request, $id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->nombres = $request->get('nombres');
            // $usuario->Apellidos=$request->get('Apellidos');
            $usuario->numDocumento = $request->get('numDocumento');
            $usuario->direccion = $request->get('direccion');
            $usuario->telefono = $request->get('telefono');
            $usuario->email = $request->get('email');
            $usuario->tipo = $request->get('tipo');
            if ($request->get('password') != '') {
                $usuario->password = bcrypt($request->get('password'));
            }
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('Imagen/' . $filename));
                $usuario->foto = $filename;
            }
            $usuario->update();
            return Redirect::to('acceso/usuario')->with(['success' => 'Se ha modificado correctamente.']);
        } catch (Exception $e) {
            return Redirect::to('acceso/usuario')->with(['error' => 'Ocurrió un error al procesar su petición.']);
        }
    }

    public function show($id)
    {
        $n_id = substr($id, 1);

        $vuser = DB::table('usuario')
            ->where('codUsuario', '=', $n_id)
            ->first();
        if (isset($vuser->estado)) {
            if ($vuser->estado == 'ACTIVO') {
                $estado = "INACTIVO";
            } else {
                $estado = "ACTIVO";
            }
        }

        $usuario = User::findOrFail($n_id);
        $usuario->estado = $estado;
        $usuario->update();
        return Redirect::to('acceso/usuario');
    }


    public function store(UsuarioFormRequest $request)
    {
        try {
            $mytime = Carbon::now('America/Lima');
            $fecha_hora = $mytime->toDateTimeString();
            $usuario = new User;
            $usuario->nombres = $request->get('nombres');
            // $usuario->Apellidos = $request->get('Apellidos');
            $usuario->numDocumento = $request->get('numDocumento');
            $usuario->password = bcrypt($request->get('numDocumento'));
            $usuario->creacion = $fecha_hora;
            $usuario->direccion = $request->get('direccion');
            $usuario->telefono = $request->get('telefono');
            $usuario->email = $request->get('email');
            $usuario->estado = "ACTIVO";
            $usuario->tipo = $request->get('tipo');
            if ($request->hasFile('foto')) {

                $file = $request->file('foto');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('Imagen/' . $filename));
                $usuario->foto = $filename;
            }
            // $usuario->codLocalidad = $request->get('codLocalidad');
            $usuario->save();

            return Redirect::to('acceso/usuario')->with(['success' => 'Se ha agregado correctamente.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => 'Ocurrió un error al procesar su petición.']);
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = User::findOrFail($id);

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
