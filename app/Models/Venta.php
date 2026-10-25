<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'codVenta';
    public $timestamps = false;
    protected $fillable = [
        'fechVenta',
        'horaVenta',
        'totalVenta',
        'estado',
        'codCliente'
    ];
    protected $guarded = [];
}
