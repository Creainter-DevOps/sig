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
        'name', 'email', 'password','buenapro_revision','bases_integradas','eliminado'
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
    public function aprobar() {
      DB::select('SELECT osce.fn_licitacion_accion_aprobar(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ')');
    }
    public function rechazar() {
      DB::select('SELECT osce.fn_licitacion_accion_rechazar(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ')');
    }
    public function etiquetas() {
      $rp = collect(DB::select('SELECT osce.fn_etiquetas_a_rotulo(L.etiquetas_id) ee
      FROM osce.licitacion L WHERE id = ' . $this->id))->first();
      return $rp->ee; 
    }
    public function similares() {
      return DB::select("
        SELECT *, array_to_string(B.licitaciones_id,',') ids
        FROM osce.fn_licitacion_similares(:tenant, :referencia) B
        LIMIT 20", ['tenant' => Auth::user()->tenant_id, 'referencia' => $this->id]);
    }
    public function oportunidad() {
      return $this->belongsTo('App\Oportunidad', 'id', 'licitacion_id')->first();
      $oportunidad = Oportunidad::where('licitacion_id',$this->id)
                     ->where('tenant_id', Auth::user()->tenant_id)->first();
      if(empty( $oportunidad )) {
        $data['tenant_id'] = Auth::user()->tenant_id;
        $data['aprobado_el'] = DB::raw('now');
        $data['aprobado_por'] = Auth::user()->id; 
        $data['licitacion_id'] = $this->id;
        $data['empresa_id'] = $this->empresa_id;
        $data['rotulo'] = $this->rotulo;    
        $oportunidad =  Oportunidad::create($data)->fresh();
      }
      return $oportunidad;
    }
    public function items() {
      return $this->hasMany('App\LicitacionItem','licitacion_id')
        ->orderBy('item', 'desc')->get();
    }
    public function ganadora($json = -1) {
      if($json === -1) {
        $rp = collect(DB::select("SELECT osce.licitacion_ganadores(" . Auth::user()->tenant_id . ", '" . $this->id . "'::int) dd"))->first();
        $json = $rp->dd;
      }
      $gds = json_decode($json, true);
        $gds = is_array($gds) ? $gds : [];
        $gds = array_map(function($n) {
          $n['empresa'] = trim($n['empresa']);
          if($n['empresa'] == 'Desierto') {
            return $n['empresa'];
          }
          if(empty($n['empresa'])) {
            return null;
          }
          if(!empty($n['tenant'])) {
            return '<b>' . $n['empresa'] . '</b> por ' . $n['monto'];
          }
          return $n['empresa'] . ' por ' . $n['monto'];
        }, $gds);
        $gds = array_filter($gds, function($n) {
           return $n !== null;
        });
        return !empty($gds) ? implode(' / ', $gds) : null;
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

    
   public  static function listado_nuevas() {
      /*$rp = DB::select("
            SELECT O.*
            FROM osce.oportunidad O
            left  JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
            WHERE O.archivado_el IS NULL AND O.rechazado_el IS NULL AND O.aprobado_el IS NULL
            ORDER BY L.fecha_participacion_hasta ASC 
            Limit 500
            ");*/
      $rp = DB::select("
            SELECT L.*,O.licitacion_id
            FROM osce.licitacion L
            LEFT JOIN osce.oportunidad O ON L.id = O.licitacion_id AND L.eliminado IS NULL
            WHERE L.buenapro_fecha IS NULL AND L.eliminado IS NULL AND O.licitacion_id IS NULL AND L.created_on >= NOW() - INTERVAL '30' DAY AND L.procedimiento_id IS NOT NULL AND L.fecha_participacion_hasta >= NOW()
            ORDER BY L.id DESC
            LIMIT 100");
      return static::hydrate($rp);
    }
    
   public  static function listado_por_aprobar() {
      $rp = DB::select("
            SELECT L.*, osce.fn_empresa_rotulo(". Auth::user()->tenant_id . ", coalesce(L.empresa_id,O.empresa_id )) empresa, O.licitacion_id
            FROM osce.licitacion L
            LEFT JOIN osce.oportunidad O ON L.id = O.licitacion_id AND L.eliminado IS NULL
            WHERE L.buenapro_fecha IS NULL AND L.eliminado IS NULL AND O.licitacion_id IS NULL AND L.created_on >= NOW() - INTERVAL '30' DAY AND L.procedimiento_id IS NOT NULL AND L.fecha_participacion_hasta >= NOW()
            ORDER BY L.id DESC
            LIMIT 15");
      return static::hydrate($rp);
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
    public static function search($query) {
      $query = strtolower($query);
      return static::leftJoin('osce.oportunidad', 'oportunidad.licitacion_id','licitacion.id')
        ->select('osce.licitacion.*')
        ->leftJoin('osce.empresa', 'empresa.id','licitacion.empresa_id')
        ->where(function($r) use($query) {
          $r->orWhereRaw("LOWER(licitacion.rotulo) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.descripcion) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.nomenclatura) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("licitacion.procedimiento_id::text LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("licitacion.expediente_id::text LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.descripcion) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(empresa.razon_social) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(oportunidad.rotulo) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(oportunidad.codigo) LIKE ? ", ["%{$query}%" ]);
      });
    }
}
