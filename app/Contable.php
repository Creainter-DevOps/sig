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

class Contable extends Model
{
    protected $connection = 'interno';

    static function cobros_por_anho() {
      return DB::select("
SELECT
EXTRACT(year from P.fecha) anho,
SUM((CASE WHEN P.fecha <= NOW() AND P.estado_id = 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_cobradas,
SUM((CASE WHEN P.fecha <= NOW() AND P.estado_id <> 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_por_pendientes,
SUM((CASE WHEN P.fecha > NOW() AND P.estado_id <> 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_por_cobrar
FROM osce.pago P
GROUP BY EXTRACT(year from P.fecha)
ORDER BY 1 ASC");
    }
    static function cobro_por_empresas_anho() {
      return DB::select("
SELECT
C.nomenclatura,
EXTRACT(year from P.fecha) anho,
SUM((CASE WHEN P.fecha <= NOW() AND P.estado_id = 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_cobradas,
SUM((CASE WHEN P.fecha <= NOW() AND P.estado_id <> 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_por_pendientes,
SUM((CASE WHEN P.fecha > NOW() AND P.estado_id <> 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_por_cobrar
FROM osce.pago P
JOIN osce.proyecto PP ON PP.id = P.proyecto_id
LEFT JOIN osce.cliente C ON C.id = PP.cliente_id
GROUP BY EXTRACT(year from P.fecha), C.nomenclatura
ORDER BY 2 ASC, 1 ASC");
    }
    static function pago_por_empresas() {
      return DB::select("
SELECT
C.nomenclatura,
SUM((CASE WHEN P.fecha <= NOW() AND P.estado_id = 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_cobradas,
SUM((CASE WHEN P.fecha <= NOW() AND P.estado_id <> 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_por_pendientes,
SUM((CASE WHEN P.fecha > NOW() AND P.estado_id <> 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_por_cobrar
FROM osce.pago P
JOIN osce.proyecto PP ON PP.id = P.proyecto_id
LEFT JOIN osce.cliente C ON C.id = PP.cliente_id
GROUP BY C.nomenclatura
ORDER BY 1 ASC, 2 ASC");
    }
    static function pago_por_meses() {
      return DB::select("
SELECT
EXTRACT(year from P.fecha) anho,
EXTRACT(month from P.fecha) mes,
SUM((CASE WHEN P.fecha <= NOW() AND P.estado_id = 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_cobradas,
SUM((CASE WHEN P.fecha <= NOW() AND P.estado_id <> 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_por_pendientes,
SUM((CASE WHEN P.fecha > NOW() AND P.estado_id <> 3 THEN osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) ELSE 0 END)) cuentas_por_cobrar
FROM osce.pago P
GROUP BY EXTRACT(year from P.fecha), EXTRACT(month from P.fecha)
ORDER BY 1 ASC, 2 ASC");
    }
    static function proximos_pagos() {
      return DB::select("
SELECT
  PP.id proyecto_id,
  PP.codigo,
  PP.rotulo,
  P.fecha,
  P.numero,
  P.monto,
  P.moneda_id,
  osce.fn_convertir_moneda(1, P.monto, P.moneda_id, P.fecha) soles
FROM osce.pago P
JOIN osce.proyecto PP ON PP.id = P.proyecto_id
JOIN osce.oportunidad O ON O.id = PP.oportunidad_id
WHERE P.fecha <= NOW() + INTERVAL '10' DAY AND P.estado_id IN (1,2)
ORDER BY P.fecha ASC");
    }
    static function facturas_por_cobrar() {
      return DB::select("
SELECT PP.rotulo, P.*
FROM osce.pago P
JOIN osce.proyecto PP ON PP.id = P.proyecto_id
WHERE P.estado_id IN (1,2) AND P.fecha <= NOW()::date");
    }
    static function licitaciones_semanal() {
      $rp = DB::select("
SELECT O.*, L.nomenclatura, E.razon_social, L.rotulo, L.fecha_propuesta_hasta,
(
	SELECT string_agg(E1.seudonimo, ', ')
	FROM osce.cotizacion C
	JOIN osce.empresa E1 ON E1.id = C.empresa_id
	WHERE C.oportunidad_id = O.id AND C.interes_el IS NOT NULL
) empresas_interes,
(
	SELECT string_agg(E1.seudonimo, ', ')
	FROM osce.cotizacion C
	JOIN osce.empresa E1 ON E1.id = C.empresa_id
	WHERE C.oportunidad_id = O.id AND C.participacion_el IS NOT NULL
) empresas_participantes,
(
	SELECT string_agg(E1.seudonimo, ', ')
	FROM osce.cotizacion C
	JOIN osce.empresa E1 ON E1.id = C.empresa_id
	WHERE C.oportunidad_id = O.id AND C.propuesta_el IS NOT NULL
) empresas_propuestas,
U1.usuario rechazado_por,
U2.usuario archivado_por
FROM osce.oportunidad O
JOIN osce.licitacion L ON L.id = O.licitacion_id AND L.fecha_propuesta_hasta >= date_trunc('week', NOW())::timestamp without time zone
	AND L.fecha_propuesta_hasta <= (date_trunc('week', NOW())+ '7 days'::interval)::timestamp without time zone
JOIN osce.empresa E ON E.id = L.empresa_id
LEFT JOIN public.usuario U1 ON U1.id = O.rechazado_por
LEFT JOIN public.usuario U2 ON U2.id = O.archivado_por
WHERE O.aprobado_el IS NOT NULL
ORDER BY L.fecha_propuesta_hasta ASC");
      return Oportunidad::hydrate($rp);
    }
}
