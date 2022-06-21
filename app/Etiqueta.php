<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Oportunidad;
use Auth;

class Etiqueta extends Model {
  use Notifiable,HasApiTokens,HasRoles;

  protected $connection = 'interno';
  protected $table = 'osce.etiqueta';
  const UPDATED_AT = null;
  const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id','nombre','created_on',
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

      public static function nuevo($nombre) {
        $rp = collect(DB::select("SELECT osce.etiqueta_registrar(:name) id", ['name' => $nombre]))->first();;
        return static::find($rp->id);
      }
    public static function listado() {
      $rp = DB::select("
        SELECT C.*
        FROM osce.cliente C
        LIMIT 20");
      return static::hydrate($rp);
    }

    public static function empresas() {

      return Etiqueta::selectRaw("empresa.seudonimo,etiqueta.nombre,empresa_etiqueta.tipo")
      ->leftJoin('osce.empresa_etiqueta','empresa_etiqueta.etiqueta_id','etiqueta.id') 
      ->leftJoin('osce.empresa', 'empresa.id', 'empresa_etiqueta.empresa_id')
      ->where('empresa.tenant_id', Auth::user()->tenant_id );
    }
    public function ultima_comunicacion() {
      return '';
    }
    public static function porEmpresa($empresa_id) {
      return static::where([
        ['empresa_id', '=', $empresa_id],
        ['tenant_id', '=', Auth::user()->tenant_id],
      ])->get();
    }
    public static function porEmpresaForce($empresa_id) {
      $cliente = static::porEmpresa($empresa_id);
      if(!empty($cliente) && !empty($cliente->id)) {
        return $cliente;
      }
      return Cliente::create([
        'empresa_id' => $empresa_id,
        'tenant_id'  => Auth::user()->tenant_id,
      ]);
    }
    public static function search($term) {
        $term = strtolower(trim($term));
        return static::join('osce.empresa', 'osce.empresa.id', '=', 'osce.cliente.empresa_id')
        ->where(function($query) use($term) {
            $query->WhereRaw("LOWER(osce.empresa.razon_social) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(osce.empresa.seudonimo) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(osce.empresa.ruc) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(osce.cliente.nomenclatura) LIKE ?",["%{$term}%"])
            ;
        });
    }
    public function timeline() {
      return $this->hasMany('App\Actividad','cliente_id')->orderBy('id' , 'DESC')->get();
    }
}
