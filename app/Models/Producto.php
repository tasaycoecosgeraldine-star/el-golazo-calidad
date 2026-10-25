<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model

{
    protected $table = 'producto';
    protected $primaryKey = 'codProducto';
    public $timestamps = false;
    protected $fillable = [
        'nomProducto',
        'Precio',
        'imagen',
        'descripcion',
        'stock',
        'codCategoria'
    ];
    protected $guarded = [];
}

