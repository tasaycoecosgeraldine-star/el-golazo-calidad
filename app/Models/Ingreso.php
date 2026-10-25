<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    // use HasFactory;
    protected $table = 'ingreso';
    protected $primaryKey = 'codIngreso';
    public $timestamps = false;
    protected $fillable = [
        'horaIngreso',
        'fechaIngreso',
        'recibidoDe',
        'motivo',
        'importe',
        'estado',
        'codCaja'
    ];
    protected $guarded = [];

}
