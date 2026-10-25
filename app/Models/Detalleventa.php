<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalleventa extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = 'codDetalle_venta';
    public $timestamps = false;
    protected $fillable = [
        'cantidad',
        'precioVenta',
        'descuento',
        'codVenta',
        'codProducto'
    ];
    protected $guarded = [];
}
