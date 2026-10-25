<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model

{
    protected $table = 'localidad';
    protected $primaryKey = 'codLocalidad';
    public $timestamps = false;
    protected $fillable = [
        'nomLocalidad',
        'precioDia',
        'precioNoche',
        'direccion',
        'telefono',
        'logo'
    ];
    protected $guarded = [];
}

