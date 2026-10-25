<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compras';
    protected $primaryKey = 'idDetCom';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
