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
  private $metas = null;
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'tenant_id','cliente_id','contacto_id','oportunidad_id','cotizacion_id','nombre','codigo','nomenclatura','rotulo',
      'dias_servicio', 'estado', 'dias_garantia','dias_instalacion','tipo' ,'fecha_consentimiento','fecha_firma','fecha_desde','fecha_hasta', 'eliminado', 'empresa_id','color',
      'updated_by','alias'
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
    public static function list() {
      return static::where( 'eliminado', false )
      ->where('tenant_id', Auth::user()->tenant_id)
      ->orderBy('created_on', 'desc');
    }
    public function rotulo() {
      if(!empty($this->nombre)) {
        return $this->nombre;
      }
      if(!empty($this->oportunidad_id)) {
        return $this->oportunidad()->rotulo();
      }
      return 'xx';
    }
    public function folder($unix = false) {
      if($unix) {
        return 'PROYECTOS/' . $this->codigo . '/';
      }
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
      return $this->cotizacion()->oportunidad();
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
        $query->whereRaw("LOWER(rotulo) LIKE ? ", [ "%{$term}%"])
          ->orWhereRaw("LOWER(codigo) LIKE ? ", ["%{$term}%"])
          ->orWhereRaw("LOWER(nomenclatura) LIKE ?", ["%{$term}%"]);
      }); 
    }
    public static function activos() {
      return DB::select("
        SELECT P.id, P.codigo, CONCAT(TO_CHAR(P.created_on, 'YYYY'), ': ', COALESCE(P.alias, CONCAT(C.nomenclatura, ': ', SUBSTRING(P.rotulo, 1, 40)))) rotulo
        FROM osce.proyecto P
        LEFT JOIN osce.cliente C ON C.id = P.cliente_id
        WHERE P.estado NOT IN ('concluido','cancelado') AND P.eliminado IS FALSE AND P.tenant_id = :tenant
        ORDER BY P.created_on DESC;
      ", ['tenant' => Auth::user()->tenant_id]);
    }
    public function entregables() {
      return $this->hasMany('App\Entregable','proyecto_id')->orderBy('numero', 'ASC')->get();
    }
    public function pagos() {
        return $this->hasMany('App\Pago','proyecto_id')->orderBy('numero', 'ASC')->get();
      return [];
    }
    public function ordenes() {
      if(in_array(Auth::user()->id, [12,3])) {
        return $this->hasMany('App\Orden','proyecto_id')->orderBy('fecha', 'ASC')->get();
      }
      return [];
    }
    public function timeline() {
      return $this->hasMany('App\Actividad','proyecto_id')->orderBy('id', 'DESC' )->get(); 
    }
    public function cartas(){
      return $this->hasMany('App\Carta','proyecto_id')->orderBy('numero','ASC')->get();
    }
    public function actas(){
      return $this->hasMany('App\Acta','proyecto_id')->orderBy('orden','ASC')->get();
    }
    public function estadoArray() {
      return static::selectEstados()[$this->estado];
    }
    static function selectEstados() {
      return [
        'precontrato'        => array('name' => 'PRECONTRATO', 'color' => '#c3c3c3'),
        'contrato'           => array('name' => 'CONTRATO', 'color' => '#666565'),
        'instalacion_inicio' => array('name' => 'INICIO DE INSTALACIÓN', 'color' => '#6cc529'),
        'instalacion_fin'    => array('name' => 'FIN DE INSTALACIÓN', 'color' => '#c77e10'),
        'servicio_inicio'    => array('name' => 'INICIO DE SERVICIO', 'color' => '#2f71eb'),
        'servicio_fin'       => array('name' => 'FIN DE SERVICIO', 'color' => '#193976'),
        'garantia_inicio'    => array('name' => 'INICIO DE GARANTÍA', 'color' => '#e78467'),
        'garantia_fin'       => array('name' => 'FIN DE GARANTÍA', 'color' => '#b14728'),
        'cancelado'          => array('name' => 'CANCELADO', 'color' => '#ed5252'),
        'concluido'          => array('name' => 'CONCLUIDO', 'color' => '#005803'),
      ];
    }
    public function meta() {
      if($this->metas === null) {
        return $this->metas = collect(DB::select("SELECT * FROM osce.obtener_detalle_proyecto(" . $this->id . ", NULL);"))->first();
      } else {
        return $this->metas;
      }
    }
}
