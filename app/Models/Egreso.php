<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    // use HasFactory;
    protected $table = 'egreso';
    protected $primaryKey = 'codEgreso';
    public $timestamps = false;
    protected $fillable = [
        'horaEgreso',
        'fechaEgreso',
        'tipo',
        'entregadoA',
        'motivo',
        'importe',
        'estado',
        'codCaja'
    ];
    protected $guarded = [];
}
