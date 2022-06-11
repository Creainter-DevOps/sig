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

class Cliente extends Model {
  use Notifiable,HasApiTokens,HasRoles;

  protected $connection = 'interno';
  protected $table = 'osce.cliente';
  const UPDATED_AT = null;
  const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id','empresa_id','nomenclatura',
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
     public function empresa() {
        return $this->belongsTo('App\Empresa')->first() ?? new Empresa;
     }
    public function rotulo() {
        return $this->empresa()->rotulo();
    }
     public function cotizaciones(){
       return $this->hasMany('App\Cotizacion', 'cliente_id', 'id');  
     }
    public function contactos() {
        return $this->hasMany('App\Contacto')->get();
    }
    public function getContactos() {
        return $this->hasMany('App\Contacto')->get();
    }
    public static function listado() {
      $rp = DB::select("
        SELECT C.*
        FROM osce.cliente C
        LIMIT 20");
      return static::hydrate($rp);
    }
  public function oportunidades() {
    $rp = DB::select("
      SELECT O.*
      FROM osce.licitacion L
      JOIN osce.oportunidad O ON O.licitacion_id = L.id AND O.tenant_id = " . Auth::user()->tenant_id . " AND O.aprobado_el IS NOT NULL
      WHERE L.empresa_id = " . $this->empresa_id . " AND L.eliminado IS NULL
      ORDER BY L.id DESC");
    return Oportunidad::hydrate($rp);
  }
    public function ultima_comunicacion() {
      return '';
    }
    public static function porEmpresa($empresa_id) {
      return static::where([
        ['empresa_id', '=', $empresa_id],
        ['tenant_id', '=', Auth::user()->tenant_id],
      ])->first();
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
    public function log($evento, $texto ) {
      Actividad::create([
         'tipo'      => 'log',
        'cliente_id' => $this->id,
        'evento'     => $evento,
        'texto'      => $texto
      ]);
    }
    public function timeline() {
      return $this->hasMany('App\Actividad','cliente_id')->orderBy('id' , 'DESC')->get();
    }
}
