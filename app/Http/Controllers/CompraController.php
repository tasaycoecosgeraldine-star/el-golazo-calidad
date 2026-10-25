<?php

namespace App\Http\Controllers;

use App\Compra as AppCompra;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\IngresoFormRequest;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\DetalleCompra;
use App\Exports\CompraList;
use App\Exports\CompraListDetail;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class CompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mytime = Carbon::now('America/Lima');

        $start = date('Y-m-01', strtotime($mytime->toDateString()));
        $end = date('Y-m-t', strtotime($mytime->toDateString()));

        if ($request) {
            $query = trim($request->get('searchText'));
            $query2 = trim($request->get('searchText2'));

            $query = empty($query) ? $start : $query;
            $query2 = empty($query2) ? $end : $query2;

            $ingresos = DB::table('compras as i')
                ->join('proveedores as p', 'i.idpro', '=', 'p.idpro')
                ->join('detalle_compras as di', 'i.idCom', '=', 'di.idCom')
                ->select('i.idCom', 'i.fecCom', 'p.nomPro', DB::raw('sum(di.cantidad*precioCompra) as total'))
                ->whereBetween('fecCom', [$query . ' 00:00:01', $query2 . ' 23:59:59'])
                ->orderBy('i.idCom', 'desc')
                ->groupBy('i.idCom', 'i.fecCom', 'p.nomPro')
                ->paginate(7);

            return view('compras.compra.index', ["ingresos" => $ingresos, "searchText" => $query, "searchText2" => $query2]);
        }
    }

    public function create()
    {
        $personas = DB::table('proveedores')->where('idpro', '!=', '1')->orderByDesc('idpro')->get();
        $articulos = DB::table('producto as art')
            ->select(DB::raw('CONCAT(art.nomProducto) as articulo'), 'art.codProducto', 'art.stock')
            ->get();
        $unidadMedida = DB::table('unidad_medida')->orderBy('valorUM')->get();
        return view("compras.compra.create", ["personas" => $personas, "articulos" => $articulos, "unidadMedida" => $unidadMedida]);
    }

    public function store(IngresoFormRequest $request)
    {

        try {
            DB::beginTransaction();
            $compra = new Compra();
            $compra->idpro = $request->get('idproveedor');
            $compra->codUsuario = auth()->user()->codUsuario;
            // $compra->tipo_comprobante=$request->get('tipo_comprobante');
            // $compra->serie_comprobante=$request->get('serie_comprobante');
            // $compra->num_comprobante=$request->get('num_comprobante');
            $mytime = Carbon::now('America/Lima');
            $compra->fecCom = $mytime->toDateTimeString();
            // $compra->impuesto='18';
            // $compra->estado='A';
            $compra->save();

            $idarticulo = $request->get('idarticulo');
            $uMedida = $request->get('unidadMedida');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            // $precio_venta = $request->get('precio_venta');

            $cont = 0;

            while ($cont < count($idarticulo)) {
                $detalle = new DetalleCompra();
                $detalle->idCom = $compra->idCom;
                $detalle->codProducto = $idarticulo[$cont];
                $detalle->valorUMedida = $uMedida[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precioCompra = $precio_compra[$cont];
                // $detalle->precioVenta = $precio_venta[$cont];
                $detalle->save();

                $produc = Producto::findOrFail($idarticulo[$cont]);
                $produc->stock = $produc->stock + ($cantidad[$cont] * $uMedida[$cont]);
                $produc->update();
                $cont = $cont + 1;
            }

            DB::commit();
            return Redirect::to('compras/compra')->with(['success' => 'Ingreso agregado correctamente.']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' =>  $e->getMessage()]);
        }
    }
    public function show($id)
    {
        $ingreso = DB::table('compras as i')
            ->join('proveedores as p', 'i.idpro', 'p.idpro')
            ->join('detalle_compras as di', 'i.idCom', '=', 'di.idCom')
            ->select('p.nomPro', DB::raw('sum(di.cantidad*precioCompra) as total'))
            ->groupBy('i.idCom', 'p.nomPro')
            ->where('i.idCom', $id)
            ->first();
        $detalles = DB::table('detalle_compras as di')
            ->join('producto as p', 'p.codProducto', 'di.codProducto')
            ->select('p.NomProducto', 'di.cantidad', 'di.valorUMedida', 'di.precioCompra')
            ->where('di.idCom', $id)
            ->get();
        return view("compras.compra.show", ["ingreso" => $ingreso, "detalles" => $detalles]);
    }

    public function destroy($id)
    {
        $ingreso = Compra::findOrFail($id);
        $ingreso->Estado = 'C';
        $ingreso->update();
        return Redirect::to('compras/compra');
    }

    public function list_compra($query, $query2)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha_hora = $mytime->toDateTimeString();

        $ingresos = DB::table('compras as i')
            ->join('proveedores as p', 'i.idpro', '=', 'p.idpro')
            ->join('detalle_compras as di', 'i.idCom', '=', 'di.idCom')
            ->select('i.idCom', 'i.fecCom', 'p.nomPro', DB::raw('sum(di.cantidad*precioCompra) as total'))
            ->whereBetween('fecCom', [$query . ' 00:00:01', $query2 . ' 23:59:59'])
            ->orderBy('i.idCom', 'desc')
            ->groupBy('i.idCom', 'i.fecCom', 'p.nomPro')
            ->get();

        $datos = DB::table('empresa')->first();
        $pdf = \PDF::loadView('compras/compra/listPdf', ["ingresos" => $ingresos, "inicio"=>$query, "fin"=>$query2, "datos"=>$datos, "fecha_hora"=>$fecha_hora]);
        return $pdf->stream();
    }

    public function list_compraE($f1, $f2){
        return Excel::download(new CompraList($f1, $f2), 'Listado de Compras.xlsx');
    }

    public function list_compraDetalladoE($f1, $f2){
        return Excel::download(new CompraListDetail($f1, $f2), 'Listado de Compras Detallado.xlsx');
    }
}
