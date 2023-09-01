<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Facades\DB;
use Auth;

class User extends Authenticatable {

    use Notifiable,HasApiTokens,HasRoles;

    protected $table = 'public.usuario';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','displayName','mail', 'usuario', 'clave','tenant_id','last_sesion'
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

//    public function getAuthIdentifier() {
//        return $this->getKey();
//    }
    public function refreshLastSesion() {
      $this->update([
        'last_sesion' => DB::raw('now()')
      ]);
    }
    public function getAuthPassword() {
      return $this->clave;
    }
    public function username() {
      return '@' . $this->usuario;
    }
    public function tenants() {
      return $this->hasMany('App\Empresa', 'tenant_id', 'tenant_id')->get();
    }
    public function allow($tipo, $externo = null) {
      return (collect(DB::select("SELECT osce.fn_usuario_permiso(:id, :tipo, :externo) estado", [
        'id'      => Auth::user()->id,
        'tipo'    => $tipo,
        'externo' => $externo
      ]))->first())->estado;
    }
    public function byId($id) {
      return (collect(DB::select("SELECT osce.fn_usuario_rotulo(:id) user", [
        'id' => $id,
      ]))->first())->user;
    }
    public static function empresas() {
      return collect(DB::select("
        SELECT id, razon_social
        FROM osce.empresa E
        WHERE E.tenant_id = :tenant
        ORDER BY 2 ASC
      ", [
        'tenant' => Auth::user()->tenant_id
      ]));
    }
    public static function perfiles($empresa_id = null, $id_usuario = null, $correos = null) {
      return collect(DB::select("SELECT * FROM osce.fn_usuario_perfiles(:tenant, :id, :empresa, :correos)", [
        'tenant'  => Auth::user()->tenant_id,
        'id'      => $id_usuario == null ? Auth::user()->id :  $id_usuario ,
        'empresa' => $empresa_id,
        'correos' => $correos,
      ]));
    }
    public static function space() {
      return ceil(((disk_total_space('/') - disk_free_space('/')) * 100) / disk_total_space('/'));
    }
    public static function perfil($id, $correo_id = null) {
      return collect(DB::select("
        SELECT
          UE.linea, UE.anexo, UE.celular, UE.cargo, UE.correo,
        	E.color_primario, E.logo_head logo,
          C.ex_user_id, C.ex_access_token,
          (SELECT CC.cid FROM osce.correo CC WHERE CC.id = :cid LIMIT 1) correo_cid,
          (SELECT CC.asunto FROM osce.correo CC WHERE CC.id = :cid LIMIT 1) correo_asunto
        FROM public.usuario_empresa UE
        LEFT JOIN osce.empresa E ON E.id = UE.empresa_id
        LEFT JOIN osce.credencial C ON C.id = UE.credencial_id
        WHERE UE.id = :id AND UE.tenant_id = :tenant AND (UE.usuario_id = :user OR UE.usuario_id IS NULL)", [
        'id'      => $id,
        'tenant'  => Auth::user()->tenant_id,
        'user'    => Auth::user()->id,
        'cid'     => $correo_id,
      ]))->first();
    }
    public static function facturas_visibles($out) {
      $rp  = DB::collect("
        SELECT *, (COALESCE(F.monto_pagado, 0) = F.monto) es_pagado
        FROM public.factura F
        WHERE F.tenant_id = :tenant AND (F.saldo_a_favor < 0 OR F.fecha_vencimiento <= NOW())
        	AND (F.fecha_pago >= NOW() - INTERVAL '5' DAY OR F.fecha_pago IS NULL)
        ORDER BY F.fecha_emision ASC
        LIMIT 4
      ", [
        'tenant' => Auth::user()->tenant_id,
      ]);
      $out = $rp->execute;
      return static::hydrate($rp->toArray());
    }
    public static function estadisticas($id = null) {
      $id = $id ?? Auth::user()->id;
      return collect(DB::select("
        SELECT
          SUM((CASE WHEN C.propuesta_el IS NOT NULL AND C.propuesta_por = :user AND C.propuesta_el >= DATE_TRUNC('week', NOW()) THEN 1 ELSE 0 END)) enviados_semana,
          COUNT(D.id) elaborados, COUNT(C.id) enviados, COUNT(P.id) ganados, SUM((CASE WHEN P.id IS NOT NULL THEN C.monto ELSE 0 END)) monto,
          (SELECT COUNT(D.id) FROM osce.documento D WHERE D.tenant_id = T.id) elaborados
      	FROM osce.tenant T
        LEFT JOIN osce.cotizacion C ON C.tenant_id = T.id AND C.elaborado_por IS NOT NULL
          AND C.propuesta_el >= DATE_TRUNC('year', NOW())
        LEFT JOIN osce.documento D ON D.id = C.documento_id AND D.finalizado_el IS NOT NULL
        LEFT JOIN osce.proyecto P ON P.cotizacion_id = C.id
        WHERE T.id = :tenant
        GROUP BY T.id
        LIMIT 100", [
        'tenant' => Auth::user()->tenant_id,
        'user'   => $id,
      ]))->first();
    }
    public static function search($term ) {
      $term = strtolower(trim($term));
      return  static::where( function ($query ) use( $term ) {
        $query->WhereRaw('LOWER(usuario) LIKE ?', ["%{$term}%"]);
      })->where('habilitado', true);
    }
    static function permitidos() {
      return static::where('habilitado', true)->where('tenant_id', Auth::user()->tenant_id)->orderBy('usuario','ASC')->get();
    }
    static function habilitados() {
      return static::where('habilitado', true)->orderBy('usuario','ASC')->get();
    }
}
