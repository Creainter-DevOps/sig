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

class Oportunidad extends Model
{
  use Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.oportunidad';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'licitacion_id','tenant_id','aprobado_por','aprobado_el','rechazado_por','rechazado_el','motivo','monto_base','duracion_dias','instalacion_dias','garantia_dias','estado','fecha_participacion','fecha_propuesta',
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
      'aprobado_el' => 'datetime',
      'rechazado_el' => 'datetime',
    ];
    public function log($evento, $texto) {
      OportunidadLog::create([
        'oportunidad_id' => $this->id,
        'evento' => $evento,
        'texto'  => $texto,
      ]);
    }
    public function licitacion() {
      return $this->belongsTo('App\Licitacion', 'licitacion_id')->first();
    }
    public function rotulo() {
        $rp = $this->licitacion()->descripcion;
      return substr($rp, 0, 100);
    }
    public function participacion() {
      return Helper::fecha($this->fecha_participacion_desde, true) . ' al ' . Helper::fecha($this->fecha_participacion_hasta, true);
    }
    public function propuesta() {
      return Helper::fecha($this->fecha_propuesta_desde, true) . ' al ' . Helper::fecha($this->fecha_propuesta_hasta, true);
    }
    public function adjuntos() {
      $datos = json_decode($this->licitacion()->datos);
      if(!empty($datos->listaDocumentos)) {
        return $datos->listaDocumentos;
      }
      return [];
    }
    public function cronograma() {
      $datos = json_decode($this->licitacion()->datos);
      if(!empty($datos->listaCronograma)) {
        return $datos->listaCronograma;
      }
      return [];
    }
    public function empresas() {
      $rp = DB::select("
        SELECT E.razon_social, E.ruc, E.descripcion, E.id e_empresa_id, C.*, C.id c_candidato_id
        FROM osce.empresa E
        LEFT JOIN osce.candidato C ON C.oportunidad_id = " . $this->id . " AND C.empresa_id = E.id
        WHERE E.tenant_id = " . $this->tenant_id . "
        ORDER BY E.razon_social ASC
        LIMIT 10");
      return array_map(function($n) {
        return new Empresa((array) $n);
      }, $rp);
    }
    static function listado_nuevas() {
      $rp = DB::select("
SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
WHERE O.archivado_el IS NULL AND O.rechazado_el IS NULL AND O.aprobado_el IS NULL
ORDER BY L.fecha_participacion_hasta ASC");
      return static::hydrate($rp);
    }
    static function listado_archivadas() {
      $rp = DB::select("
SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
WHERE O.archivado_el IS NOT NULL AND O.aprobado_el IS NOT NULL
ORDER BY O.archivado_el DESC
LIMIT 50");
      return static::hydrate($rp);
    }
    static function listado_eliminados() {
      $rp = DB::select("
SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
WHERE O.rechazado_el IS NOT NULL
ORDER BY O.rechazado_el DESC
LIMIT 50");
      return static::hydrate($rp);
    }
   static function listado_participanes_por_vencer() {
      $rp = DB::select("
    SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
WHERE O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
AND ((L.fecha_participacion_desde >= NOW() AND L.fecha_participacion_hasta <= NOW()) OR (L.fecha_participacion_hasta >= NOW() - INTERVAL '1' DAY AND L.fecha_participacion_hasta <= NOW() + INTERVAL '1' DAY))
AND O.fecha_participacion IS NULL
ORDER BY L.fecha_participacion_hasta ASC, O.id ASC");
      return static::hydrate($rp);
   }
    static function listado_propuestas_por_vencer() {
      $rp = DB::select("
    SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
WHERE O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
AND ((L.fecha_propuesta_desde >= NOW() AND L.fecha_propuesta_hasta <= NOW()) OR (L.fecha_propuesta_hasta >= NOW() - INTERVAL '1' DAY AND L.fecha_propuesta_hasta <= NOW() + INTERVAL '1' DAY))
AND O.fecha_participacion IS NOT NULL AND O.fecha_propuesta IS NULL
ORDER BY L.fecha_propuesta_hasta ASC, O.id ASC");
      return static::hydrate($rp);
    }
    static function listado_propuestas_buenas_pro() {
      $rp = DB::select("
    SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
WHERE O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
AND ((L.fecha_buena_desde >= NOW() AND L.fecha_buena_hasta <= NOW()) OR (L.fecha_buena_hasta >= NOW() - INTERVAL '12' DAY AND L.fecha_buena_hasta <= NOW() + INTERVAL '12' DAY))
AND O.fecha_participacion IS NOT NULL AND O.fecha_propuesta IS NOT NULL
ORDER BY L.fecha_buena_hasta ASC, O.id ASC");
      return static::hydrate($rp);
    }
   static function listado_aprobadas() {
      $rp = DB::select("
    SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
WHERE O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
ORDER BY O.aprobado_el DESC, O.id ASC");
      return static::hydrate($rp);
    }
    public function aprobar() {
      DB::select('UPDATE osce.oportunidad SET aprobado_el = NOW(), archivado_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->log('aprobar', null);
    }
    public function revisar() {
      DB::select('UPDATE osce.oportunidad SET revisado_el = NOW(), archivado_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->log('revisar', null);
    }
    public function rechazar() {
      DB::select('UPDATE osce.oportunidad SET rechazado_el = NOW(), archivado_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->log('rechazar', null);
    }
    public function archivar() {
      DB::select('UPDATE osce.oportunidad SET archivado_el = NOW(), archivado_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->log('archivar', null);
    }
    public function registrar_interes(Empresa $empresa) {
      CandidatoOportunidad::create([
        'oportunidad_id' => $this->id,
        'empresa_id'     => $empresa->id,
        'interes_el'     => 'NOW()',
        'interes_por'    => Auth::user()->id,
      ]);
      $this->log('accion', 'Ha mostrado interés con la empresa ' . $empresa->razon_social);
    }
    public function timeline() {
      return $this->hasMany('App\OportunidadLog','oportunidad_id')->orderBy('id', 'desc')->get();
    }
    public function margen() {
      return Helper::money(!empty($this->monto_base) ? ($this->monto_propuesto - $this->monto_base) * 100 / $this->monto_propuesto : 0) . '%';
    }
    public function mensualidad() {
      if(!empty($this->duracion_dias)) {
        return Helper::money($this->monto_propuesto * $this->duracion_dias / $this->duracion_dias);
      }
      return 'No existe duración';
    }
    public function estado() {
//      dd($this->licitacion());
      $ahora = time();
      $participacion_desde = strtotime($this->licitacion()->fecha_participacion_desde);
      $participacion_hasta = strtotime($this->licitacion()->fecha_participacion_hasta);
      $propuesta_desde = strtotime($this->licitacion()->fecha_propuesta_desde);
      $propuesta_hasta = strtotime($this->licitacion()->fecha_propuesta_hasta);

      if($ahora >= $propuesta_hasta) {
        if(!empty($this->fecha_propuesta)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'ENVIADO',
          ];
        } else {
          return [
            'timeout' => true,
            'status' => false,
            'class' => 'badge badge-light-danger',
            'message' => 'TIMEOUT1',
          ];
        }
      } elseif($ahora >= $propuesta_desde) {
        if(!empty($this->fecha_propuesta)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'ENVIADO',
          ];
        } if(!empty($this->fecha_participacion)) {
          return [
            'timeout' => false,
            'status' => false,
            'class' => 'badge badge-light-warning',
            'message' => 'PROPUESTA',
          ];
        } else {
          return [
            'timeout' => true,
            'status' => false,
            'class' => 'badge badge-light-danger',
            'message' => 'TIMEOUT2',
          ];
        }

      } elseif($ahora >= $participacion_hasta) {
        if(!empty($this->fecha_participacion)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'REGISTRADO',
          ];
        } else {
          return [
            'timeout' => true,
            'status' => false,
            'class' => 'badge badge-light-danger',
            'message' => 'TIMEOUT3',
          ];
        }
      } elseif($ahora >= $participacion_desde) {
        if(!empty($this->fecha_participacion)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'REGISTRADO',
          ];
        } else {
          return [
            'timeout' => false,
            'status' => false,
            'class' => 'badge badge-light-warning',
            'message' => 'PARTICIPACIÓN',
          ];
        }
      } else {
        return [
          'timeout' => false,
          'status' => true,
          'class' => 'badge badge-light-secondary',
          'message' => 'ESPERANDO',
        ];
      }
    }
}
