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
use App\CandidatoOportunidad;
use App\OportunidadLog;
use Auth;

class Proyecto extends Model
{
  use Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.proyecto';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'tenant_id','cliente_id','contacto_id','oportunidad_id','candidato_id','cotizacion_id','nombre','nomenclatura',
      'dias_servicio','dias_garantia','dias_instalacion','fecha_desde','fecha_hasta',
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

    public function oportunidad() {
      return $this->belongsTo('App\Oportunidad', 'oportunidad_id')->first();
    }
    public function cliente() {
      return $this->belongsTo('App\Cliente', 'cliente_id')->first();
    }
    public function contacto() {
      return $this->belongsTo('App\Contacto', 'contacto_id')->first();
    }
    public function candidato() {
      return $this->belongsTo('App\Candidato', 'candidato_id')->first();
    }
    public function empresa() {
      return $this->belongsTo('App\Empresa', 'empresa_id')->first();
    }
}
