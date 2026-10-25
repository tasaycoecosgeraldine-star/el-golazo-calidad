<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Mensual;


class ReporteMensualController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $mytime = Carbon::now('America/Lima');
            $fecha = $mytime->toDateString();
            $mes = trim ($request -> get('searchText'));
            $anio = trim ($request -> get('searchText2'));
            $query4 = trim ($request -> get('searchText4'));
            //Array de meses
            $meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

            //Array de anios
            $anio_actual = intval(date('Y'))-5;
            for ($p=0; $p <= 5; $p++) {
                $anios_vista[$p] = $anio_actual++;
            }

            $mes = empty($mes) ? date('m') : $mes;
            $anio = empty($anio) ? date('Y') : $anio;
            $query4 = $query4 == 'TODO'?'':$query4;



            $fecha_actual = date($anio . '-'. str_pad($mes, 2, "0", STR_PAD_LEFT) . '-d');
            $dias_del_mes = date('t', strtotime($fecha_actual));

            for ($i=0; $i < $dias_del_mes; $i++) {
                $valor_fecha = $anio . '-' . $mes . '-'. str_pad(strval($i+1), 2, "0", STR_PAD_LEFT);
                $registro = DB::table('pagos as p')
                ->select(DB::raw('SUM(importePago) as pago'))->whereBetween('fechaPago', [$valor_fecha . ' 00:00:00', $valor_fecha . ' 23:59:59'])->first();

                $venta = DB::table('venta as v')
                ->select(DB::raw('SUM(totalVenta) as totalVenta'))->where('FechVenta', $valor_fecha)->first();

                $ingreso = DB::table('ingreso as i')
                ->join('caja as c', 'i.codCaja', 'c.codCaja')
                ->select(DB::raw('SUM(importe) as importe'))->where('fechaIngreso', $valor_fecha)->where('i.estado', 'APROBADO')->first();

                $egreso = DB::table('egreso as e')
                ->join('caja as c', 'e.codCaja', 'c.codCaja')
                ->select(DB::raw('SUM(importe) as importe'))->where('fechaEgreso', $valor_fecha)->where('e.estado', 'APROBADO')->first();

                $valor_reserva = !isset($registro->pago) ? 0 : $registro->pago;
                $valor_venta = !isset($venta->totalVenta) ? 0 : $venta->totalVenta;
                $valor_ingreso = !isset($ingreso->importe) ? 0 : $ingreso->importe;
                $valor_egreso = !isset($egreso->importe) ? 0 : $egreso->importe;
                $array_fechas[$i] = $valor_fecha . '_' . $valor_reserva . '_' . $valor_venta . '_' . $valor_ingreso . '_' . $valor_egreso;
            }
            $localidad = DB::table('localidad')->where('nomLocalidad', '!=', 'TODO')->get();

            return view('reporte.mensual.index', ["array_fechas" => $array_fechas, "localidad"=> $localidad, "meses"=>$meses,
             "searchText"=>$mes, "searchText2"=>$anio, "anios_vista"=>$anios_vista, "searchText4"=>$query4, "fecha"=>$fecha]);
        }
    }

    public function reportPdf($id, $id2, $id4)
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $fecha_hora = $mytime->toDateTimeString();

        $mes = $id == 'TODO' ? date('m') : $id;
        $anio = $id2 == 'TODO' ? date('Y') : $id2;
        $query4 = $id4 == 'TODO'?'':$id4;

        $fecha_actual = date($anio . '-'. str_pad($mes, 2, "0", STR_PAD_LEFT) . '-d');
        $dias_del_mes = date('t', strtotime($fecha_actual));

        for ($i=0; $i < $dias_del_mes; $i++) {
            $valor_fecha = $anio . '-' . $mes . '-'. str_pad(strval($i+1), 2, "0", STR_PAD_LEFT);
            $registro = DB::table('pagos as p')
                ->select(DB::raw('SUM(importePago) as pago'))
                ->whereBetween('fechaPago', [$valor_fecha . ' 00:00:00', $valor_fecha . ' 23:59:59'])->first();

            $venta = DB::table('venta as v')
            ->select(DB::raw('SUM(totalVenta) as totalVenta'))->where('FechVenta', $valor_fecha)->first();

            $ingreso = DB::table('ingreso as i')
            ->join('caja as c', 'i.codCaja', 'c.codCaja')
            ->select(DB::raw('SUM(importe) as importe'))->where('fechaIngreso', $valor_fecha)->where('i.estado', 'APROBADO')->first();

            $egreso = DB::table('egreso as e')
            ->join('caja as c', 'e.codCaja', 'c.codCaja')
            ->select(DB::raw('SUM(importe) as importe'))->where('fechaEgreso', $valor_fecha)->where('e.estado', 'APROBADO')->first();

            $valor_reserva = !isset($registro->pago) ? 0 : $registro->pago;
            $valor_venta = !isset($venta->totalVenta) ? 0 : $venta->totalVenta;
            $valor_ingreso = !isset($ingreso->importe) ? 0 : $ingreso->importe;
            $valor_egreso = !isset($egreso->importe) ? 0 : $egreso->importe;
            $array_fechas[$i] = $valor_fecha . '_' . $valor_reserva . '_' . $valor_venta . '_' . $valor_ingreso . '_' . $valor_egreso;
        }

        $empresa = DB::table('empresa')->first();
        $pdf = \PDF::loadView('reporte/mensual.report', ["array_fechas" => $array_fechas, "empresa"=> $empresa, "fecha" => $fecha,
        "fecha_hora"=>$fecha_hora, "id"=>$id, "id2"=>$id2, "id4"=>$id4]);
        // ->setPaper('a4', 'landscape');
        return $pdf->stream('Reporte Mensual.pdf');
    }


    public function reportExcel($f1, $f2, $f3){
        return Excel::download(new Mensual($f1, $f2, $f3), 'ReporteFechaReservas.xlsx');
    }


}
