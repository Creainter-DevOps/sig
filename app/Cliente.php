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
use App\CandidatoOportunidad;

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
      'nombre','slug','empresa_id',
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
      SELECT C.*
      FROM osce.candidato C
      WHERE C.cliente_id = " . $this->id);
    return CandidatoOportunidad::hydrate($rp);
  }
    public function ultima_comunicacion() {
      return '';
    }
    public static function search($term) {
        $term = strtolower(trim($term));
        return static::join('comercial.empresa', 'comercial.empresa.id', '=', 'comercial.cliente.empresa_id')
        ->select('comercial.cliente.*')
        ->where(function($query) use($term) {
            $query->WhereRaw("LOWER(comercial.empresa.razon_social) LIKE ?",["%{$term}%"])
            ->orWhereRaw("LOWER(comercial.empresa.ruc) LIKE ?",["%{$term}%"])
            ;
        });
    }
}
