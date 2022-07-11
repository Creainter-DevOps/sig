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
"))->map(function($x){ return (array) $x; })->toArray();
    }
}
