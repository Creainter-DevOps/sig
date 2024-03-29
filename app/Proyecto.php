<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use App\Traits\hasFillable;
use App\Facades\DB;
use App\Empresa;
use App\CandidatoOportunidad;
use App\Actividad;
use Auth;
use App\Scopes\MultiTenant;


class Proyecto extends Model
{
  use Notifiable,HasApiTokens,HasRoles,hasFillable;

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
      'dias_servicio', 'estado_id', 'dias_garantia','dias_instalacion','tipo', 'eliminado', 'empresa_id','color','plazo_dias', 'monto','moneda_id',
      'fecha_buenapro','fecha_consentimiento','fecha_firma','fecha_desde','fecha_hasta',
      'updated_by','alias','responsable_financiero','responsable_tecnico','responsable_entregable'
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
      'estado_id' => 'integer',
      'rotulo' => 'string',
      'fecha_buenapro' => 'date',
      'fecha_consentimiento' => 'date',
      'fecha_firma' => 'date',
      'fecha_desde' => 'date',
      'fecha_hasta' => 'date',
      'monto'       => 'decimal:2',
      'moneda_id'   => 'integer',
    ];

    private function dinamicFillable() {
      return [
        'monto' => empty($this->licitacion_id),
        'fecha_buenapro' => empty($this->licitacion_id),
        'rotulo' => empty($this->licitacion_id),
      ];
    }
    public static function pagination() {
      return DB::PaginationQuery("
        SELECT
          P.*,
          T1.rotulo tipo,
          osce.empresa_rotulo(:tenant, P.empresa_id) proveedor_rotulo,
          osce.empresa_rotulo(:tenant, C.empresa_id) cliente_rotulo,
          T.rotulo estado,
          T.color estado_color,
          F1.fecha fecha_buenapro,
          F2.fecha fecha_consentimiento,
          F3.fecha fecha_perfeccionamiento,
          F3.confirmado estado_perfeccionamiento,
          F4.fecha fecha_termino,
          F4.confirmado estado_termino
        FROM osce.proyecto P
        LEFT JOIN osce.actividad_tipo T ON T.id = P.estado_id
        LEFT JOIN osce.actividad_tipo T1 ON T1.id = P.tipo_id
        LEFT JOIN osce.cotizacion CC ON CC.id = P.cotizacion_id
        LEFT JOIN osce.cliente C ON C.id = P.cliente_id
        LEFT JOIN osce.empresa CP ON CP.id = C.empresa_id
        LEFT JOIN osce.fn_proyecto_get_buenapro(P.tenant_id, P.id, :user) F1 ON TRUE
        LEFT JOIN osce.fn_proyecto_get_consentimiento(P.tenant_id, P.id, :user) F2 ON TRUE
        LEFT JOIN osce.fn_proyecto_get_perfeccionamiento(P.tenant_id, P.id, :user) F3 ON TRUE
        LEFT JOIN osce.fn_proyecto_get_culmino(P.tenant_id, P.id, :user) F4 ON TRUE
        WHERE P.tenant_id = :tenant AND P.eliminado IS FALSE
          --search AND (UPPER(P.rotulo) LIKE CONCAT('%', (:q)::text, '%') OR CP.razon_social LIKE CONCAT('%', (:q)::text, '%') OR C.nomenclatura LIKE CONCAT('%', (:q)::text, '%'))
          --filters
        ORDER BY
          --(P.estado NOT IN('concluido','cancelado')) desc,
          --array_position(ARRAY['precontrato','contrato','instalacion_inicio','desarrollo_inicio','servicio_inicio','entregables','servicio_fin','garantia_inicio'], P.estado) asc,
          P.id DESC
      ", [
        'tenant' => Auth::user()->tenant_id,
        'user'   => Auth::user()->id,
      ])
      ->hydrate('App\Proyecto');
    }
    public static function tablefy($ce) {
      return $ce->on('edit', 'estado_id', function($row) {
        return [
          'type' => 'select',
          'attrs' => [],
          'options' => [
            58 => 'PRECONTRATO',
            59 => 'CONTRATO',
            60 => 'INICIO DE INSTALACIÓN',
            61 => 'FIN DE INSTALACIÓN',
            62 => 'INICIO DE DESARROLLO',
            63 => 'FIN DE DESARROLLO',
            64 => 'INICIO DE SERVICIO',
            65 => 'FIN DE SERVICIO',
            66 => 'INICIO DE GARANTÍA',
            67 => 'FIN DE GARANTÍA',
            68 => 'CANCELADO',
            69 => 'CONCLUIDO',
          ]
        ];
      });
    }
    public static function list() {
      return static::where('eliminado', false)
      ->where('tenant_id', Auth::user()->tenant_id)
      ->orderByRaw("
        (estado NOT IN('concluido','cancelado')) desc,
        array_position(ARRAY['precontrato','contrato','instalacion_inicio','desarrollo_inicio','servicio_inicio','entregables','servicio_fin','garantia_inicio'], estado) asc,
        proyecto.id DESC");
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
      $year = date('Y', strtotime($this->created_on));
      if($unix) {
        return 'PROYECTOS/' . $year . '/' . $this->codigo . '/';
      }
      return '\\PROYECTOS\\' . $year . '\\' . $this->codigo . '\\';
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
    public function licitacion() {
      return $this->belongsTo('App\Licitacion', 'licitacion_id')->first();
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
      if(in_array(Auth::user()->id, [12,3,20])) {
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
        'desarrollo_inicio'  => array('name' => 'INICIO DE DESARROLLO', 'color' => '#2f71eb'),
        'desarrollo_fin'     => array('name' => 'FIN DE DESARROLLO', 'color' => '#193976'),
        'servicio_inicio'    => array('name' => 'INICIO DE SERVICIO', 'color' => '#7b9cdb'),
        'servicio_fin'       => array('name' => 'FIN DE SERVICIO', 'color' => '#7b9cdb'),
        'garantia_inicio'    => array('name' => 'INICIO DE GARANTÍA', 'color' => '#e78467'),
        'garantia_fin'       => array('name' => 'FIN DE GARANTÍA', 'color' => '#b14728'),
        'cancelado'          => array('name' => 'CANCELADO', 'color' => '#ed5252'),
        'concluido'          => array('name' => 'CONCLUIDO', 'color' => '#005803'),
      ];
    }
    public function fechaCalculadaConsentimiento() {
      if(empty($this->licitacion_id)) {
        return '...';
      }
      return (collect(DB::select("SELECT osce.fn_sumar_dias_habiles(:fecha, :suma) fecha", [
        'fecha' => $this->licitacion()->buenapro_fecha,
        'suma'  => 8,
      ]))->first())->fecha;
    }
    public function fechaCalculadaPerfeccionamiento() {
      if(empty($this->licitacion_id)) {
        return '...';
      }
      return (collect(DB::select("SELECT osce.fn_sumar_dias_habiles(:fecha, :suma) fecha", [
        'fecha' => $this->fecha_consentimiento,
        'suma'  => 8,
      ]))->first())->fecha;
    }
    public function meta() {
      if($this->metas === null) {
        return $this->metas = collect(DB::select("SELECT * FROM osce.obtener_detalle_proyecto(" . $this->id . ", NULL);"))->first();
      } else {
        return $this->metas;
      }
    }
    public static function requiere_atencion(&$out = null) {
      $rp = DB::collect("
        SELECT P.*, A.*, COALESCE(P.alias, P.codigo) alias
        FROM osce.fn_proyectos_atencion(:tenant, :user) A
        JOIN osce.proyecto P ON P.id = A.id", [
        'tenant' => Auth::user()->tenant_id,
        'user'   => Auth::user()->id,
      ]);
      $out = $rp->execute;
      return $rp;
    }
    protected static function booted()
    {
        static::addGlobalScope(new MultiTenant);
    }
}
