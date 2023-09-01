<?php

namespace App;

use App\Persona;
use App\Actividad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CorreoHilo extends Model
{
    protected $table = 'osce.correo_hilo';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'token','correo_id',
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

    
}
