<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaCierre extends Model
{
    protected $table = 'caja';
    protected $primaryKey = 'codCaja';
    public $timestamps = false;
    protected $fillable = [
        'horaApertura',
        'fechaApertura',
        'montoApertura',
        'horaCierre',
        'fechaCierre',
        'montoCierre',
        'codLocalidad',
        'codUsuario'
    ];
    protected $guarded = [];
}
