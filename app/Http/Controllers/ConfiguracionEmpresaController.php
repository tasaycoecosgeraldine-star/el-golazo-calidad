<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EmpresaFormRequest;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Exception;

class ConfiguracionEmpresaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if($request){
            $empresa = DB::table('empresa')->first();
            return view('configuracion.ajustes.index',["empresa"=>$empresa]);
        }

    }

    public function update(EmpresaFormRequest $request, $id)
    {
        try {

            $localidad=Empresa::findOrFail($id);
            $localidad->nombre = $request->get('nombre');
            $localidad->direccion = $request->get('Direccion');
            $localidad->telefono = $request->get('telefono');

            if($request->hasFile('Logo')){
                $file = $request->file('Logo');
                $filename    = $file->getClientOriginalName();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('Logo/' .$filename));
                // $image_resize->move(public_path().'/Logo',$file->getClientOriginalName());
                $localidad -> logo=$filename;
            }

            $localidad->update();
            return Redirect::to('configuracion/ajustes')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/ajustes')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }

    }
}
