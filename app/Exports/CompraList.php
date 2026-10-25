<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class CompraList implements FromView, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $f1, $f2;
    public function __construct($f1, $f2){

        $this->f1 = $f1;
        $this->f2 = $f2;

    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_00
        ];
    }


    public function view(): View{

        $ingresos = DB::table('compras as i')
        ->join('proveedores as p', 'i.idpro', '=', 'p.idpro')
        ->join('detalle_compras as di', 'i.idCom', '=', 'di.idCom')
        ->select('i.idCom', 'i.fecCom', 'p.nomPro', DB::raw('sum(di.cantidad*precioCompra) as total'))
        ->whereBetween('fecCom', [$this->f1, $this->f2])
        ->orderBy('i.idCom', 'desc')
        ->groupBy('i.idCom', 'i.fecCom', 'p.nomPro')
        ->get();

        return view('compras.compra.listExcel', ["ingresos"=>$ingresos, "inicio" => $this->f1, "fin" => $this->f2]);

    }
}
