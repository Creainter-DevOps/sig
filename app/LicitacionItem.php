<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Empresa;
use App\Oportunidad;
use App\Cotizacion;
use Auth;
use App\Casts\Json;

class LicitacionItem extends Model
{
  use Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.licitacion_item';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'licitacion_id','item','cantidad_solicitada','unidad_medida',
      'valor_referencial','cantidad_desierta','descripcion','resultado','empresa_id',
      'monto_adjudicado','cantidad_adjudicado',
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
    ];
    public function empresa() {
      return $this->belongsTo('App\Empresa', 'empresa_id')->first();
    }
}
