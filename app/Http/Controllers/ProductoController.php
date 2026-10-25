<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductoFormRequest;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Productos;

use App\Models\Producto;
use Carbon\Carbon;


class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        $query2 = trim($request->get('searchText2'));

        $query=$query=='TODO'?'':$query;
        $query2=$query2=='TODO'?'':$query2;
        if ($request) {
            $categoria = DB::table('categoria')-> get();

                $producto = DB::table('producto as p')
                ->join('categoria as c','p.codCategoria','c.codCategoria')
                ->select('nomProducto','Precio','imagen','p.descripcion','p.codProducto','stock','c.nombre as nomCategoria')
                ->Where(function ($q)  use ($query) {
                    $q->orwhere('nomProducto', 'LIKE', '%' . $query . '%')
                    ->orwhere('precio', 'LIKE', '%' . $query . '%')
                    ->orwhere('c.nombre', 'LIKE', '%' . $query . '%')
                    ->orwhere('stock', 'LIKE', '%' . $query . '%');
                })
                ->orderBy('nomProducto')
                ->orderByDesc('Precio')
                ->paginate(15);


            $localidad = DB::table('localidad')->where('nomLocalidad', '!=', 'TODO')->get();

            return view('almacen.producto.index', ["producto" => $producto,"categoria" => $categoria, "localidad"=>$localidad,
            "searchText" => $query, "searchText2" => $query2]);
        }
    }
    // public function create()
    // {
    //     return view('almacen.producto.create');
    // }
    public function store(ProductoFormRequest $request)
    {
        try{
            $producto = new Producto;
            $producto->nomProducto =  strtoupper($request->get('nomProducto'));
            $producto->Precio = $request->get('Precio');
            if($request->hasFile('imagen')){
                $file = $request->file('imagen');
                $file->move(public_path() . '/Imagen', $file->getClientOriginalName());
                $producto->imagen = $file->getClientOriginalName();
            }
            // $producto->descripcion = $request->get('descripcion');
            $producto->stock = $request->get('stock');
            $producto->codCategoria = $request->get('codCategoria');
            $producto->save();
            return Redirect::to('almacen/producto')->with(['success' => 'Se ha agregado correctamente']);
        }catch(Exception $e){
            return redirect()->back()->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }
    public function edit($id)
    {
        $localidad = DB::table('localidad')->where('nomLocalidad', '!=', 'TODO')->get();
        $categoria = DB::table('categoria')->get();
        return view("almacen.producto.edit", ["producto" => Producto::findOrFail($id),"localidad"=>$localidad, "categoria" => $categoria]);
    }
    public function update(ProductoFormRequest $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->nomProducto =  strtoupper($request->get('nomProducto'));
            $producto->Precio = $request->get('Precio');
            if($request->hasFile('imagen')){
                $file = $request->file('imagen');
                $file->move(public_path() . '/Imagen', $file->getClientOriginalName());
                $producto->imagen = $file->getClientOriginalName();
            }
            // $producto->descripcion = $request->get('descripcion');
            $producto->stock = $request->get('stock');
            $producto->codCategoria = $request->get('codCategoria');

            $producto->update();
            return Redirect::to('almacen/producto')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/localidad')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }

    }

    public function destroy(Request $request, $id)
    {


        try {
            if ($request->ajax()) {

                $docu   = Producto::findOrFail($id);

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

    public function listPdf($id, $id2){

        $id=$id=='TODO'?'':$id;
        $id2=$id2=='TODO'?'':$id2;

        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fecha_hora = $mytime->toDateTimeString();
        // if (auth()->user()->tipo == 'ADMINISTRADOR') {
        //     $producto = DB::table('producto as p')
        //     ->join('categoria as c','p.codCategoria','c.codCategoria')
        //     ->join('localidad as l','p.codLocalidad','l.codLocalidad')
        //     ->select('nomProducto','Precio','imagen','p.descripcion','p.codProducto','stock','c.nombre as nomCategoria', 'nomLocalidad')
        //     ->orderBy('nomProducto')
        //     ->orderByDesc('Precio')
        //     ->where('nomLocalidad', 'LIKE', '%' . $id2 . '%')
        //     ->Where(function ($q)  use ($id) {
        //         $q->orwhere('nomProducto', 'LIKE', '%' . $id . '%')
        //         ->orwhere('c.nombre', 'LIKE', '%' . $id . '%')
        //         ->orwhere('stock', 'LIKE', '%' . $id . '%');

        //     })->get();
        // }else{
            $producto = DB::table('producto as p')
            ->join('categoria as c','p.codCategoria','c.codCategoria')
            ->select('nomProducto','Precio','imagen','p.descripcion','p.codProducto','stock','c.nombre as nomCategoria')
            ->Where(function ($q)  use ($id) {
                $q->orwhere('nomProducto', 'LIKE', '%' . $id . '%')
                ->orwhere('precio', 'LIKE', '%' . $id . '%')
                ->orwhere('c.nombre', 'LIKE', '%' . $id . '%')
                ->orwhere('stock', 'LIKE', '%' . $id . '%');
            })
            ->orderBy('nomProducto')
            ->orderByDesc('Precio')
            ->get();

        // }
        $datos = DB::table('empresa')->first();

        $pdf = \PDF::loadView('almacen/producto.list', ["producto"=>$producto,  "id"=>$id, "fecha_hora"=>$fecha_hora, "datos"=>$datos]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
    public function reportExcel($f1, $f2){
        return Excel::download(new Productos($f1, $f2), 'ReporteProductos.xlsx');
    }
}
