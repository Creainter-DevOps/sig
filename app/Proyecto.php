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
use App\Actividad;
use Auth;

class Proyecto extends Model
{
  use Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.proyecto';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'tenant_id','cliente_id','contacto_id','oportunidad_id','cotizacion_id','nombre','codigo','nomenclatura','rotulo',
      'dias_servicio', 'estado', 'dias_garantia','dias_instalacion','tipo' ,'fecha_desde','fecha_hasta', 'eliminado', 'empresa_id'
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

    public function rotulo() {
      if(!empty($this->nombre)) {
        return $this->nombre;
      }
      if(!empty($this->oportunidad_id)) {
        return $this->oportunidad()->rotulo();
      }
      return 'xx';
    }
    public function folder() {
      return '\\PROYECTOS\\' . $this->codigo . '\\';
    }
    public static function generarCodigo($year = null)
    {
      $year = $year ?? date('Y');
      $cod = collect(DB::select("
          SELECT COUNT(id) as cantidad
          FROM osce.proyecto"))->first();
      return 'PP-' . $year . '-' . str_pad($cod->cantidad + 1, 4, '0', STR_PAD_LEFT);
    }
    public function log($evento, $texto = null ){
      Actividad::create([
        'tipo'        => 'log',
        'proyecto_id' => $this->id,
        'evento'      => $evento,
        'texto'       => $texto
      ]);   
    }

    public function empresa() {
      return $this->belongsTo('App\Empresa', 'empresa_id')->first() ?? new Empresa;
    }
    public function oportunidad() {
      return $this->belongsTo('App\Oportunidad', 'oportunidad_id')->first();
    }
    public function cliente() {
      return $this->belongsTo('App\Cliente', 'cliente_id')->first() ?? new Cliente;
    }
    public function contacto() {
      return $this->belongsTo('App\Contacto', 'contacto_id')->first();
    }
    public function cotizacion() {
      return $this->belongsTo('App\Cotizacion', 'cotizacion_id')->first();
    }
    public static  function search( $term ) {
      $term = strtolower(trim($term));
      return static::where( function ($query) use($term){
        $query->whereRaw("LOWER(nombre) LIKE ? ", [ "%{$term}%"])
          ->orWhereRaw("LOWER(codigo) LIKE ? ", ["%{$term}%"])
          ->orWhereRaw("LOWER(nomenclatura) LIKE ?", ["%{$term}%"]);
      }); 
    }
    public function entregables() {
      return $this->hasMany('App\Entregable','proyecto_id')->orderBy('numero', 'ASC')->get();
    }
    public function pagos() {
      return $this->hasMany('App\Pago','proyecto_id')->orderBy('numero', 'ASC')->get();
    }
    public function timeline() {
      return $this->hasMany('App\Actividad','proyecto_id')->orderBy('id', 'DESC' )->get(); 
    }
    public function cartas(){
      return $this->hasMany('App\Carta','proyecto_id')->orderBy('id','DESC')->get();
    }
    public function actas(){
      return $this->hasMany('App\Acta','proyecto_id')->orderBy('id','DESC')->get();
    }

}
