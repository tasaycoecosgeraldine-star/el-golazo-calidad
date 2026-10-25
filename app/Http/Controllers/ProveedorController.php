<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProveedorFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $personas = DB::table('proveedores')
                ->where('idpro', '!=', '1')
                ->Where(function ($q)  use ($query) {
                    $q->orwhere('nomPro', 'LIKE', '%' . $query . '%')
                        ->orwhere('telPro', 'LIKE', '%' . $query . '%');
                })
                ->orderBy('idpro', 'desc')
                ->paginate(7);
            return view('compras.proveedor.index', ["personas" => $personas, "searchText" => $query]);
        }
    }
    public function create()
    {
        return view("compras.proveedor.create");
    }

    public function store(ProveedorFormRequest $request)
    {
        $proveedor = new Proveedor;
        $proveedor->nomPro = $request->get('nomPro');
        $proveedor->telPro = $request->get('phone');
        $proveedor->save();
        return Redirect::to('compras/proveedor')->with(['success' => $proveedor->nomPro . ' agregado correctamente.']);
    }
    public function show($id)
    {
        return view("compras.proveedor.show", ["proveedor" => Proveedor::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("compras.proveedor.edit", ["proveedor" => Proveedor::findOrFail($id)]);
    }
    public function update(ProveedorFormRequest $request, $id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->nomPro = $request->get('nomPro');
            $proveedor->telPro =  $request->get('phone');
            $proveedor->update();
            return Redirect::to('compras/proveedor')->with(['success' => $proveedor->nomPro . ' modificado correctamente.']);
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = Proveedor::findOrFail($id);

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
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros de Productos.',
                ]);
            }
        }
    }
}
