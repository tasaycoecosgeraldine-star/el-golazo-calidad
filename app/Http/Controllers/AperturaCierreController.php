<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use App\Http\Requests\AperturaCierreFormRequest;
use App\Models\AperturaCierre;
use App\Models\Empresa;

class AperturaCierreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $registro = DB::table('caja')->where('montoCierre', null)->first();
            $datos = Empresa::first();
            // $caja = DB::table('caja')->where('codCaja', $query)->first();
            return view('caja.apertura_cierre.index', ["searchText" => $query, "registro" => $registro, "datos" => $datos]);
        }
    }


    public function store(AperturaCierreFormRequest $request)
    {
        $caja = new AperturaCierre();
        $mytime = Carbon::now('America/Lima');
        $caja->horaApertura = $mytime->toTimeString();
        $caja->fechaApertura = $mytime->toDateString();
        $caja->montoApertura = $request->get('montoApertura');
        $caja->codUsuario = auth()->user()->codUsuario;
        $caja->save();
        return redirect()->back()->with(['flash' =>  'Caja Aperturada Correctamente']);
    }

    public function update(AperturaCierreFormRequest $request, $id)
    {
        $caja = AperturaCierre::findOrFail($id);
        $mytime = Carbon::now('America/Lima');
        $caja->horaCierre = $mytime->toTimeString();
        $caja->fechaCierre = $mytime->toDateString();
        $caja->montoCierre = $request->get('montoCierre');
        $caja->update();
        return redirect()->back()->with(['success' =>  $id]);
    }

    public static function fechaCastellano($fecha)
    {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        // return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
        return $nombredia . " " . $numeroDia . " de " . $nombreMes;
    }

    public function reportPdf($id)
    {
        $mytime = Carbon::now('America/Lima');
        $fechaHora = $mytime->toDateTimeString();
        $caja = DB::table('caja as c')
            ->join('usuario as u', 'c.codUsuario', 'u.codUsuario')
            ->where('codCaja', $id)->first();

        $reserva_efectivo = DB::table('pagos')->select(DB::raw('SUM(importePago) as pago'))
            ->where('codCaja', $id)->where('metodoPago', 'EFECTIVO')->first();
        $reserva_efectivo = !isset($reserva_efectivo->pago) ? 0 : $reserva_efectivo->pago;

        $reserva_transferencia = DB::table('pagos')->select(DB::raw('SUM(importePago) as pago'))
            ->where('codCaja', $id)->where('metodoPago', 'TRANSFERENCIA')->first();
        $reserva_transferencia = !isset($reserva_transferencia->pago) ? 0 : $reserva_transferencia->pago;

        $reserva = ['efectivo' => $reserva_efectivo, 'transferencia' => $reserva_transferencia];
        // ----------------------------------------------------------------------------------

        // $registro_web = DB::table('registro')
        //     ->select(DB::raw('SUM(pago) as pago'))
        //     ->where('codCaja', $id)->where('tipo', 'web')
        //     ->first();
        // ------------------------------------------------------------------------------------

        $venta_efectivo = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))
            ->where('codCaja', $id)->where('metodoPago', 'EFECTIVO')->first();
        $venta_efectivo = !isset($venta_efectivo->totalVenta) ? 0 : $venta_efectivo->totalVenta;

        $venta_transferencia = DB::table('venta')->select(DB::raw('SUM(totalVenta) as totalVenta'))
            ->where('codCaja', $id)->where('metodoPago', 'TRANSFERENCIA')->first();
        $venta_transferencia = !isset($venta_transferencia->totalVenta) ? 0 : $venta_transferencia->totalVenta;

        $venta = ['efectivo' => $venta_efectivo, 'transferencia' => $venta_transferencia];


        $ingreso = DB::table('ingreso')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('estado', 'APROBADO')
            ->where('codCaja', $id)
            ->first();

        $egreso = DB::table('egreso')
            ->select(DB::raw('SUM(importe) as importe'))
            ->where('estado', 'APROBADO')
            ->where('codCaja', $id)
            ->first();

        $egreso_compra = DB::table('egreso')->select(DB::raw('SUM(importe) as importe'))
            ->where('estado', 'APROBADO')->where('tipo', 'Compras')->where('codCaja', $id)->first();

        $egreso_servicios = DB::table('egreso')->select(DB::raw('SUM(importe) as importe'))
            ->where('estado', 'APROBADO')->where('tipo', 'Servicios')->where('codCaja', $id)->first();

        $egreso_remuneraciones = DB::table('egreso')->select(DB::raw('SUM(importe) as importe'))
            ->where('estado', 'APROBADO')->where('tipo', 'Remuneraciones')->where('codCaja', $id)->first();

        $listaEgreso = [$egreso_compra->importe, $egreso_servicios->importe, $egreso_remuneraciones->importe];

        $producto = DB::table('detalle_venta as dv')->join('venta as v', 'dv.codVenta', 'v.codVenta')
            ->join('producto as p', 'dv.codProducto', 'p.codProducto')
            ->where('v.codCaja', $id)->get();

        $datos = Empresa::first();
        $pdf = \PDF::loadView('caja.apertura_cierre.report', [
            "caja" => $caja, "venta" => $venta, "ingreso" => $ingreso,
            "reserva" => $reserva, "egreso" => $egreso, "listaEgreso" => $listaEgreso, "producto" => $producto,
            "fechaHora" => $fechaHora, "datos" => $datos
        ])
            ->setPaper(array(0, 0, 204, 650));
        return $pdf->stream('Arqueo de Caja #' . $caja->codCaja . '.pdf');
    }
}
