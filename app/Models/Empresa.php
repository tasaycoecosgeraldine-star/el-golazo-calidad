<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table='empresa';
    protected $primaryKey="idEmpresa";

    public $timestamps=false;

    protected $fillable=[
        'nombre','direccion', 'telefono', 'simboloMoneda', 'logo', 'ruc'
    ];
    protected $guarded =[

    ];
}
