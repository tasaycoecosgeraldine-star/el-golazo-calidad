<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Carbon\Carbon;

class Rango1 implements FromView, WithColumnFormatting, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $f1, $f2, $f3, $f4;
    public function __construct($f1, $f2, $f3, $f4)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->f3 = $f3;
        $this->f4 = $f4;
    }
    public function columnFormats(): array
    {
        return ['F' => NumberFormat::FORMAT_NUMBER_00];
    }
    public function view(): View
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $id3 = $this->f3 == 'TODO' ? '' : $this->f3;
        $this->f4 = $this->f4 == 'TODO' ? '' : $this->f4;


        $ventas = DB::table('venta as v')
            ->join('cliente as c', 'v.codCliente', '=', 'c.codCliente')
            ->select(
                'codVenta',
                'fechVenta',
                'horaVenta',
                'totalVenta',
                'v.estado',
                'c.nombres as nomCliente'
            )

            ->whereBetween('fechVenta', [$this->f1, $this->f2])
            ->Where(function ($q)  use ($id3) {
                $q->orWhere('horaVenta', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('c.nombres', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('v.estado', 'LIKE', '%' . $id3 . '%');
            })
            ->orderByDesc('fechVenta')
            ->orderByDesc('horaVenta')
            ->get();
        return view('reporte/rango1.excel', ["id" => $this->f1, "id2" => $this->f2, "id3" => $this->f3, "ventas" => $ventas, "fecha" => $fecha]);
    }
}
