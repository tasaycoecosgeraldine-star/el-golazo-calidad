<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanelAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->componentName = 'Panel de Control';
    }
    public function index(Request $request)
    {

        // if (auth()->user()->tipo !="ADMINISTRADOR"){
        //     Auth::logout();
        //     return redirect('/')
        //     ->with('flash','Usted no tiene privilegios para ingresar en la ruta solicitada.');
        // }
        $mytime = Carbon::now('America/Lima');
        $fecha_actual = $mytime->toDateString();
        $dia_uno = date('Y-m-01', strtotime($fecha_actual));
        $dia_final = date('Y-m-t', strtotime($fecha_actual));

        $query = trim($request->get('searchText'));
        $query2 = trim($request->get('searchText2'));

        $query = empty($query) ? $dia_uno : $query;
        $query2 = empty($query2) ? $dia_final : $query2;

        if ($request) {


            $informe1 = [];
            $val_aux = $query;
            while (strtotime($val_aux) <= strtotime($query2)) {
                $totalVenta = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))->where('fechVenta', $val_aux)
                    ->first();

                $alquiler = DB::table('pagos')->select(DB::raw('SUM(importePago) as pago'))
                    ->whereBetween('fechaPago', [$val_aux . ' 00:00:00', $val_aux . ' 23:59:59'])
                    ->first();
                $alquiler = !isset($alquiler->pago) ? 0 : $alquiler->pago;

                $ingreso = DB::table('ingreso')->select(DB::raw('SUM(importe) as importe'))
                    ->where('fechaIngreso', $val_aux)
                    ->where('estado', 'APROBADO')
                    ->first();
                $ingreso = !isset($ingreso->importe) ? 0 : $ingreso->importe;

                $egreso = DB::table('egreso')->select(DB::raw('SUM(importe) as importe'))
                    ->where('fechaEgreso', $val_aux)
                    ->where('estado', 'APROBADO')
                    ->first();
                $egreso = !isset($egreso->importe) ? 0 : $egreso->importe;

                $informe1[] = array("date_sale" => $val_aux, "cantidad" =>  isset($totalVenta->totalVenta) ? $totalVenta->totalVenta : 0.00, "alquiler" => $alquiler, "ingreso" => $ingreso, "egreso" => $egreso * -1);
                $val_aux = date('Y-m-d', strtotime('+1 day', strtotime($val_aux)));
            }


            $informe2 = [];
            foreach (DB::table('cliente')->get() as $i) {
                $nroVenta = DB::table('venta')->whereBetween('fechVenta',  [$query, $query2])
                    ->where('codCliente', $i->codCliente)->get();
                $informe2[] = array("cliente" => $i->nombres, "cantidad" => count($nroVenta));
            }
            $caja = DB::table('caja as b')
                ->join('usuario as u', 'b.codUsuario', 'u.codUsuario')
                ->where('montoCierre', null)->first();

            $informe3 = [];
            $producto = DB::table('detalle_venta as dv')
                // ->join('venta as v', 'dv.codVenta', 'v.codVenta')
                ->join('producto as p', 'dv.codProducto', 'p.codProducto')
                ->select('nomProducto', 'precioVenta', DB::raw('SUM(dv.cantidad) as cantidad'))
                ->groupBy('p.codProducto', 'precioVenta', 'nomProducto')
                ->orderByDesc('cantidad')
                ->get();
            foreach ($producto as $key) {
                // echo $key->nomProducto . ' ' . $key->cantidad . '<br>';
                $informe3[] = array("nomProducto" =>  $key->nomProducto, "cantidad" => $key->cantidad);
            }

            return view('panel_control.index', [
                "informe3" => $informe3,
                "informe2" => $informe2, "informe1" => $informe1,
                "searchText" => $query, "searchText2" => $query2, "componentName" => $this->componentName,
                "caja" => $caja
            ]);
        }
    }
}
