<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LocalidadFormRequest;
use App\Http\Requests\ConsultorioEditFormRequest;
use App\Models\Localidad;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Intervention\Image\ImageManagerStatic as Image;

class LocalidadController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        if ($request) {
            $localidad = DB::table('localidad')
                ->where('nomLocalidad', 'LIKE', '%' . $query . '%')
                ->paginate(20);
            return view('configuracion.localidad.index', ["localidad" => $localidad,"searchText" => $query]);
        }
    }
    public function create()
    {
        return view('configuracion.localidad.create');
    }
    public function store(LocalidadFormRequest $request)
    {
        try{
            $localidad = new Localidad;
            $localidad->nomLocalidad =  $request->get('nomLocalidad');
            $localidad->precioDia =  $request->get('precioDia');
            $localidad->precioNoche =  $request->get('precioNoche');
            // $localidad->direccion = $request->get('direccion');
            // $localidad->telefono = $request->get('telefono');

            if($request->hasFile('logo')){
                $file = $request->file('logo');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('Logo/' .$filename));
                $localidad -> logo=$filename;
            }
            $localidad->save();
            return Redirect::to('configuracion/localidad')->with(['success' => 'Se ha agregado correctamente.']);
        }catch(Exception $e){
            return redirect()->back()->with(['error' => 'Ocurrió un error al procesar su petición']);
        }

    }
    public function edit($id)
    {
        return view("configuracion.localidad.edit", ["localidad" => Localidad::findOrFail($id)]);
    }
    public function update(LocalidadFormRequest $request, $id)
    {
        try {
            $localidad = Localidad::findOrFail($id);
            $localidad->nomLocalidad =  $request->get('nomLocalidad');
            $localidad->precioDia =  $request->get('precioDia');
            $localidad->precioNoche =  $request->get('precioNoche');
            $localidad->direccion = $request->get('direccion');
            if($request->hasFile('logo')){
                $file = $request->file('logo');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('Logo/' .$filename));
                $localidad -> logo=$filename;
            }
            $localidad->telefono = $request->get('telefono');
            $localidad->update();
            return Redirect::to('configuracion/localidad')->with(['success' => '¡Satisfactorio!, Se ha modificado correctamente.']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/localidad')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }


    }

    public function destroy(Request $request, $id)
    {


        try {
            if ($request->ajax()) {

                $docu   = Localidad::findOrFail($id);

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
