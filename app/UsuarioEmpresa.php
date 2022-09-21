<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Facades\DB;
use Auth;

class UsuarioEmpresa extends Authenticatable
{
    use Notifiable,HasApiTokens,HasRoles;

    protected $table = 'public.usuario_empresa';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id','empresa_id','habilitado','linea','anexo','celular','cargo','correo_id','firma','eliminado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     *firma/
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
    public function getAuthPassword() {
      return $this->clave;
    }
    public function username() {
      return 'usuario';
    }
    public function tenants() {
      return $this->hasMany('App\Empresa', 'tenant_id', 'tenant_id')->get();
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
      return collect(DB::select("SELECT * FROM osce.fn_usuario_perfiles(:tenant, :id)", [
        'tenant'  => Auth::user()->tenant_id,
        'id'      => $id_usuario == null ? Auth::user()->id :  $id_usuario ,
      ]));
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
    
    public static function perfiles_usuario($id) {
      return collect(DB::select("
        SELECT UE.id, UE.linea, UE.anexo, UE.celular, UE.cargo, UE.correo_id,
        	C.correo, C.usuario, C.clave, C.nombre, C.servidor_smtp, C.puerto_smtp, E.seudonimo empresa, E.color_primario, E.logo_head logo
        FROM public.usuario_empresa UE
        JOIN public.usuario U ON U.id = UE.usuario_id AND U.habilitado
        JOIN osce.empresa E ON E.id = UE.empresa_id
        LEFT JOIN osce.credencial C ON C.id = UE.correo_id
        WHERE UE.eliminado is not true AND U.tenant_id = :tenant AND U.id = :user", [
        'tenant'  => Auth::user()->tenant_id,
        'user'    => $id,
      ]));
    }
    public static function search($term) {
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
