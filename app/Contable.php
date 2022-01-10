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
}
