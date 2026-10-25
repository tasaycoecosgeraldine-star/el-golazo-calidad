<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $table = 'pagos';
    protected $primaryKey = 'idPago';
    public $timestamps = false;
    protected $fillable = [
        'fechaPago',
        'metodoPago',
        'importePago',
        'codRegistro',
        'codCaja'
    ];
    protected $guarded = [];
}
