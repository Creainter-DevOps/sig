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
use App\Cotizacion;
use App\Actividad;
use App\Correo;
use Auth;
use App\Scopes\MultiTenant;

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
      'codigo','licitacion_id','tenant_id','aprobado_por','aprobado_el','rechazado_por','rechazado_el','motivo','monto_base','duracion_dias',
      'instalacion_dias','garantia_dias','estado','fecha_participacion','fecha_propuesta','empresa_id','contacto_id','rotulo', 'revisado_el','revisado_por','motivo','observacion','automatica','documento_id',
      'es_favorito','updated_by','perdido_por',
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
      'aprobado_el'  => 'datetime',
      'rechazado_el' => 'datetime',
      'archivado_el' => 'datetime',
      'automatica'   => 'boolean',
    ];
    public function updateData($data) {
      DB::select('SELECT osce.fn_oportunidad_asignar_empresa(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . (!empty($data['empresa_id']) ? $data['empresa_id'] : 'null') . ',' . Auth::user()->id . ')');
      $data['updated_by'] = Auth::user()->id;
      $this->update($data);
    }
    public function log($tipo, $texto) {
      DB::select('SELECT osce.fn_oportunidad_actividad(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ", '" . $tipo . "', :texto)", [
        'texto' => $texto,
      ]);
    }
    public function folder($unix = false) {
      if($unix) {
        return 'OPORTUNIDADES/' . $this->codigo . '/';
      }
      return '\\OPORTUNIDADES\\' . $this->codigo . '\\';
    }
    public function institucion() {
      if(!empty($this->cliente_id)) {
        return $this->cliente()->rotulo();
      }
      $empr = $this->empresa();
      if(!empty($empr->seudonimo)) {
        return $empr->seudonimo;
      }
      if(!empty($empr->razon_social)) {
        return $empr->razon_social;
      }
      return '--';
    }
    public function etiquetas() {
      $rp = collect(DB::select('SELECT osce.fn_etiquetas_a_rotulo(L.etiquetas_id) ee
      FROM osce.oportunidad L WHERE id = ' . $this->id))->first();
      return $rp->ee;
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
    public function correo() {
      return $this->belongsTo('App\Correo', 'correo_id')->first();
    }
    public function correosRelacionados() {
      $rp = null;
      if(!empty($this->correo_id)) {
        $rp = DB::select("SELECT * FROM osce.correo WHERE id = :id OR id IN (SELECT correo_id FROM osce.correo_hilo WHERE token_id = (SELECT token_id FROM osce.correo_hilo WHERE correo_id = :id LIMIT 1))", ['id' => $this->correo_id]);
      }
      return Correo::hydrate($rp);
    }
    public static function list() {
      return Oportunidad::whereNull('oportunidad.licitacion_id')
        ->whereNull('oportunidad.eliminado')
        ->where('tenant_id', Auth::user()->tenant_id)
        ->orderBy('estado', 'asc')
        ->orderBy('created_on', 'desc');
    }
    public static function search($query) {
      $rp = DB::select("SELECT O.*
      FROM osce.oportunidad O
      LEFT JOIN osce.empresa E ON E.id = O.empresa_id
      WHERE O.licitacion_id IS NULL AND O.tenant_id = :tenant AND (
        LOWER(E.razon_social) LIKE :query
        OR LOWER(O.rotulo) LIKE :query
        OR LOWER(O.codigo) LIKE :query)
      LIMIT 20
        ", [
        'query'  => "%{$query}%",
        'tenant' => Auth::user()->tenant_id
        ]);
      return static::hydrate($rp);
    }
    public static function search_codigo($query) {
      $query = strtolower($query);
      return Oportunidad::leftJoin('osce.licitacion', 'oportunidad.licitacion_id','licitacion.id')
        ->leftJoin('osce.empresa', 'empresa.id','licitacion.empresa_id')
//        ->whereNull('oportunidad.licitacion_id')
        ->where(function($r) use($query) {
          $r->orWhereRaw("LOWER(oportunidad.codigo) LIKE ? ", ["%{$query}%" ]);
      });
    }

    public static function actividades(){
      $rp = DB::select("SELECT U.id user_id, U.usuario title, A1.created_on::date date, date_part('day', A1.created_on::date) dia, COUNT(DISTINCT A1.oportunidad_id) oportunidades,
        SUM(A1.tiempo_estimado) tiempo
        FROM (
          SELECT U.id, U.usuario
          FROM public.usuario U
          WHERE (U.tenant_id = " . Auth::user()->tenant_id . " OR U.tenant_id IS NULL) AND U.habilitado) U
          LEFT JOIN osce.actividad A1 ON A1.created_by = U.id AND A1.tipo_id IS NOT NULL AND A1.tenant_id = " . Auth::user()->tenant_id . "
          WHERE A1.tiempo_estimado is not null
          GROUP BY U.id, U.usuario, A1.created_on::date
          ORDER BY 1, 2
          ;");
     return static::hydrate($rp);
    }
    public function montos_variacion() {
      $rp = collect(DB::select("SELECT osce.oportunidad_variacion_montos(:id) monto", ['id' => $this->id]))->first();
      return $rp->monto;
    }
    public function precios() {
      $rp = collect(DB::select("SELECT AVG(monto) promedio, moneda_id FROM osce.cotizacion WHERE oportunidad_id = " . $this->id . " GROUP BY moneda_id LIMIT 1"))->first();
      if(empty($rp)) {
        return (object) array(
          'promedio'  => 0,
          'moneda_id' => 1,
        );
      }
      return $rp;
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
      return (!empty($this->importancia) ? '<span class="favorite warning"><i class="bx bxs-star"></i></span>' : '') . $rp . (!empty($this->revisado_el) ? '<b>[R]</b>' : '');
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
    public function empresasMenu() {
      $rp = DB::select("
        SELECT E.id, E.razon_social, C.id cotizacion
        FROM osce.empresa E
          LEFT JOIN osce.cotizacion C ON C.oportunidad_id = :oid AND C.empresa_id = E.id
        WHERE E.tenant_id = :tenant
        ORDER BY E.razon_social ASC
        LIMIT 10", [
          'oid' => $this->id,
          'tenant' => Auth::user()->tenant_id
        ]);
        return Empresa::hydrate($rp);
    }
    public function empresas() {
      $rp = DB::select("
        SELECT E.razon_social, E.ruc, E.descripcion, E.id e_empresa_id, C.*, C.id c_cotizacion_id, C.seace_participacion_log, C.seace_participacion_fecha, C.seace_participacion_html,
          osce.fn_cotizacion_fecha_estado_participacion(1, C.id::int) inx_estado_participacion,
          osce.fn_cotizacion_fecha_estado_propuesta(1, C.id::int) inx_estado_propuesta,
          osce.fn_cotizacion_fecha_estado_buenapro(1, C.id::int) inx_estado_buenapro,
          osce.fn_usuario_rotulo(C.interes_por) interes_por,
          osce.fn_usuario_rotulo(C.elaborado_por) elaborado_por,
          osce.fn_usuario_rotulo(C.participacion_por) participacion_por,
          osce.fn_usuario_rotulo(C.propuesta_por) propuesta_por
        FROM osce.empresa E
        LEFT JOIN osce.cotizacion C ON C.oportunidad_id = " . $this->id . " AND C.empresa_id = E.id
        WHERE E.tenant_id = " . $this->tenant_id . "
        ORDER BY E.id ASC, C.numero ASC
        LIMIT 10");
      return array_map(function($n) {
        return new Empresa((array) $n);
      }, $rp);
    }
    static function listado_nuevas() {
      /*$rp = DB::select("
            SELECT O.*
            FROM osce.oportunidad O
            left  JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.eliminado IS NULL
            WHERE O.archivado_el IS NULL AND O.rechazado_el IS NULL AND O.aprobado_el IS NULL
            ORDER BY L.fecha_participacion_hasta ASC 
            Limit 500
            ");*/
      $rp = DB::select("
            SELECT L.*
            FROM osce.licitacion L
            LEFT JOIN osce.oportunidad O ON L.id = O.licitacion_id
            WHERE O.licitacion_id IS NULL AND L.procedimiento_id IS NOT NULL
            ORDER BY L.id DESC, L.fecha_participacion_hasta DESC 
            Limit 500
            ");
      return static::hydrate($rp);
    }
    static function listado_archivadas() {
      $rp = DB::select("
SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id
WHERE O.archivado_el IS NOT NULL AND O.aprobado_el IS NOT NULL
ORDER BY O.archivado_el DESC
LIMIT 50");
      return static::hydrate($rp);
    }
    static function listado_eliminados() {
      $rp = DB::select("
SELECT O.*
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id
WHERE O.rechazado_el IS NOT NULL
ORDER BY O.rechazado_el DESC
LIMIT 50");
      return static::hydrate($rp);
    }
    static function estadistica_enviado_diario() {
      $rp = DB::cache(20, "
SELECT
	x.fecha,
	x.oportunidades,
	x.participando,
  x.enviadas,
	(CASE WHEN x.fecha <= '2022-07-31'::date THEN (CASE WHEN x.enviadas >= x.oportunidades THEN x.enviadas ELSE CEIL(x.oportunidades/1.8) END) ELSE x.enviadas END) enviadas2
FROM (
SELECT
  O.fecha_propuesta_hasta::date fecha,
  COUNT(DISTINCT O.id) oportunidades,
  COUNT(C.oportunidad_id) participando,
  COUNT(C.id) enviadas
FROM osce.oportunidad O
LEFT JOIN osce.cotizacion C ON C.oportunidad_id = O.id AND C.eliminado IS NULL AND C.propuesta_el IS NOT NULL
WHERE O.estado IN (1,2) AND O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
  AND O.fecha_propuesta_hasta >= NOW() - INTERVAL '18' DAY AND O.fecha_propuesta_hasta <= NOW() + INTERVAL '5' DAY
  AND O.tenant_id = :tenant
GROUP BY O.fecha_propuesta_hasta::date
ORDER BY 1 ASC
) x
      ", [
        'tenant' => Auth::user()->tenant_id,
      ]);
      return static::hydrate($rp);
    }
    static function requiere_atencion() {
      $rp = DB::cache(60 * 60, "
SELECT x.*
FROM (
SELECT O.*,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND interes_el IS NOT NULL) cantidad_interes,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND participacion_el IS NOT NULL) cantidad_participadas
FROM osce.oportunidad O
WHERE O.aprobado_el >= NOW() - INTERVAL '80' DAY AND O.rechazado_el IS NULL AND O.archivado_el IS NULL)x
JOIN osce.licitacion L ON L.id = x.licitacion_id
AND L.fecha_participacion_hasta - INTERVAL '1' HOUR <= NOW()
AND L.fecha_participacion_hasta + INTERVAL '12' HOUR >= NOW()
UNION
SELECT x.*
FROM (
SELECT O.*,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND participacion_el IS NOT NULL) cantidad_participadas,
  (SELECT COUNT(*) FROM osce.cotizacion WHERE oportunidad_id = O.id AND propuesta_el IS NOT NULL) cantidad_propuestas
FROM osce.oportunidad O
WHERE O.aprobado_el >= NOW() - INTERVAL '80' DAY AND O.rechazado_el IS NULL AND O.archivado_el IS NULL AND O.fecha_participacion IS NOT NULL
  AND O.tenant_id = :tenant
)x
JOIN osce.licitacion L ON L.id = x.licitacion_id
AND L.fecha_participacion_hasta - INTERVAL '1' HOUR <= NOW()
AND L.fecha_participacion_hasta + INTERVAL '12' HOUR >= NOW()
LIMIT 5;
", [
  'tenant' => Auth::user()->tenant_id
]);
      return static::hydrate($rp); 
    }
   static function listado_participanes_por_vencer() {
     $rp = DB::select("
     SELECT
  z.*,
  CONCAT(
    (CASE WHEN z.expediente_step IS NOT NULL THEN CONCAT('<span style=\"background: #438eff;font-size: 11px;color: white;padding: 1px 4px;border-radius: 3px;margin-right: 2px;\">', z.expediente_step::text, '</span>') ELSE '' END),
    (CASE WHEN z.es_favorito IS NOT NULL THEN '<i class=\"bx bxs-circle\" style=\"color:orange;font-size: 10px;\"></i>' ELSE '' END),
    (CASE WHEN z.aprobado_el >= DATE_TRUNC('day', NOW()) - INTERVAL '1' DAY THEN '<i class=\"bx bxs-circle\" style=\"color:green;font-size: 10px;\"></i>' ELSE '' END),
    UPPER(z.rotulo)
  ) inx_rotulo
FROM (
  SELECT
    x.*,
    osce.fn_oportunidad_expediente_step(x.tenant_id, x.id) as expediente_step,
    (SELECT COUNT(*) FROM osce.oportunidad_externo WHERE oportunidad_id = x.id) cantidad_externo,
    osce.fn_usuario_rotulo(x.aprobado_por) aprobado_por,
    osce.fn_usuario_rotulo(x.revisado_por) revisado_por,
    osce.fn_oportunidad_fecha_estado_participacion(1, x.id) inx_estado_participacion,
    osce.fn_etiquetas_a_rotulo(x.etiquetas_id) etiquetas,
    osce.oportunidad_variacion_montos(x.id) montos
  FROM (
    SELECT
      O.*,
      (SELECT COUNT(*) FROM osce.cotizacion C
        WHERE C.oportunidad_id = O.id AND C.eliminado IS NULL AND C.participacion_el IS NULL AND C.seace_participacion_log IS NOT NULL) no_es_posible,
      (SELECT COUNT(*) FROM osce.cotizacion C
        WHERE C.oportunidad_id = O.id AND C.eliminado IS NULL AND C.interes_el IS NOT NULL) empresas_interes
    FROM (
      SELECT O.tenant_id, O.id, O.licitacion_id, O.aprobado_el, O.etiquetas_id, O.aprobado_por, O.rotulo, O.fecha_participacion_hasta, O.correo_id, O.revisado_el, O.revisado_por, O.es_favorito
      FROM osce.oportunidad O
      WHERE O.estado = 1 AND O.tenant_id = 1 AND O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL AND O.correo_id IS NULL
        AND O.tenant_id = :tenant
        AND (
          (O.fecha_participacion_hasta >= NOW() - INTERVAL '2' DAY AND O.fecha_participacion_hasta <= NOW() + INTERVAL '4' DAY)
          OR O.aprobado_el::date = NOW()::date
          OR EXISTS(SELECT OE.id FROM osce.oportunidad_externo OE WHERE OE.oportunidad_id = O.id)
          OR O.es_favorito IS NOT NULL
        )
    ) O
  ) x
  WHERE x.no_es_posible > 0 OR x.empresas_interes = 0 OR x.aprobado_el::date = NOW()::date OR EXISTS( SELECT OE.id FROM osce.oportunidad_externo OE WHERE OE.oportunidad_id = x.id) OR x.es_favorito IS NOT NULL
) z
ORDER BY z.fecha_participacion_hasta ASC, z.id ASC
LIMIT 100", [
  'tenant' => Auth::user()->tenant_id
]);
     /*$rp = DB::cache(20, "
       SELECT x.*,
         L.fecha_participacion_hasta,
         CONCAT(
           (CASE WHEN x.expediente_step IS NOT NULL THEN CONCAT('<span style=\"background: #438eff;font-size: 11px;color: white;padding: 1px 4px;border-radius: 3px;margin-right: 2px;\">', x.expediente_step::text, '</span>') ELSE '' END),
           (CASE WHEN x.cantidad_externo > 0 THEN '<i class=\"bx bxs-circle\" style=\"color:orange;\"></i>' ELSE '' END),
           (CASE WHEN x.aprobado_el >= DATE_TRUNC('day', NOW()) - INTERVAL '1' DAY THEN '<i class=\"bx bxs-circle\" style=\"color:green;\"></i>' ELSE '' END),
           UPPER(L.rotulo)
         ) inx_rotulo,
         osce.licitacion_fecha_estado_participacion(1, L.id::int) inx_estado_participacion,
         osce.fn_etiquetas_a_rotulo(x.etiquetas_id) etiquetas
FROM (
SELECT O.*,
  osce.fn_oportunidad_expediente_step(O.tenant_id, O.id) as expediente_step,
  (SELECT COUNT(*) FROM osce.oportunidad_externo WHERE oportunidad_id = O.id) cantidad_externo,
  (SELECT COUNT(*) FROM osce.cotizacion C WHERE C.oportunidad_id = O.id AND C.eliminado IS NULL AND C.participacion_el IS NULL AND COALESCE(LENGTH(C.seace_participacion_log), 0) > 0) no_es_posible,
  (SELECT COUNT(*) FROM osce.cotizacion C WHERE C.oportunidad_id = O.id AND C.eliminado IS NULL AND C.interes_el IS NOT NULL) empresas_interes,
  osce.fn_usuario_rotulo(O.aprobado_por) aprobado_usuario,
  aprobado_el aprobado_fecha
FROM osce.oportunidad O
WHERE O.aprobado_el >= NOW() - INTERVAL '80' DAY AND O.rechazado_el IS NULL AND O.archivado_el IS NULL)x
JOIN osce.licitacion L ON L.id = x.licitacion_id AND L.eliminado IS NULL 
AND 
  ((L.fecha_participacion_desde - INTERVAL '1' DAY <= NOW() AND L.fecha_participacion_hasta + INTERVAL '1' DAY >= NOW())
  OR (L.fecha_participacion_hasta - INTERVAL '4' DAY <= NOW() AND L.fecha_participacion_hasta + INTERVAL '2' DAY >= NOW()))
-- WHERE x.cantidad_interes = 0 OR x.cantidad_interes <> x.cantidad_participadas
WHERE L.fecha_participacion_hasta <= NOW() + INTERVAL '2' DAY OR x.no_es_posible > 0 OR x.empresas_interes = 0 OR x.aprobado_el::date = NOW()::date
ORDER BY L.fecha_participacion_hasta ASC, id DESC");*/
      return static::hydrate($rp);
   }
    static function listado_propuestas_por_vencer() {
      $rp = DB::cache(20, "
SELECT
  z.*,
  CONCAT(
    (CASE WHEN z.expediente_step IS NOT NULL THEN CONCAT('<span style=\"background: #438eff;font-size: 11px;color: white;padding: 1px 4px;border-radius: 3px;margin-right: 2px;\">', z.expediente_step::text, '</span>') ELSE '' END),
    (CASE WHEN z.es_favorito IS NOT NULL THEN '<i class=\"bx bxs-circle\" style=\"color:orange;font-size: 10px;\"></i>' ELSE '' END),
    (CASE WHEN z.aprobado_el >= DATE_TRUNC('day', NOW()) - INTERVAL '1' DAY THEN '<i class=\"bx bxs-circle\" style=\"color:green;font-size: 10px;\"></i>' ELSE '' END),
    UPPER(z.rotulo)
  ) inx_rotulo
FROM (
  SELECT
    x.*,
    osce.fn_oportunidad_expediente_step(x.tenant_id, x.id) as expediente_step,
    osce.fn_oportunidad_expediente_step_min(x.tenant_id, x.id) as expediente_step_min,
    EXISTS(SELECT OE.id FROM osce.oportunidad_externo OE WHERE OE.oportunidad_id = x.id) cantidad_externo,
    osce.fn_usuario_rotulo(x.aprobado_por) aprobado_por,
    osce.fn_usuario_rotulo(x.revisado_por) revisado_por,
    osce.fn_oportunidad_fecha_estado_propuesta(1, x.id) inx_estado_propuesta,
    osce.fn_etiquetas_a_rotulo(x.etiquetas_id) etiquetas,
    osce.oportunidad_variacion_montos(x.id) montos,
    osce.fn_licitacion_tiene_bintegradas(x.licitacion_id::int) tiene_bases
  FROM (
    SELECT
      O.*,
      EXISTS(SELECT C.id FROM osce.cotizacion C
        WHERE C.oportunidad_id = O.id AND C.eliminado IS NULL AND C.interes_el IS NOT NULL) empresas_interes
    FROM (
      SELECT O.tenant_id, O.id, O.licitacion_id, O.aprobado_el, O.etiquetas_id, O.aprobado_por, O.rotulo, O.fecha_propuesta_hasta, O.correo_id, O.revisado_el, O.revisado_por, O.es_favorito, O.estado
      FROM osce.oportunidad O
      WHERE 
		    O.tenant_id = :tenant AND O.estado IN (1,2) AND O.aprobado_el IS NOT NULL
    		AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
        AND O.fecha_propuesta_hasta >= NOW() - INTERVAL '7' DAY
        AND ((O.fecha_propuesta_hasta >= NOW() - INTERVAL '10' HOUR AND O.fecha_propuesta_hasta <= NOW() + INTERVAL '25' DAY) OR O.es_favorito IS NOT NULL)
    ) O
  ) x
  WHERE x.empresas_interes IS FALSE OR x.aprobado_el::date = NOW()::date OR x.es_favorito IS NOT NULL
	OR x.fecha_propuesta_hasta <= NOW() + INTERVAL '25' DAY
) z
ORDER BY z.correo_id IS NULL ASC, z.fecha_propuesta_hasta::date ASC, z.fecha_propuesta_hasta::time ASC, z.es_favorito IS NULL DESC, z.estado DESC, (z.expediente_step_min = 4) ASC, z.revisado_el IS NULL ASC, z.expediente_step_min DESC
LIMIT 80", ['tenant' => Auth::user()->tenant_id]);
      /*
        SELECT x.*,
          L.fecha_propuesta_hasta,
         CONCAT(
           (CASE WHEN x.expediente_step IS NOT NULL THEN CONCAT('<span style=\"background: #438eff;font-size: 11px;color: white;padding: 1px 4px;border-radius: 3px;margin-right: 2px;\">', x.expediente_step::text, '</span>') ELSE '' END),
           (CASE WHEN x.cantidad_externo > 0 THEN '<i class=\"bx bxs-circle\" style=\"color:orange;font-size: 10px;\"></i>' ELSE '' END),
           (CASE WHEN x.aprobado_el >= DATE_TRUNC('day', NOW()) - INTERVAL '1' DAY THEN '<i class=\"bx bxs-circle\" style=\"color:green;font-size: 10px;\"></i>' ELSE '' END),
           UPPER(L.rotulo)
         ) inx_rotulo,
         osce.licitacion_fecha_estado_propuesta(1, L.id::int) inx_estado_propuesta,
         osce.fn_etiquetas_a_rotulo(x.etiquetas_id) etiquetas
FROM (
SELECT O.*,
  osce.fn_oportunidad_expediente_step(O.tenant_id, O.id) as expediente_step,
  (SELECT COUNT(*) FROM osce.oportunidad_externo WHERE oportunidad_id = O.id) cantidad_externo,
  osce.fn_usuario_rotulo(O.aprobado_por) aprobado_usuario,
  aprobado_el aprobado_fecha
FROM osce.oportunidad O
WHERE O.aprobado_el >= NOW() - INTERVAL '80' DAY AND O.rechazado_el IS NULL AND O.archivado_el IS NULL AND O.fecha_participacion IS NOT NULL)x
JOIN osce.licitacion L ON L.id = x.licitacion_id AND L.eliminado IS NULL
AND
  ((L.fecha_propuesta_desde - INTERVAL '2' DAY <= NOW() AND L.fecha_propuesta_hasta + INTERVAL '2' DAY >= NOW())
  OR (L.fecha_propuesta_hasta - INTERVAL '10' DAY <= NOW() AND L.fecha_propuesta_hasta + INTERVAL '10' DAY >= NOW()))
-- WHERE x.cantidad_propuestas = 0 OR x.cantidad_propuestas <> x.cantidad_participadas
ORDER BY L.fecha_propuesta_hasta ASC, id DESC");*/
      return static::hydrate($rp);
    }
    static function listado_por_aprobar($ids = "0" ){
      $rpta = DB::select("select O.id, O.licitacion_id, osce.fn_empresa_rotulo(".Auth::user()->tenant_id." , O.empresa_id ) entidad, O.empresa_id,  O.rotulo, coalesce( L.nomenclatura, O.codigo ) nomenclatura, O.correo_id,L.bases_integradas,coalesce( O.monto_base, L.monto ) monto, O.estado, L.moneda
from osce.oportunidad O
left join osce.licitacion L on L.id = O.licitacion_id
where rechazado_el is null
and aprobado_por is null
and O.id not in (" . $ids . ")
order by O.id DESC
limit 15
");
      return static::hydrate($rpta);  
    }
    static function listado_propuestas_buenas_pro() {
      $rp = DB::cache(20, "
    SELECT
      O.*,
      CONCAT(
           (CASE WHEN O.es_favorito IS NOT NULL THEN '<i class=\"bx bxs-circle\" style=\"color:orange;font-size: 10px;\"></i>' ELSE '' END),
           (CASE WHEN O.aprobado_el >= DATE_TRUNC('day', NOW()) - INTERVAL '1' DAY THEN '<i class=\"bx bxs-circle\" style=\"color:green;font-size: 10px;\"></i>' ELSE '' END),
           UPPER(L.nomenclatura)
         ) nomenclatura,
      osce.licitacion_fecha_estado_buenapro(O.tenant_id, O.licitacion_id::int) inx_estado,
      osce.licitacion_ganadores(O.tenant_id, O.licitacion_id::int) inx_ganadores,
      osce.fn_etiquetas_a_rotulo(L.etiquetas_id) etiquetas,
      osce.fn_oportunidad_involucrados(O.tenant_id, O.id) elaborado_por
FROM (SELECT O.*,
(SELECT COUNT(*) FROM osce.oportunidad_externo WHERE oportunidad_id = O.id) cantidad_externo
FROM osce.oportunidad O
WHERE O.tenant_id = 1 AND O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
  --AND O.fecha_participacion IS NOT NULL
 AND O.fecha_propuesta IS NOT NULL
 AND O.tenant_id = :tenant
) O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND ((L.fecha_buena_desde >= NOW() AND L.fecha_buena_hasta <= NOW())
  OR (L.fecha_buena_hasta >= NOW() - INTERVAL '7' DAY AND L.fecha_buena_hasta <= NOW() + INTERVAL '20' DAY)
  OR (L.buenapro_fecha >= NOW() - INTERVAL '7' DAY))
ORDER BY L.buenapro_fecha ASC, L.fecha_buena_hasta ASC, O.id ASC", [
  'tenant' => Auth::user()->tenant_id
]);
      return static::hydrate($rp);
    }
   static function listado_aprobadas() {
      $rp = DB::select("
        SELECT O.*
    FROM osce.oportunidad O
    JOIN osce.licitacion L ON L.id = O.licitacion_id
    WHERE O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
    ORDER BY O.aprobado_el DESC, O.id ASC
    LIMIT 100");
      return static::hydrate($rp);
    }
    public static function crearLibre($empresa_id) {
      return collect(DB::select('SELECT osce.fn_registrar_oportunidad_libre(' . Auth::user()->tenant_id . ',' . Auth::user()->id . ',' . $empresa_id . ') id'))->first();
    }
    public function favorito() {
      $this->update([
        'es_favorito' => DB::raw('now()'),
      ]);
    }
    public function aprobar() {
      return collect(DB::select('SELECT * FROM osce.fn_oportunidad_accion_aprobar(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ')'))->first();
    }
    public function revisar() {
      return collect(DB::select('SELECT * FROM osce.fn_oportunidad_accion_revisar(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ')'))->first();
    }
    public function rechazar($motivo) {
      return collect(DB::select('SELECT * FROM osce.fn_oportunidad_accion_rechazar(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ', :texto)', [
      'texto' => $motivo
      ]))->first();
    }
    public function archivar($motivo) {
      return collect(DB::select('SELECT * FROM osce.fn_oportunidad_accion_archivar(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ', :texto)', [
      'texto' => $motivo
      ]))->first();
    }
    public function registrar_interes(Empresa $empresa) {
      return collect(DB::select('SELECT * FROM osce.fn_oportunidad_accion_interes(' . Auth::user()->tenant_id . ', ' . $this->id . ', ' . Auth::user()->id . ', ' . $empresa->id . ', null);'))->first();
    }
    public function timeline() {
      return $this->hasMany('App\Actividad','oportunidad_id')->orderBy('id', 'desc')->get();
    }
    public function similares() {
      return DB::select("
        SELECT *
        FROM osce.fn_oportunidad_similares(:tenant, :referencia) B
        LIMIT 20", ['tenant' => Auth::user()->tenant_id, 'referencia' => $this->id]);
    }
    public function licitaciones_similares() {
      return DB::select("
        SELECT *, array_to_string(B.licitaciones_id,',') ids
        FROM osce.fn_oportunidad_licitaciones_similares(:tenant, :referencia) B
        LIMIT 20", ['tenant' => Auth::user()->tenant_id, 'referencia' => $this->id]);
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
      if(!empty($this->inx_estado_participacion)) {
        return json_decode($this->inx_estado_participacion, true);
      }
      exit;
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
      if(!empty($this->inx_estado_propuesta)) {
        return json_decode($this->inx_estado_propuesta, true);
      }
      exit;
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
      if(!empty($this->inx_estado)) {
        return json_decode($this->inx_estado, true);
      }
      exit;
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
    public function participantes() {
      $rp = DB::select("
        SELECT osce.empresa_rotulo(C.tenant_id, C.empresa_id) empresa, osce.moneda_formato_humano(C.monto) monto
        FROM osce.cotizacion C
        WHERE C.oportunidad_id = {$this->id} AND C.participacion_el IS NOT NULL AND C.propuesta_el IS NOT NULL
        ORDER BY C.empresa_id ASC
        LIMIT 10");
      $out = [];
      foreach($rp as $n) {
        $out[] = $n->empresa . ' con ' . $n->monto;
      }
      return implode('<br/>', $out);
    }
    public function ganadora() {
      if(isset($this->inx_ganadores)) {
        return $this->licitacion()->ganadora($this->inx_ganadores);
      }
      return $this->licitacion()->ganadora();
    }
    public function estado() {
      $ahora = time();
      $participacion_desde =  strtotime($this->fecha_participacion_desde);
      $participacion_hasta =  strtotime($this->fecha_participacion_hasta);
      $propuesta_desde =  strtotime($this->fecha_propuesta_desde);
      $propuesta_hasta =  strtotime($this->fecha_propuesta_hasta);

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
            'message' => 'REQ PROPUESTA',
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
            'message' => 'NO PARTICIPA',
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
    static function estadistica_barra_cantidades() {
      return DB::select("SELECT fecha eje_x, cantidad eje_y, tipo collection FROM osce.estadistica_rapida_oportunidades(:tenant, 7, :user)", [
        'tenant' => Auth::user()->tenant_id,
        'user'   => Auth::user()->id,
      ]);
    }
    static function estadistica_cantidad_mensual() {
      return DB::select("
        SELECT
        	date_trunc('month', O.fecha_participacion)::date eje_x,
          count(*) eje_y,
          'PARTICIPACION' collection
        FROM osce.oportunidad O
        WHERE O.tenant_id = :tenant AND O.fecha_participacion IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
        GROUP BY 1
        UNION
        SELECT
          date_trunc('month', O.fecha_propuesta)::date eje_x,
          count(*) eje_y,
          'PROPUESTA' collection
        FROM osce.oportunidad O
        WHERE O.tenant_id = :tenant AND O.fecha_propuesta IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
        GROUP BY 1
        UNION
SELECT
	date_trunc('month', O.fecha_propuesta)::date eje_x,
	count(*) eje_y,
	'BUENA PRO' collection
FROM osce.oportunidad O
WHERE O.tenant_id = :tenant AND O.fecha_propuesta IS NOT NULL
	AND EXISTS(
		SELECT P.id
		FROM osce.cotizacion C
		JOIN osce.proyecto P ON P.cotizacion_id = C.id AND P.eliminado IS FALSE
		WHERE C.oportunidad_id = O.id
	)
GROUP BY 1
        ORDER BY 1 ASC", [
          'tenant' => Auth::user()->tenant_id
        ]);
    }
    public function render_estado() {
      if($this->estado == 1) {
        return 'Espera';
      } elseif($this->estado == 2) {
        return 'Abierto';
      } elseif($this->estado == 3) {
        $pro = $this->proyecto();
        if(!empty($pro->id)) {
          return 'PROYECTO';

        } elseif(!empty($this->conclusion_el)) {
          return 'Perdido';

        } else {
          return '[Revisar]';
        }
        return 'Cerrado';
      } else {
        return '--';
      }
    }
    public function estadoArray() {
      return static::selectEstados()[$this->estado];
    }
    static function selectEstados() {
      return [
        1 => array('name' => 'ESPERA', 'color' => '#f3f3f3'),
        2 => array('name' => 'ABIERTA', 'color' => '#2dc72d'),
        3 => array('name' => 'CERRADA', 'color' => '#2c2c2c'),
      ];
    }
    static function selectPerdidos() {
      return [
        'PRECIO_COMPETENCIA' => array('name' => 'POR COMPETENCIA', 'color' => '#2c2c2c'),
        'PRECIO_ELEVADO' => array('name' => 'POR PRECIO ELEVADO', 'color' => '#f3f3f3'),
        'PRECIO_BAJO' => array('name' => 'POR PRECIO BAJO', 'color' => '#2dc72d'),
        'MAL_ANEXO' => array('name' => 'POR MAL ANEXO', 'color' => '#2c2c2c'),
        'DEFECTUOSO' => array('name' => 'POR DEFECTUOSO', 'color' => '#2c2c2c'),
        'FICHA_TENICA' => array('name' => 'POR FICHA TECNICA', 'color' => '#2c2c2c'),
        'FIRMAS' => array('name' => 'POR FIRMA', 'color' => '#2c2c2c'),
        'VIGENCIA_PODER' => array('name' => 'POR COMPETENCIA', 'color' => '#2c2c2c'),
        'ERROR_CONTRATO' => array('name' => 'POR CONTRATO ERRONEO', 'color' => '#2c2c2c'),
        'EXPERIENCIA' => array('name' => 'POR EXPERIENCIA', 'color' => '#2c2c2c'),
        'PERSONAL_CLAVE' => array('name' => 'POR PERSONAL CLAVE', 'color' => '#2c2c2c'),
        'NO_ENVIADO' => array('name' => 'POR NO ENVIAR', 'color' => '#2c2c2c'),
        'NO_PARTNER' => array('name' => 'POR DOC FABRICANTE', 'color' => '#2c2c2c'),
        'OTRO' => array('name' => 'POR OTRO', 'color' => '#2c2c2c'),
      ];
    }
    public function json_load() {
      return Helper::json_load('oportunidad_' . $this->id);
    }
    public function json_save($x) {
      return Helper::json_save('oportunidad_' . $this->id);
    }
  protected static function booted()
    {
        static::addGlobalScope(new MultiTenant);
    }
}
