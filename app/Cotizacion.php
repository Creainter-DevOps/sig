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
use App\CandidatoOportunidad;
use App\Oportunidad;;
use Auth;

class Cotizacion extends Model
{
  use Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.cotizacion';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'tenant_id', 'cliente_id', 'contacto_id', 'oportunidad_id', 'plazo_garantia', 'plazo_instalacion', 'plazo_servicio', 'monto_base', 'monto_igv', 'monto_total',
      'descripcion','codigo','fecha','validez','empresa_id', 'observacion'
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
    ];
    public static function generarCodigo($year = null)
    {
        $year = $year ?? date('Y');
        $cod = collect(DB::select("
            SELECT COUNT(id) as cantidad
            FROM osce.cotizacion"))->first();
        return 'CR-' . $year . '-' . str_pad($cod->cantidad + 1, 4, '0', STR_PAD_LEFT);
    }
    public function log($evento, $texto) {
      Actividad::create([
        'tipo'          => 'log',
        'cotizacion_id' => $this->id,
        'evento' => $evento,
        'texto'  => $texto,
      ]);
    }
    public function timeline() {
      return $this->hasMany('App\Actividad','cotizacion_id')->orderBy('id' , 'DESC')->get();
    }

    public function rotulo(){
      return $this->codigo . ":" . $this->descripcion; 
    }
    public function folder() {
      return '\\OPORTUNIDADES\\' . $this->oportunidad()->codigo . '\\COTIZACIONES\\' . $this->codigo . '\\';
    }
    public function oportunidad() {
      return $this->belongsTo('App\Oportunidad', 'oportunidad_id')->first();
    }
    public function cliente(){
      return $this->belongsTo ('App\Cliente' ,'cliente_id' ,'id')->first();
    }
    public function empresa(){
      return $this->belongsTo('App\Empresa','empresa_id', 'id')->first();
    }
    public function contacto(){
     return $this->belongsTo ('App\Contacto', 'contacto_id', 'id')->first();
    }
    public static function search($term) {
      $term = strtolower(trim($term));
      return static::where(function($query) use($term) {
        $query->WhereRaw("LOWER(codigo) LIKE ?",["%{$term}%"])
          ->orWhereRaw("LOWER( descripcion) LIKE ?", ["%{$term}%"]);
      });
    }
}
