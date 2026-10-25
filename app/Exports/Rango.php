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

class Rango implements FromView, ShouldAutoSize
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

    // public function columnFormats(): array
    // {

    //     // return ['L' => NumberFormat::FORMAT_NUMBER_00];
    // }
    public function view(): View
    {
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $id3 = $this->f3 == '-1' ? '' : $this->f3;
        $this->f4 = $this->f4 == '-1' ? '' : $this->f4;


        $registro = DB::table('registro as r')
            ->join('usuario as u', 'r.codUsuario', '=', 'u.codUsuario')
            ->join('cliente as c', 'r.codCliente', '=', 'c.codCliente')
            ->join('localidad as l', 'r.codLocalidad', '=', 'l.codLocalidad')
            ->select(
                'codRegistro',
                'fechRegistro',
                'horainicio',
                'horafinal',
                'r.estado',
                'duracion',
                'nomLocalidad',
                'u.nombres as nomUsuario',
                'c.nombres as nomCliente',
                'r.comentario',
            )
            ->whereBetween('fechRegistro', [$this->f1, $this->f2])
            ->Where(function ($q)  use ($id3) {
                $q->orWhere('horainicio', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('horafinal', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('c.nombres', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('u.nombres', 'LIKE', '%' . $id3 . '%')
                    ->orWhere('r.estado', 'LIKE', '%' . $id3 . '%');
            })
            ->Where('r.codLocalidad', $this->f4 == "" ? "!=" : "=", $this->f4)
            ->orderByDesc('fechRegistro')
            ->orderByDesc('horainicio')
            ->get();

        return view('reporte.rango.excel', ["id" => $this->f1, "id2" => $this->f2, "id3" => $this->f3, "registro" => $registro, "fecha" => $fecha]);
    }
}
