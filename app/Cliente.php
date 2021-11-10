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
      'empresa_id','descripcion',
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
        return $this->belongsTo('App\Empresa')->first();
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
    public static function search($term) {
        $term = strtolower(trim($term));
        return static::join('osce.empresa', 'osce.empresa.id', '=', 'osce.cliente.empresa_id')
        ->select('osce.cliente.*')
        ->where(function($query) use($term) {
            $query->WhereRaw("LOWER(osce.empresa.razon_social) LIKE ?",["%{$term}%"])
            ->orWhereRaw("LOWER(osce.empresa.ruc) LIKE ?",["%{$term}%"])
            ;
        });
    }
}
