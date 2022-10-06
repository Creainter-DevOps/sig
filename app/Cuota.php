<?php

namespace App;

use App\Persona;
use App\Actividad;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Facades\DB;

class Cuota extends Model
{
    protected $table = null;
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'dni' , 'nombres', 'area', 'apellidos', 'correo','area', 'celular','cliente_id','eliminado'
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

    public static function oportunidades() {
      return collect(DB::select("SELECT * FROM osce.fn_plan_cuota_oportunidad(:tenant, :user, :oi)", [
        'tenant' => Auth::user()->tenant_id,
        'user'   => Auth::user()->id,
        'oi'     => null,
      ]))->first();
    }
    public static function etiquetas() {
      return collect(DB::select("SELECT * FROM osce.fn_plan_cuota_etiqueta(:tenant, :user, null, null, null)", [
        'tenant' => Auth::user()->tenant_id,
        'user'   => Auth::user()->id,
      ]))->first();
    }
    public static function empresas() {
      return collect(DB::select("SELECT * FROM osce.fn_plan_cuota_empresa(:tenant, :user, :empresa)", [
        'tenant'  => Auth::user()->tenant_id,
        'user'    => Auth::user()->id,
        'empresa' => null,
      ]))->first();
    }
}
