<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategoriaFormRequest;
use App\Http\Requests\ConsultorioEditFormRequest;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;
use Response;
use Exception;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        if ($request) {
            $categoria = DB::table('categoria')
                ->where('nombre', 'LIKE', '%' . $query . '%')
                ->orderByDesc('codCategoria')
                ->paginate(10);
            return view('almacen.categoria.index', ["categoria" => $categoria, "searchText" => $query]);
        }
    }
    public function create()
    {
        return view('almacen.categoria.create');
    }
    public function store(CategoriaFormRequest $request)
    {
        try {
            //code...
            $categoria = new Categoria();
            $categoria->nombre = $request->get('nombre');
            $categoria->save();
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', '¡Error!, ' . $e->getMessage());
        }
        return redirect()->back()->with('success', '¡Satisfactorio!, ' . $categoria->nombre . ' agregado.');
    }
    public function edit($id)
    {

        return view("almacen.categoria.edit", ["categoria" => Categoria::findOrFail($id)]);
    }
    public function update(categoriaFormRequest $request, $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->nombre =  strtoupper($request->get('nombre'));
            $categoria->descripcion = $request->get('descripcion');
            $categoria->update();
            return Redirect::to('almacen/categoria')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/localidad')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = Categoria::findOrFail($id);

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
