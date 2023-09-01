<?php

namespace App;

use App\Persona;
use App\Actividad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


use Auth;
class Credencial extends Model
{
    protected $table = 'osce.credencial';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'asunto','credencial_hasta','credencial_copia','asunto','texto','contacto_id','ex_user_id','ex_access_token','usuario',
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


  public static function propias() {
    return static::where('tenant_id', Auth::user()->tenant_id)->get();
  }

}
