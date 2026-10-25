<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

class Cliente extends Authenticatable
{
    protected $table = 'cliente';
    protected $primaryKey = 'codCliente';
    public $timestamps = false;
    use Notifiable;
    protected $fillable = [
        'nombres',
        'numDocumento',
        'creacion',
        'direccion',
        'email',
        'password',
        'telefono',
        'foto',
        'estado',
        'tipo'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // protected $guarded = [];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
