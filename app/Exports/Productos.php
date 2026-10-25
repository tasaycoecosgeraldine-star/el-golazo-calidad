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

class Productos implements FromView, WithColumnFormatting, ShouldAutoSize
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
        $columna = auth()->user()->tipo == 'ADMINISTRADOR' ? 'G' : 'F';
        return [$columna => NumberFormat::FORMAT_NUMBER_00];
    }

    public function view(): View{
        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();

        $id=$this->f1=='TODO' ? '' : $this->f1;
        $this->f2=$this->f2=='TODO' ? '' : $this->f2;

        // if (auth()->user()->tipo == 'ADMINISTRADOR') {
        //     $producto = DB::table('producto as p')
        //     ->join('categoria as c','p.codCategoria','c.codCategoria')
        //     ->join('localidad as l','p.codLocalidad','l.codLocalidad')
        //     ->select('nomProducto','Precio','imagen','p.descripcion','p.codProducto','stock','c.nombre as nomCategoria', 'nomLocalidad')
        //     ->orderBy('nomProducto')
        //     ->orderByDesc('Precio')
        //     ->where('nomLocalidad', 'LIKE', '%' . $this->f2 . '%')
        //     ->Where(function ($q)  use ($id) {
        //         $q->orwhere('nomProducto', 'LIKE', '%' . $id . '%')
        //         ->orwhere('c.nombre', 'LIKE', '%' . $id . '%')
        //         ->orwhere('stock', 'LIKE', '%' . $id . '%');

        //     })->get();
        // }else{
        //     $producto = DB::table('producto as p')
        //     ->join('categoria as c','p.codCategoria','c.codCategoria')
        //     ->join('localidad as l','p.codLocalidad','l.codLocalidad')
        //     ->select('nomProducto','Precio','imagen','p.descripcion','p.codProducto','stock','c.nombre as nomCategoria', 'nomLocalidad')
        //     ->orderBy('nomProducto')
        //     ->orderByDesc('Precio')
        //     ->where('l.codLocalidad', auth()->user()->codLocalidad)
        //     ->Where(function ($q)  use ($id) {
        //         $q->orwhere('nomProducto', 'LIKE', '%' . $id . '%')
        //         ->orwhere('c.nombre', 'LIKE', '%' . $id . '%')
        //         ->orwhere('stock', 'LIKE', '%' . $id . '%');
        //     })->get();
        // }
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
        ->paginate(15);
        return view('almacen/producto.excel', ["id"=>$id, "id2"=>$this->f2,  "producto"=>$producto, "fecha"=>$fecha]);
    }
}
