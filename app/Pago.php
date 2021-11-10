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

class Pago extends Model
{
  use Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.pago';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'proyecto_id','orden','nombre','monto','movimiento_id','descripcion','moneda_id',
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
    public function log($evento, $texto) {
      OportunidadLog::create([
        'oportunidad_id' => $this->id,
        'evento' => $evento,
        'texto'  => $texto,
      ]);
    }
    public function oportunidad() {
      return $this->belongsTo('App\Oportunidad', 'oportunidad_id')->first();
    }
}
