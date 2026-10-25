<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    // use HasFactory;
    protected $table = 'registro';
    protected $primaryKey = 'codRegistro';
    public $timestamps = false;
    protected $fillable = [
        'fechRegistro',
        'horainicio',
        'horafinal',
        'duracion',
        'tarifa',
        'costoTarifa',
        'duracion',
        'estado',
        'comentario',
        'codUsuario',
        'codCliente',
        'codLocalidad',
    ];
    protected $guarded = [];
}
