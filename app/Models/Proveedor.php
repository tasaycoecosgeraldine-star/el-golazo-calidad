<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'idPro';
    public $timestamps = false;
    protected $fillable = ['nomPro', 'telPro'];
    protected $guarded = [];
}

