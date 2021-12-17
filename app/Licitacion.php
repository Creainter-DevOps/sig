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

class Licitacion extends Model
{
  use Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.licitacion';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    public function rotulo() {
      return $this->rotulo;
    }
    public function oportunidad() {
      return Oportunidad::where('licitacion_id',$this->id)->where('tenant_id', Auth::user()->tenant_id)->first();
    }
    public function empresa() {
      return $this->belongsTo('App\Empresa', 'empresa_id')->first();
    }
    public function participacion() {
      return Helper::fecha($this->fecha_participacion_desde, true) . ' al ' . Helper::fecha($this->fecha_participacion_hasta, true);
    }
    public function propuesta() {
      return Helper::fecha($this->fecha_propuesta_desde, true) . ' al ' . Helper::fecha($this->fecha_propuesta_hasta, true);
    }
    public function adjuntos() {
      $datos = json_decode($this->datos);
      if(!empty($datos->listaDocumentos)) {
        return $datos->listaDocumentos;
      }
      return [];
    }
    public function cronograma() {
      $datos = json_decode($this->datos);
      if(!empty($datos->listaCronograma)) {
        return $datos->listaCronograma;
      }
      return [];
    }
    public function estado() {
      $oportunidad = $this->oportunidad();
      if(!empty($oportunidad)) {
        return $oportunidad->estado();
      }
      $ahora = time();
      $participacion_hasta = strtotime($this->fecha_participacion_hasta);

      if($ahora >= $participacion_hasta) {
          return [
            'timeout' => true,
            'status' => false,
            'class' => 'badge badge-light-danger',
            'message' => 'TIMEOUT3',
          ];
      } else {
          return [
            'timeout' => false,
            'status' => false,
            'class' => 'badge badge-light-warning',
            'message' => 'PARTICIPACIÓN',
          ];
      }
    }
}
