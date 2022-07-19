<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Oportunidad;
use App\Helpers\Helper;
use Auth;


class CotizacionDetalle extends Model
{
  use Notifiable,HasApiTokens,HasRoles;
  
  protected $connection = 'interno';
  protected $table = 'osce.cotizacion_detalle';
  const UPDATED_AT = null;
  const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id','producto_id','cotizacion_id','cantidad','monto','eliminado','descripcion','orden'
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
    public function producto() {
      return $this->belongsTo('App\Producto', 'producto_id');
    }

    public function productor(){
      return $this->belongsTo('App\Producto', 'producto_id')->first();
    }
}
