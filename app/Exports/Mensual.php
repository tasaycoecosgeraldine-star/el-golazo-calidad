<?php
namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
class Mensual implements FromView, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $f1, $f2, $f4;
    public function __construct($f1, $f2, $f4){
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->f4 = $f4;

    }
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_00,
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'E' => NumberFormat::FORMAT_NUMBER_00,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'g' => NumberFormat::FORMAT_NUMBER_00
        ];
    }
    public function view(): View{
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

        $id=$this->f1=='TODO' ? '' : $this->f1;
        $this->f2=$this->f2=='TODO' ? '' : $this->f2;

        $mes = $this->f1 == 'TODO' ? date('m') : $this->f1;
        $anio = $this->f2 == 'TODO' ? date('Y') : $this->f2;
        $query4 = $this->f4 == 'TODO'?'':$this->f4;

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


        return view('reporte/mensual.excel', ["id"=>$id, "id2"=>$this->f2,  "array_fechas"=>$array_fechas, "fecha"=>$fecha]);
    }
}
