<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VentaFormRequest;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Detalleventa;
use App\Models\Empresa;
use Exception;
use Carbon\Carbon;
use response;
use Illuminate\Support\collection;


use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));
        if ($request) {

            $detalle_venta = DB::table('detalle_venta')
                ->get();

            $venta = DB::table('venta as v')
                ->join('cliente as c', 'v.codCliente', 'c.codCliente')
                ->select('v.fechVenta', 'v.codVenta', 'v.horaVenta', 'v.totalVenta', 'v.estado', 'c.nombres', 'metodoPago')
                ->Where(function ($q)  use ($query) {
                    $q->orwhere('nombres', 'LIKE', '%' . $query . '%');
                })
                ->orderByDesc('v.codVenta')
                ->paginate(10);

            return view('ventas.venta.index', ["venta" => $venta, "detalle_venta" => $detalle_venta, "searchText" => $query]);
        }
    }
    public function create(Request $request)
    {
        $query = trim($request->get('searchText'));

        if ($request) {

            $producto = DB::table('producto')->get();

            $cliente = DB::table('cliente')->orderByDesc('codCliente')->get();

            $localidad = DB::table('localidad')->where('nomLocalidad', '!=', 'TODO')->get();

            $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
            return view('ventas.venta.create', ["producto" => $producto, "cliente" => $cliente, "localidad" => $localidad, "caja" => $caja, "searchText" => $query]);
        }
    }
    public function store(VentaFormRequest $request)
    {
        try {
            $codProducto = $request->get('codProducto');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precioVenta = $request->get('precioVenta');

            // Inicio Calculo Stock
            $producto = DB::table('producto')->get();
            $cont_0 = 0;
            $arr = array();
            foreach ($producto as $pro) {
                $arr[strval($pro->codProducto)] = $pro->stock;
            }
            while ($cont_0 < count($codProducto)) {
                $arr[strval($codProducto[$cont_0])] = $arr[strval($codProducto[$cont_0])] - $cantidad[$cont_0];
                if ($arr[strval($codProducto[$cont_0])] < 0) {
                    return redirect()->back()->with(['error' => 'La cantidad a vender supera el stock en unos de los productos.']);;
                }
                $cont_0 = $cont_0 + 1;
            }
            // Fin Calculo Stock
            $caja = DB::table('caja')->where('montoCierre', '=', null)->first();
            // DB::beginTransaction();
            $venta = new Venta;
            $venta->codCliente =  strtoupper($request->get('codCliente'));
            $venta->codCaja = $caja->codCaja;
            $venta->totalVenta = $request->get('totalVenta');
            $mytime = Carbon::now('America/Lima');
            $fecha_hora = $mytime->toDateTimeString();
            $fecha_hora1 = $mytime->toTimeString();
            $venta->fechVenta = $fecha_hora;
            $venta->horaVenta = $fecha_hora1;
            $venta->metodoPago = $request->get('metodoPago');
            $venta->estado = 'a';
            $venta->save();

            $cont = 0;
            while ($cont < count($codProducto)) {
                $detalle = new Detalleventa;
                $detalle->codVenta = $venta->codVenta;
                $detalle->codProducto = $codProducto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->precioVenta = $precioVenta[$cont];
                $detalle->save();

                // Actualizamos el stock de los productos
                $produc = Producto::findOrFail($codProducto[$cont]);
                $produc->stock = $produc->stock - $cantidad[$cont];
                $produc->update();
                $cont = $cont + 1;
            }
            return Redirect::to('ventas/venta')->with(['success' => 'Se ha agregado correctamente']);
            // DB::commit();
        } catch (Exception $e) {
            // DB::rollback();
            return redirect()->back()->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }
    public function show($id)
    {
        $venta = DB::table('venta as v')
            ->join('cliente as c', 'v.codCliente', 'c.codCliente')
            ->join('detalle_venta as dv', 'v.codVenta', 'dv.codVenta')
            ->join('producto as pd', 'dv.codProducto', 'pd.codProducto')
            ->select('v.codVenta', 'v.fechVenta', 'v.horaVenta', 'dv.codProducto', 'v.totalVenta', 'v.estado', 'pd.stock', 'c.nombres')
            ->where('v.codVenta', $id)
            ->first();
        $detalle_venta = DB::table('detalle_venta as d')
            ->join('producto as p', 'd.codProducto', 'p.codProducto')
            ->select('p.nomProducto', 'd.cantidad', 'd.precioVenta', 'd.descuento')
            ->where('d.codVenta', $id)
            ->get();
        return view("ventas.venta.show", ["venta" => $venta, "detalle_venta" => $detalle_venta]);
    }

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {

                $docu   = Venta::findOrFail($id);

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

    public function exportPdf($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        $venta = DB::table('venta as v')
            ->join('cliente as c', 'v.codCliente', 'c.codCliente')
            ->join('detalle_venta as dv', 'v.codVenta', 'dv.codVenta')
            ->join('producto as pd', 'dv.codProducto', 'pd.codProducto')
            ->select('v.codVenta', 'v.fechVenta', 'v.horaVenta', 'dv.codProducto', 'v.totalVenta', 'v.estado', 'pd.stock', 'c.nombres', 'metodoPago')
            ->where('v.codVenta', $id)
            ->first();
        $detalle_venta = DB::table('detalle_venta as d')
            ->join('producto as p', 'd.codProducto', 'p.codProducto')
            ->select('p.nomProducto', 'd.cantidad', 'd.precioVenta', 'd.descuento')
            ->where('d.codVenta', $id)
            ->get();

        $datos = Empresa::first();
        $pdf = \PDF::loadView('ventas.venta.report', ["venta" => $venta, "detalle_venta" => $detalle_venta, "fechaHora" => $fechaHora, "datos" => $datos])
            ->setPaper('b7', 'portrait');
        return $pdf->stream('Venta #' . $venta->codVenta . '.pdf');
    }

    public function listPdf($id)
    {

        $id = $id == 'TODO' ? '' : $id;
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fecha_hora = $mytime->toDateTimeString();

        $venta = DB::table('venta as v')
            ->join('cliente as c', 'v.codCliente', 'c.codCliente')
            ->select('v.codVenta', 'v.fechVenta', 'v.horaVenta', 'v.totalVenta', 'v.estado', 'c.nombres', 'metodoPago')
            ->Where(function ($q)  use ($id) {
                $q->orwhere('c.nombres', 'LIKE', '%' . $id . '%');
            })->get();


        $datos = Empresa::first();

        $pdf = \PDF::loadView('ventas.venta.list', ["venta" => $venta,  "id" => $id, "fecha_hora" => $fecha_hora, "datos" => $datos]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
