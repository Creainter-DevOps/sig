<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use App\Facades\DB;
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
        'name', 'email', 'password','buenapro_revision','bases_integradas','eliminado','monto','tipo_objeto','estado'
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
        'estado' => 'boolean',
      ];

    public static function paginationTotal() {
      return DB::PaginationQuery("
        SELECT
          L.*,
          L.created_on::date fecha,
          osce.empresa_rotulo(:tenant, L.empresa_id) cliente,
          (SELECT COUNT(*) FROM osce.licitacion_item I WHERE I.licitacion_id = L.id) items
          FROM (
            SELECT 
              L.*
            FROM osce.licitacion L
            --search WHERE (UPPER(L.rotulo) LIKE CONCAT('%', (:q)::text, '%') OR L.nomenclatura LIKE CONCAT('%', (:q)::text, '%'))
            ORDER BY L.id DESC
            --pagination
          ) L
      ", [
        'tenant' => Auth::user()->tenant_id,
//        'user'   => Auth::user()->id,
      ])->countEstimate();
    }
    public static function paginationPropias() {
      return DB::PaginationQuery("
        SELECT
          L1.*,
          osce.empresa_rotulo(:tenant, L1.empresa_id) cliente,
          osce.oportunidad_variacion_montos(L1.id) monto_propio,
          osce.fn_oportunidad_fecha_estado_propuesta(1, L1.id) inx_estado_participacion,
          osce.fn_oportunidad_fecha_estado_propuesta(1, L1.id) inx_estado_propuesta,
          osce.licitacion_ganadores(:tenant, L1.licitacion_id::int) ganadores
        FROM (
          --started
          SELECT 
            O.id,
            O.created_on fecha,
            L.empresa_id,
            O.licitacion_id,
            L.rotulo,
            L.tipo_objeto,
            L.nomenclatura,
            L.monto
          FROM osce.oportunidad O
          JOIN osce.licitacion L ON L.id = O.licitacion_id
          LEFT JOIN osce.actividad_tipo TT ON TT.id = O.estado
          WHERE O.tenant_id = :tenant AND O.eliminado IS NULL
            --search AND (UPPER(O.rotulo) LIKE CONCAT('%', (:q)::text, '%') OR L.nomenclatura LIKE CONCAT('%', (:q)::text, '%'))
          ORDER BY O.id DESC
          --pagination
        ) L1
      ", [
        'tenant' => Auth::user()->tenant_id,
//        'user'   => Auth::user()->id,
      ]);#->countEstimate();
    }
    public static function paginationBuenaPro() {
      return DB::PaginationQuery("
        SELECT
          L1.*,
          osce.empresa_rotulo(:tenant, L1.empresa_id) cliente,
          osce.oportunidad_variacion_montos(L1.id) monto_propio,
          osce.fn_oportunidad_fecha_estado_propuesta(1, L1.id) inx_estado_participacion,
          osce.fn_oportunidad_fecha_estado_propuesta(1, L1.id) inx_estado_propuesta,
          osce.licitacion_ganadores(:tenant, L1.licitacion_id::int) ganadores
        FROM (
          --started
          SELECT
            O.id,
            O.created_on fecha,
            L.empresa_id,
            O.licitacion_id,
            L.rotulo,
            L.tipo_objeto,
            L.nomenclatura,
            L.monto
          FROM osce.oportunidad O
          JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.buenapro_fecha IS NOT NULL
          LEFT JOIN osce.actividad_tipo TT ON TT.id = O.estado
          WHERE O.tenant_id = :tenant AND O.eliminado IS NULL
            --search AND (UPPER(O.rotulo) LIKE CONCAT('%', (:q)::text, '%') OR L.nomenclatura LIKE CONCAT('%', (:q)::text, '%'))
          ORDER BY O.id DESC
          --pagination
        ) L1
      ", [
        'tenant' => Auth::user()->tenant_id,
//        'user'   => Auth::user()->id,
      ]);#->countEstimate();
    }
    public function rotulo() {
      return $this->rotulo;
    }
    public function rango_precios() {
      $rp = new \stdClass;
      $rp->min = 0;
      $rp->max = 0;

      $prefijo = strtoupper(explode('-', $this->nomenclatura)[0]);

      if($prefijo == 'LP') {
        if($this->tipo_objeto == 'Bien') {
          $rp->min = 400000;
        } else if($this->tipo_objeto == 'Obra') {
          $rp->min = 2800000;
        }
      } elseif($prefijo == 'CP') {
        if($this->tipo_objeto == 'Consultoría de Obra') {
          $rp->min = 400000;
        }
      } elseif($prefijo == 'AS') {
        if($this->tipo_objeto == 'Bien' || $this->tipo_objeto == 'Servicio') {
          $rp->min = 36800;
          $rp->max = 400000;
        } else if($this->tipo_objeto == 'Obra') {
          $rp->min = 36800;
          $rp->max = 2800000;
        } elseif($this->tipo_objeto == 'Consultoría de Obra') {
          $rp->min = 36800;
          $rp->max = 400000;
        }
      } elseif($prefijo == 'DIRECTA') {
        $rp->min = 36800;
      }
      return $rp;
    }
    public function aprobar() {
      return collect(DB::select('SELECT * FROM osce.fn_licitacion_accion_aprobar(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ')'))->first();
    }

    public function rechazar($texto) {
      return collect(DB::select('SELECT osce.fn_licitacion_accion_rechazar(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ',:motivo)', [
        'motivo' => $texto,
      ]))->first();
    }

    public function etiquetas() {
      $rp = collect(DB::select('SELECT osce.fn_etiquetas_a_rotulo(L.etiquetas_id) ee
      FROM osce.licitacion L WHERE id = ' . $this->id))->first();
      return $rp->ee; 
    }
    public function relacionadas() {
      $rp = DB::select("
        SELECT
          L.*, L.fecha_participacion_desde::date fecha,
          (SELECT COUNT(O.id) FROM osce.oportunidad O WHERE O.licitacion_id = L.id AND O.tenant_id = :tenant AND O.fecha_propuesta IS NOT NULL) con_oportunidad,
        (SELECT SUM(D.valor_referencial) FROM osce.licitacion_item D WHERE D.licitacion_id = L.id AND D.valor_referencial IS NOT NULL) valor_referencial,
        (SELECT SUM(D.monto_adjudicado) FROM osce.licitacion_item D WHERE D.licitacion_id = L.id AND D.monto_adjudicado IS NOT NULL) valor_adjudicado
        FROM (SELECT UNNEST(osce.fn_licitacion_similares_v2(:tenant, :referencia)) codigo) C
        JOIN osce.licitacion L ON L.id = C.codigo
        ORDER BY L.fecha_participacion_desde DESC
        LIMIT 10", ['tenant' => Auth::user()->tenant_id, 'referencia' => $this->id]);
      return static::hydrate($rp);
    }
    public function similares() {
      return DB::select("
        SELECT *, array_to_string(B.licitaciones_id,',') ids
        FROM osce.fn_licitacion_similares(:tenant, :referencia) B
        LIMIT 20", ['tenant' => Auth::user()->tenant_id, 'referencia' => $this->id]);
    }
    public function oportunidad() {
      //return $this->belongsTo('App\Oportunidad', 'id', 'licitacion_id')->first();
      return Oportunidad::where('licitacion_id', $this->id)
                     ->where('tenant_id', Auth::user()->tenant_id)->first();
    }
    public function empresasMenu() {
      $rp = DB::select("
        SELECT E.id, E.razon_social
        FROM osce.empresa E
        WHERE E.tenant_id = :tenant AND :tipo = ANY(E.licitacion_tipo)
        ORDER BY E.razon_social ASC
        LIMIT 10", [
          'tenant' => Auth::user()->tenant_id,
          'tipo'   => $this->tipo_objeto
        ]);
        return Empresa::hydrate($rp);
    }
    public static function list() {
      $rp = DB::select("
        SELECT L.*
        FROM osce.oportunidad O
          JOIN osce.licitacion L ON L.id = O.licitacion_id
        WHERE O.tenant_id = :tenant AND O.licitacion_id IS NOT NULL AND O.eliminado IS NULL
          AND O.estado IN (0,1,2)
          AND O.rechazado_el IS NULL
          AND O.aprobado_el IS NOT NULL
        ORDER BY O.aprobado_el DESC
      ", [
        'tenant' => Auth::user()->tenant_id,
      ]);
      return static::hydrate($rp);
    }
    public function items() {
      return $this->hasMany('App\LicitacionItem','licitacion_id')
        ->orderBy('item', 'asc')->get();
    }
    public function hay_ganadora($json = -1) {
      if($json === -1) {
        $rp = collect(DB::select("SELECT COUNT(x) cantidad, SUM((CASE WHEN x->>'empresa' = 'Desierto' THEN 1 ELSE 0 END)) desiertos
          FROM jsonb_array_elements(osce.licitacion_ganadores(" . Auth::user()->tenant_id . ", '" . $this->id . "'::int)) x"))->first();
        if($rp->cantidad == 0) {
          return '';
        } elseif($rp->cantidad = $rp->desiertos) {
          return 'Desierto';
        } elseif($rp->desiertos == 0) {
          return 'Otorgado';
        } else {
          return 'Parcial ' . ($rp->cantidad - $rp->desiertos) . '/' . $rp->cantidad;
        }
      }
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

   public static function borrar_tentativas($min, $max) {
     return DB::select("SELECT osce.fn_tentativa_borrar_limites(:tenant, :min, :max) estado;", [
      'tenant' => Auth::user()->tenant_id,
      'min'    => $min,
      'max'    => $max,
     ]);
   }
   public static function listado_nuevas(&$parametros = null) {
     $total = collect(DB::select("
     SELECT COUNT(T.licitacion_id) cantidad
     FROM osce.tentativa T
     WHERE T.tenant_id = :tenant", ['tenant' => Auth::user()->tenant_id]))->first();
      $rp = DB::select("
        SELECT L.*, O.licitacion_id, osce.fn_etiquetas_a_rotulo(L.etiquetas_id) etiquetas
FROM (
	SELECT T.anho, T.licitacion_id
	FROM osce.tentativa T
	WHERE T.tenant_id = :tenant
	ORDER BY T.licitacion_id DESC
	LIMIT 20
) T
JOIN osce.licitacion L ON L.anho = T.anho AND L.id = T.licitacion_id
LEFT JOIN osce.oportunidad O ON L.id = O.licitacion_id
ORDER BY L.id DESC", ['tenant' => Auth::user()->tenant_id]);
      $parametros = [];
      if(!empty($rp)) {
        $parametros['total'] = $total->cantidad;
        $parametros['max']   = ($rp[0])->id;
        $parametros['min']   = (end($rp))->id;
      }
      return static::hydrate($rp);
    }
    
   public  static function listado_por_aprobar($ids = "0" ) {
      $rp = DB::select("
            SELECT L.*, osce.fn_empresa_rotulo(". Auth::user()->tenant_id . ", coalesce(L.empresa_id,O.empresa_id )) empresa, coalesce(L.monto,O.monto_base ) monto, O.licitacion_id
            FROM osce.licitacion L
            LEFT JOIN osce.oportunidad O ON L.id = O.licitacion_id
            WHERE L.buenapro_fecha IS NULL AND O.licitacion_id IS NULL AND L.created_on >= NOW() - INTERVAL '30' DAY AND L.procedimiento_id IS NOT NULL AND L.fecha_participacion_hasta >= NOW()
            and L.id not in (" .$ids. ")
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
            'message' => 'VENCIDO',
          ];
      } else {
          return [
            'timeout' => false,
            'status' => false,
            'class' => 'badge badge-light-warning',
            'message' => 'DISPONIBLE',
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
//          ->orWhereRaw("LOWER(licitacion.descripcion) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.nomenclatura) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("licitacion.procedimiento_id::text LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("licitacion.expediente_id::text LIKE ? ", ["%{$query}%" ])
//          ->orWhereRaw("LOWER(licitacion.descripcion) LIKE ? ", ["%{$query}%" ])
//          ->orWhereRaw("LOWER(empresa.razon_social) LIKE ? ", ["%{$query}%" ])
//          ->orWhereRaw("LOWER(oportunidad.rotulo) LIKE ? ", ["%{$query}%" ])
//          ->orWhereRaw("LOWER(oportunidad.codigo) LIKE ? ", ["%{$query}%" ]);
;
      });
    }
}
