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
use App\Cotizacion;
use App\Actividad;
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
      'codigo','licitacion_id','tenant_id','aprobado_por','aprobado_el','rechazado_por','rechazado_el','motivo','monto_base','duracion_dias','instalacion_dias','garantia_dias','estado','fecha_participacion','fecha_propuesta','empresa_id','cliente_id','contacto_id','rotulo', 'revisado_el','revisado_por'
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
    public function log($evento, $texto = null , $tipo = 'log' ) {
      Actividad::create([
        'oportunidad_id' => $this->id,
        'evento' => $evento,
        'texto'  => $texto,
        'tipo' => $tipo
      ]);
    }
    public function folder() {
      return '\\OPORTUNIDADES\\' . $this->codigo . '\\';
    }
    public function licitacion() {
      return $this->belongsTo('App\Licitacion', 'licitacion_id')->first();
    }
    public function cotizaciones() {
      return $this->hasMany('App\Cotizacion','oportunidad_id','id')->orderBy('numero','ASC')->get();
    }
    public function proyecto() {
      return $this->belongsTo('App\Proyecto', 'id','oportunidad_id')->first();
    }
    public function cliente() {
      return $this->belongsTo('App\Cliente', 'cliente_id')->first();
    }
    public function empresa() {
      return $this->belongsTo('App\Empresa', 'empresa_id')->first();
    }
    public function contacto() {
      return $this->belongsTo('App\Contacto', 'contacto_id')->first();
    }
    public function comentarios() {
      return 0;
    }
    public static function list() {
      return Oportunidad::whereRaw('oportunidad.codigo IS NOT NULL')->orderBy('created_on', 'desc');
    }
    public static function search($query) {
      $query = strtolower($query);
      return Oportunidad::leftJoin('osce.licitacion', 'oportunidad.licitacion_id','licitacion.id')
        ->leftJoin('osce.empresa', 'empresa.id','licitacion.empresa_id')
        ->where(function($r) use($query) {
          $r->WhereRaw("LOWER(licitacion.rotulo) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(empresa.razon_social) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.descripcion) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(oportunidad.rotulo) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.nomenclatura) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(oportunidad.codigo) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("licitacion.procedimiento_id::text LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.descripcion) LIKE ? ", ["%{$query}%" ]);
      });
    }
    public function rotulo() {
      if(empty($this->rotulo)) {
        if(!empty($this->licitacion_id)) {
          $rp = strtoupper($this->licitacion()->rotulo . ' ' . $this->licitacion()->descripcion);
        } else {
          $rp = strtoupper($this->descripcion);
        }
      } else {
        $rp = '-- ' . strtoupper($this->rotulo) . ' --';
      }
      $rp = substr($this->codigo, 7) . ': ' . $rp;
      return (!empty($this->importancia) ? '<span class="favorite warning"><i class="bx bxs-star"></i></span>' : '') . substr($rp, 0, 100) . (!empty($this->revisado_el) ? '<b>[R]</b>' : '');
    }
    public function participacion() {
      return Helper::fecha($this->fecha_participacion_desde, true) . ' al ' . Helper::fecha($this->fecha_participacion_hasta, true);
    }
    public function propuesta() {
      return Helper::fecha($this->fecha_propuesta_desde, true) . ' al ' . Helper::fecha($this->fecha_propuesta_hasta, true);
    }
    public function adjuntos() {
      return $this->licitacion->adjuntos();
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
        SELECT E.razon_social, E.ruc, E.descripcion, E.id e_empresa_id, C.*, C.id c_cotizacion_id
        FROM osce.empresa E
        LEFT JOIN osce.cotizacion C ON C.oportunidad_id = " . $this->id . " AND C.empresa_id = E.id
        WHERE E.tenant_id = " . $this->tenant_id . "
        ORDER BY E.id ASC
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
/*      $rp = DB::select("
SELECT x.*
FROM(
SELECT O.*, L.fecha_participacion_hasta,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND interes_el IS NOT NULL) cantidad_interes,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND participacion_el IS NOT NULL) cantidad_participadas
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL AND L.fecha_participacion_desde - INTERVAL '1' DAY <= NOW() AND L.fecha_participacion_hasta + INTERVAL '1' DAY >= NOW()
WHERE O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL) x
WHERE x.cantidad_interes = 0 OR x.cantidad_interes <> x.cantidad_participadas
ORDER BY x.fecha_participacion_hasta ASC, x.id ASC"); */
     $rp = DB::select("
SELECT x.*
FROM (
SELECT O.*,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND interes_el IS NOT NULL) cantidad_interes,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND participacion_el IS NOT NULL) cantidad_participadas
FROM osce.oportunidad O
WHERE O.aprobado_el >= NOW() - INTERVAL '80' DAY AND O.rechazado_el IS NULL AND O.archivado_el IS NULL)x
JOIN osce.licitacion L ON L.id = x.licitacion_id AND L.eliminado IS NULL 
AND 
  ((L.fecha_participacion_desde - INTERVAL '1' DAY <= NOW() AND L.fecha_participacion_hasta + INTERVAL '1' DAY >= NOW())
  OR (L.fecha_participacion_hasta - INTERVAL '4' DAY <= NOW() AND L.fecha_participacion_hasta + INTERVAL '2' DAY >= NOW()))
-- WHERE x.cantidad_interes = 0 OR x.cantidad_interes <> x.cantidad_participadas
ORDER BY L.fecha_participacion_hasta ASC, id DESC");
      return static::hydrate($rp);
   }
    static function listado_propuestas_por_vencer() {
/*      $rp = DB::select("
    SELECT O.*,
    (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND participacion_el IS NOT NULL) cantidad_participadas,
    (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND propuesta_el IS NOT NULL) cantidad_propuestas
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
WHERE O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
AND ((L.fecha_propuesta_desde >= NOW() AND L.fecha_propuesta_hasta <= NOW()) OR (L.fecha_propuesta_hasta >= NOW() - INTERVAL '1' DAY AND L.fecha_propuesta_hasta <= NOW() + INTERVAL '1' DAY))
AND O.fecha_participacion IS NOT NULL
AND ((SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND participacion_el IS NOT NULL) <> (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND propuesta_el IS NOT NULL))
ORDER BY L.fecha_propuesta_hasta ASC, O.id ASC");*/
      $rp = DB::select("
SELECT x.*
FROM (
SELECT O.*,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND participacion_el IS NOT NULL) cantidad_participadas,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND propuesta_el IS NOT NULL) cantidad_propuestas
FROM osce.oportunidad O
WHERE O.aprobado_el >= NOW() - INTERVAL '80' DAY AND O.rechazado_el IS NULL AND O.archivado_el IS NULL AND O.fecha_participacion IS NOT NULL)x
JOIN osce.licitacion L ON L.id = x.licitacion_id AND L.eliminado IS NULL
AND
  ((L.fecha_propuesta_desde - INTERVAL '2' DAY <= NOW() AND L.fecha_propuesta_hasta + INTERVAL '2' DAY >= NOW())
  OR (L.fecha_propuesta_hasta - INTERVAL '25' DAY <= NOW() AND L.fecha_propuesta_hasta + INTERVAL '10' DAY >= NOW()))
-- WHERE x.cantidad_propuestas = 0 OR x.cantidad_propuestas <> x.cantidad_participadas
ORDER BY L.fecha_propuesta_hasta ASC, id DESC");
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
      $this->update([
        'aprobado_el'  => DB::raw('now'),
        'aprobado_por' => Auth::user()->id,
      ]);
      $this->log('aprobar', null);
    }
    public function revisar() {
      DB::select('UPDATE osce.oportunidad SET revisado_el = NOW(), revisado_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->log('revisar', null);
    }
    public function rechazar() {
      DB::select('UPDATE osce.oportunidad SET rechazado_el = NOW(), rechazado_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->log('rechazar', null);
    }
    public function archivar() {
      DB::select('UPDATE osce.oportunidad SET archivado_el = NOW(), archivado_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->log('archivar', null);
    }
    public function registrar_interes(Empresa $empresa) {
      Cotizacion::create([
        'oportunidad_id' => $this->id,
        'empresa_id'     => $empresa->id,
        'interes_el'     => 'NOW()',
        'interes_por'    => Auth::user()->id,
      ]);
      $this->log('accion', 'Ha mostrado interés con la empresa ' . $empresa->razon_social);
    }
    public function timeline() {
      return $this->hasMany('App\Actividad','oportunidad_id')->orderBy('id', 'desc')->get();
    }
    public function similares() {
      if(empty($this->rotulo)) {
        $lista = strtoupper($this->licitacion()->rotulo);
//        $lista = explode(' ', $lista);
//        $lista = array_filter($lista, function($t) { $t = trim($t); return strlen($t) > 7 && preg_match("/^\w+$/", $t); });
      } else {
        $lista = $this->rotulo;#explode(',', $this->rotulo);
      }
      return static::busqueda_de_similares($lista, $this->licitacion_id);
    }
    public function margen() {
      return '';#Helper::money(!empty($this->monto_base) ? ($this->monto_propuesto - $this->monto_base) * 100 / $this->monto_propuesto : 0) . '%';
    }
    public function mensualidad() {
      if(!empty($this->duracion_dias)) {
        return Helper::money($this->monto_propuesto * $this->duracion_dias / $this->duracion_dias);
      }
      return 'No existe duración';
    }
    public function estado_participacion() {
      $ahora = time();
      $participacion_desde = strtotime($this->licitacion()->fecha_participacion_desde);
      $participacion_hasta = strtotime($this->licitacion()->fecha_participacion_hasta);
      $propuesta_desde = strtotime($this->licitacion()->fecha_propuesta_desde);
      $propuesta_hasta = strtotime($this->licitacion()->fecha_propuesta_hasta);

      if($ahora >= $participacion_hasta) {
        if(!empty($this->fecha_participacion)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'PARTICIPANDO',
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
            'message' => 'PARTICIPANDO',
          ];
        } else {
          return [
            'timeout' => false,
            'status' => false,
            'class' => 'badge badge-light-warning',
            'message' => 'REQUIERE',
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
    public function estado_propuesta() {
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
            'message' => 'REQUIERE',
          ];
        } else {
          return [
            'timeout' => true,
            'status' => false,
            'class' => 'badge badge-light-danger',
            'message' => 'TIMEOUT2',
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
    public function estado_pro() {
      $ahora = time();
      $pro_desde = strtotime($this->licitacion()->fecha_buena_desde);
      $pro_hasta = strtotime($this->licitacion()->fecha_buena_hasta);

      if($ahora >= $pro_desde) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'PUBLICADO',
          ];
      } else {
        return [
          'timeout' => false,
          'status' => true,
          'class' => 'badge badge-light-secondary',
          'message' => 'ESPERANDO',
        ];
      }
    }
    public function estado() {
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
            'message' => 'REQUIERE',
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
            'message' => 'PARTICIPANDO',
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
            'message' => 'PARTICIPANDO',
          ];
        } else {
          return [
            'timeout' => false,
            'status' => false,
            'class' => 'badge badge-light-warning',
            'message' => 'REQUIERE',
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
    /*public function licitacion(){
       return $this->belongsTo('App\Cotizacion', 'licitacion_id','id')->first(); 
    }*/
    public static function busqueda_de_similares($q, $referencia_id) {
      if(is_array($q)) {
        $q = implode('%', $q);
      }
      $q = '%' . $q . '%';
      return DB::select("
        SELECT *, array_to_string(B.licitaciones_id,',') ids
        FROM osce.busqueda_licitaciones_similares(:q, :referencia) B
        LIMIT 20", ['q' => $q, 'referencia' => $referencia_id]);
    }
    static function estadistica_barra_cantidades() {
      return DB::select("SELECT fecha eje_x, cantidad eje_y, tipo collection FROM osce.estadistica_rapida_oportunidades(7, 1)");
    }
}
