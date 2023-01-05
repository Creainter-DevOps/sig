<?php

namespace App;

use App\Persona;
use App\Actividad;
use Illuminate\Database\Eloquent\Model;

class Subsanacion extends Model
{
    protected $table = 'osce.subsanacion';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'fecha' ,'dias_habiles','respondido_el','respondido_por','documento_id'
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
     public function folder($unix = false) {
      if($unix) {
        return 'OPORTUNIDADES/' . $this->oportunidad()->codigo . '/COTIZACION-' . str_pad($this->numero, 2, '0', STR_PAD_LEFT) . '/';
      }
      return '\\OPORTUNIDADES\\' . $this->oportunidad()->codigo . '\\COTIZACION-' . str_pad($this->numero, 2, '0', STR_PAD_LEFT) . '\\';
    }
    public function cotizacion() {
      return $this->belongsTo('App\Cotizacion', 'cotizacion_id')->first();
    }
    public function oportunidad() {
    return $this->belongsTo('App\Oportunidad', 'oportunidad_id')->first();
  }
  public function licitacion() {
    return $this->oportunidad()->belongsTo('App\Licitacion', 'licitacion_id')->first();
  }
}
