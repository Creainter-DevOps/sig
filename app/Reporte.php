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

class Reporte extends Model
{
    protected $connection = 'interno';

    static function participaciones() {
      return collect(DB::select("
      SELECT
        O.id,
	O.aprobado_el,
	osce.fn_usuario_rotulo(O.aprobado_por) aprobado_por,
	O.codigo,
	O.rotulo,
	osce.empresa_rotulo(O.tenant_id, O.empresa_id) institucion,
	O.fecha_participacion_hasta,
	O.fecha_propuesta_hasta,
	O.fecha_buena_hasta,
	osce.empresa_rotulo(O.tenant_id, C.empresa_id) empresa,
	C.participacion_el,
	osce.fn_usuario_rotulo(C.participacion_por) participacion_por,
	C.propuesta_el,
	osce.fn_usuario_rotulo(C.propuesta_por) propuesta_por,
  osce.moneda_formato_humano(C.monto) monto,
	osce.licitacion_ganadores(O.tenant_id, O.licitacion_id::int) ganadores
FROM osce.oportunidad O
	LEFT JOIN osce.cotizacion C ON C.oportunidad_id = O.id
WHERE O.aprobado_el IS NOT NULL AND O.rechazado_el IS NULL AND O.archivado_el IS NULL
AND O.licitacion_id IS NOT NULL
AND (O.estado = 1 AND O.fecha_buena_hasta >= NOW() - INTERVAL '10' DAY)
ORDER BY O.fecha_propuesta_hasta ASC
LIMIT 100
"))->map(function($x){ return (array) $x; })->toArray();
    }
    static function mensual() {
      return collect(DB::select("
SELECT *
FROM (
	SELECT
		sec.dia,
		U.usuario,
		(
			COUNT(DISTINCT O.id)
		) oportunidades,
		(
			COUNT(DISTINCT C.id)
		) cotizaciones,
		(
			SUM((CASE WHEN D.elaborado_por = U.id AND D.finalizado_el IS NULL THEN 1 ELSE 0 END))
		) proceso,
		(
			SUM((CASE WHEN D.revisado_por = U.id AND D.revisado_el IS NOT NULL THEN 1 ELSE 0 END))
		) revisado,
		(
			SUM((CASE WHEN D.finalizado_por = U.id AND D.finalizado_el IS NOT NULL THEN 1 ELSE 0 END))
		) terminado,
		(
			SELECT COUNT(*)
			FROM osce.documento D2
			WHERE D2.finalizado_por = ANY(array_agg(U.id)) AND D2.finalizado_el IS NOT NULL
			AND D2.finalizado_el::date = sec.dia
			AND NOT(D2.id = ANY(array_agg(D.id)))
		) adelanto,
		(
			SUM((CASE WHEN C.propuesta_por = U.id AND C.propuesta_el IS NOT NULL THEN 1 ELSE 0 END))
		) enviado,
		(
			SELECT COUNT(*)
			FROM osce.cotizacion C2
			WHERE C2.propuesta_por = ANY(array_agg(U.id)) AND C2.propuesta_el IS NOT NULL
			AND C2.propuesta_el::date = sec.dia
			AND NOT(C2.id = ANY(array_agg(C.id)))
		) enviado_fuera
	FROM (
		SELECT generate_series((NOW() - INTERVAL '30' DAY)::date, NOW()::date, '1 day')::date dia
	) sec
	JOIN public.usuario U ON U.tenant_id = 1 AND U.habilitado IS TRUE
	LEFT JOIN osce.oportunidad O ON O.fecha_propuesta_hasta::date = sec.dia
	LEFT JOIN osce.cotizacion C ON C.oportunidad_id = O.id
	LEFT JOIN osce.documento D ON D.id = C.documento_id
	GROUP BY sec.dia, U.usuario
	ORDER BY sec.dia DESC, U.usuario
) F
WHERE F.proceso <> 0  OR F.adelanto <> 0 OR F.revisado <> 0 OR F.terminado <> 0 OR F.enviado <> 0 OR F.enviado_fuera <> 0
      "));
      }
}
