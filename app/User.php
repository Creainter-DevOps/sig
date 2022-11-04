<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Facades\DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,HasRoles;

    protected $table = 'public.usuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario', 'clave','tenant_id',
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
    public function getAuthPassword() {
      return $this->clave;
    }
    public function username() {
      return 'usuario';
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
    public static function perfiles($empresa_id = null, $id_usuario = null ) {
      return collect(DB::select("SELECT * FROM osce.fn_usuario_perfiles(:tenant, :id, :empresa)", [
        'tenant'  => Auth::user()->tenant_id,
        'id'      => $id_usuario == null ? Auth::user()->id :  $id_usuario ,
        'empresa' => $empresa_id,
      ]));
    }
    public static function space() {
      return ceil(((disk_total_space('/') - disk_free_space('/')) * 100) / disk_total_space('/'));
    }
    public static function perfil($id) {
      return collect(DB::select("
        SELECT
          UE.linea, UE.anexo, UE.celular, UE.cargo, UE.correo_id,
        	C.correo, C.usuario, C.clave, C.nombre, C.servidor_smtp, C.puerto_smtp, E.color_primario, E.logo_head logo
        FROM public.usuario_empresa UE
        JOIN public.usuario U ON U.id = UE.usuario_id AND U.habilitado
        JOIN osce.empresa E ON E.id = UE.empresa_id
        LEFT JOIN osce.credencial C ON C.id = UE.correo_id
        WHERE UE.id = :id AND U.tenant_id = :tenant AND U.id = :user", [
        'id'      => $id,
        'tenant'  => Auth::user()->tenant_id,
        'user'    => Auth::user()->id,
      ]))->first();
    }
    public static function estadisticas($id = null) {
      $id = $id ?? Auth::user()->id;
      return collect(DB::select("
      SELECT
	x.usuario,
	x.enviados,
	x.ganados,
	1100 sueldo_base,
	(x.enviados * 11) sueldo_enviados,
	(x.ganados * 300) sueldo_ganados,
	(x.monto * 0.0025) sueldo_monto
FROM (
	SELECT U.usuario, COUNT(C.id) enviados, COUNT(P.id) ganados, SUM((CASE WHEN P.id IS NOT NULL THEN C.monto ELSE 0 END)) monto
	FROM public.usuario U
	LEFT JOIN osce.cotizacion C ON C.propuesta_por = U.id --AND C.propuesta_el >= DATE_TRUNC('month', NOW() - INTERVAL '1' MONTH)
		AND C.propuesta_el >= DATE_TRUNC('month', NOW())
	LEFT JOIN osce.proyecto P ON P.cotizacion_id = C.id
  WHERE U.id = :id
	GROUP BY U.usuario
) x", ['id' => $id]))->first();
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
