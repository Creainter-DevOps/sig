<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Oportunidad;
use App\Actividad;
use Auth;

class Actividad extends Model
{

    protected $connection = 'interno';
    protected $table = 'osce.actividad';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'tenant_id','tipo_id','usuario_id', 'oportunidad_id', 'cliente_id', 'contacto_id', 'cotizacion_id', 'entregable_id', 'proyecto_id', 'empresa_id','texto', 'created_by','estado', 'importancia', 'fecha_terminado',
      'fecha_limite', 'asignado_id','fecha_comienzo', 'color', 'orden', 'bloque_id' , 'nombre', 'eliminado','link','direccion','realizado','fecha','hora','importancia','contenido',
      'fecha_hasta','callerid_id',
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
    public static function boot()
     {
        parent::boot();
        static::creating(function($model)
        {
            $model->created_by = Auth::user()->id;
        });
    }
    public function oportunidad(){
      return $this->belongsTo('App\Oportunidad', 'oportunidad_id', 'id')->first();
    }
    public static function usuarios() {
      return collect(DB::select("
        SELECT U.id, CONCAT('@', U.usuario) usuario
        FROM public.usuario U
        WHERE id = ANY(osce.fn_usuario_supervisados(:tenant, :user))
        ORDER BY 2 ASC", [
          'tenant' => Auth::user()->tenant_id,
          'user'   => Auth::user()->id,
        ]));
    }
    public function crear() {
      $ff = DB::select("SELECT * FROM osce.fn_oportunidad_actividad(:in_tenant_id, :in_oportunidad_id, :in_usuario_id, :in_actividad_tipo, :i_message)", [
        'in_tenant_id'      => Auth::user()->tenant_id,
        'in_oportunidad_id' => $this->oportunidad_id,
        'in_usuario_id'     => Auth::user()->id,
        'in_actividad_tipo' => $this->tipo,
        'i_message'         => $this->texto,
      ]);
      $actividad = static::where('id', $ff[0]->actividad_id)->first();
      $actividad->fill($this->toArray());
      $actividad->save();
    }
    public static  function actividad_usuario( $fecha_desde, $fecha_hasta ){
      $rpta = DB::select("
      SELECT A.created_on::DATE, U.usuario, A.tipo, COUNT(A.tipo) acciones 
      FROM osce.actividad  A
      JOIN PUBLIC.usuario U ON U.id = A.created_by
      WHERE A.created_on::date > '". $fecha_desde  . "' 
      and A.created_on::date < '". $fecha_hasta . "'  
      GROUP BY A.tipo, U.id, A.created_on::date
      ORDER BY  A.created_on::DATE DESC, U.usuario  ASC, A.tipo ASC  
      ");
      return static::hydrate($rpta);
    }
    public static function aprobadas_desaprobadas(){

      $rpta = DB::select("
      SELECT A.tipo,A.created_on::DATE,COUNT(A.tipo_id) acciones
      FROM osce.actividad  A
      WHERE (A.tipo_id = 19 OR A.tipo_id = 18) AND ( A.created_on::date >= (CURRENT_DATE - 7 ) )
      GROUP BY A.tipo_id, A.created_on::DATE,A.tipo
      ORDER BY 2 DESC, 1  ASC");

      return static::hydrate($rpta);
    }

    public static function cantidad_actividades(){
      $rpta =  DB::select("SELECT AT.tipo, COUNT(A.tipo_id) acciones
        FROM osce.actividad A
        JOIN osce.actividad_tipo AT ON AT.id = A.tipo_id
        WHERE A.created_on::date > ( CURRENT_DATE - EXTRACT(DAY FROM CURRENT_DATE)::INTEGER)  AND AT.tipo ILIKE '%LICITACION%'
        GROUP BY A.tipo_id, AT.tipo
        ");     
      return $rpta;
    } 
    
    public function creado() {
      $rp = $this->belongsTo('App\User', 'created_by')->first();
      if(!empty($rp)) {
        return strtoupper($rp->usuario);
      }
      return 'No Identificado';
    }

    public function log($evento,$texto= null ){
      Actividad::create([
        'tipo'   => 'log',
        'evento' => $evento,
        'texto'  => $texto 
      ]);
    }

    public function callerid() {
      return $this->belongsTo('App\Callerid', 'callerid_id', 'id')->first();
    }
    public function empresa(){
       return $this->belongsTo('App\Empresa', 'empresa_id', 'id')->first();
    }

    public function contacto(){
      return $this->belongsTo('App\Contacto', 'contacto_id', 'id' )->first();
    }

    public function cliente(){
      return $this->belongsTo('App\Cliente', 'cliente_id','id' )->first();
    }

    public function proyecto(){
      return $this->belongsTo('App\Proyecto', 'proyecto_id', 'id')->first();
    }
    
    public function bloque(){
      return $this->belongsTo('App\Proyecto', 'bloque_id', 'id')->first();
    }
        
    public function entregable(){
      return $this->belongsTo('App\Entregable', 'entregable_id', 'id')->first();
    }

    public function usuario() {
      $users = DB::select("SELECT U.id, U.usuario FROM osce.actividad  A 
                          JOIN public.usuario U on U.id = ANY(A.asignado_id)
                          where A.id = {$this->id}");
      $users = array_map( function($user)  {
        return $user->usuario;
      }, $users);
      return !empty($users[0]) ? $users[0] : '' ;
    }
    public function asignados() {
      $users = DB::select("SELECT U.id, U.usuario FROM osce.actividad  A
                          JOIN public.usuario U on U.id = ANY(A.asignado_id)
                          where A.id = {$this->id}");
      $users = array_map( function($user)  {
        return $user->usuario;
      }, $users);
      return implode(', ', $users);
    }
    public static function kanban() {
      return DB::select("

(
	SELECT id, estado, fecha, fecha_limite, texto, created_by, asignado_id, estado, importancia,color, tiempo_estimado, vinculado, link
	FROM osce.actividad A
	WHERE A.tenant_id = 1 AND A.estado = 1 AND (A.created_by = ANY(osce.fn_usuario_supervisados(:tenant, :user)) OR A.asignado_id && osce.fn_usuario_supervisados(:tenant, :user))
	ORDER BY A.fecha DESC
) UNION (
	SELECT id, estado, fecha, fecha_limite, texto, created_by, asignado_id, estado, importancia,color, tiempo_estimado, vinculado, link
	FROM osce.actividad A
	WHERE A.tenant_id = 1 AND A.estado = 2 AND (A.created_by = ANY(osce.fn_usuario_supervisados(:tenant, :user)) OR A.asignado_id && osce.fn_usuario_supervisados(:tenant, :user))
	ORDER BY A.fecha DESC
) UNION (
	SELECT id, estado, fecha, fecha_limite, texto, created_by, asignado_id, estado, importancia,color, tiempo_estimado, vinculado, link
	FROM osce.actividad A
	WHERE A.tenant_id = 1 AND A.estado = 3 AND (A.created_by = ANY(osce.fn_usuario_supervisados(:tenant, :user)) OR A.asignado_id && osce.fn_usuario_supervisados(:tenant, :user))
	ORDER BY A.fecha_terminado DESC
	LIMIT 30
)", [
  'tenant' => Auth::user()->tenant_id,
  'user'   => Auth::user()->id
]);
    }
    public static function search($term) {
      $term = strtolower(trim($term));
      return static:: where(function ($query )  use ($term) {
        $query->WhereRaw("LOWER(evento) LIKE ? ", ["%{$term}%"])
              ->orWhereRaw("LOWER(texto) LIKE ? ", ["%{$term}%"]);
      }); 
    }
    public function  tipo(){
      if( is_numeric( $this->tipo ) ) {
        return static::fillTipo()[$this->tipo];
      }else{
        return $this->tipo;
      }
    }

    public static function fillTipo() {
      return [   
          1 => 'Entregable' ,
          2 => 'Llamada' ,
          3 => 'Pago' 
      ];
    }
    public static function inportancia(){
      if( is_numeric($this->importancia) ){
        return static::fillImportancia()[$this->importancia]; 
      } else {
        return $this->importancia;
      }
    }
    public static function fillDireccion() {
      return [
        'SALIDA'  => 'SALIDA',
        'ENTRADA' => 'ENTRADA',
      ];
    }
    public static function fillImportancia() {
      return [   
          1 => 'Baja',
          2 => 'Media',
          3 => 'Alta' 
      ];
    }
    public static function timeline($into) {
      if(!empty($into['proyecto_id'])) {
        return Actividad::where('proyecto_id', '=', $into['proyecto_id'])
          ->selectRaw('actividad.*, contacto.nombres contacto_nombres, public.usuario.usuario')
          ->leftJoin('osce.contacto','contacto.id','actividad.contacto_id')
          ->leftJoin('public.usuario','usuario.id','actividad.created_by')
          ->orderBy('fecha', 'DESC')->orderBy('id','DESC')->get()->toArray();

     }
     else if(!empty($into['licitacion_id'])) {
        $result =  DB::select(
            'SELECT
              A.id,A.estado, A.importancia,T.tipo tipo, T.tiempo_estimado tiempo_maximo, A.tiempo_estimado tiempo_calculado, A.fecha, A.hora, U1.usuario,
              A.texto descripcion, A.created_on fecha_creacion
            FROM osce.actividad A
              JOIN osce.actividad_tipo T ON T.id = A.tipo_id
            LEFT JOIN public.usuario U1 ON U1.id = A.created_by
            WHERE A.licitacion_id = '. $into['licitacion_id'] . '
            ORDER BY A.fecha DESC, A.hora DESC, A.id DESC; '
          );
     }
     else if(!empty($into['oportunidad_id'])) {
       $result =  DB::select(
            'SELECT
              A.id,A.estado, A.importancia,T.tipo tipo, T.tiempo_estimado tiempo_maximo, A.tiempo_estimado tiempo_calculado, A.fecha, A.hora, U1.usuario,
              A.texto descripcion, A.created_on fecha_creacion
            FROM osce.actividad A
              JOIN osce.actividad_tipo T ON T.id = A.tipo_id
            LEFT JOIN public.usuario U1 ON U1.id = A.created_by
            WHERE A.oportunidad_id = '. $into['oportunidad_id'] . '
            ORDER BY A.fecha DESC, A.hora DESC, A.id DESC; '
          );

     } else {
       $result = [];
     }
      $result = array_map(function ($value) {
        return (array)$value;
      }, (array) $result);
      return $result;
    }

    public static function por_fecha_usuario($fecha, $usuario) {
      $where = [];
      if(!empty($fecha)) {
        $where[] = "A.fecha = '" . $fecha . "'";
      }
      if(!empty($usuario)) {
        $where[] = 'A.created_by = ' . (int) $usuario;
      }
      $where = !empty($where) ? ' AND ' . implode(' AND ', $where) : '';
      $query = 'SELECT
              A.id,A.estado, A.importancia,T.tipo tipo, T.tiempo_estimado tiempo_maximo, A.tiempo_estimado tiempo_calculado, A.fecha, A.hora, U1.usuario,
              A.texto descripcion, A.created_on fecha_creacion
            FROM osce.actividad A
              JOIN osce.actividad_tipo T ON T.id = A.tipo_id
            LEFT JOIN public.usuario U1 ON U1.id = A.created_by
            WHERE A.tenant_id = :tenant ' . $where . '
            ORDER BY A.fecha DESC, A.hora DESC, A.id DESC
            LIMIT 100';
      return DB::select($query, [
         'tenant' => Auth::user()->tenant_id
      ]);
    }
    public static function calendario($user_id, $desde, $hasta) {
      $user_id = !empty($user_id) ? $user_id : Auth::user()->id; 
      return DB::select("
        SELECT C.*, A.*, P.color, UPPER(COALESCE(L.rotulo,O.rotulo, P.rotulo)) descripcion
        FROM osce.obtener_actividades_de_calendario(" . $user_id . ",'" . $desde . "'::date, '" . $hasta . "'::date) C
        JOIN osce.actividad A ON A.id = C.id
        LEFT JOIN osce.proyecto P ON P.id = A.proyecto_id
        LEFT JOIN osce.oportunidad O ON O.id = A.oportunidad_id
        LEFT JOIN osce.licitacion L ON L.id = O.licitacion_id
        ORDER BY A.fecha ASC, A.hora ASC");
    }
    public static function calendario_proyectos() {
      return DB::select("
        SELECT P.id, P.codigo, P.color
        FROM osce.proyecto P
        ORDER BY P.fecha_desde DESC;");
    }

    /* Sip */
    public function voip_cdr() {
      $json = json_decode($this->resultado, true);
      return !empty($json) ? $json : [];
    }
    public function voip_dir() {
      return 'https://storage.cloud.google.com/creainter-voip/' . date('Y/m/d', strtotime($this->fecha_comienzo)) . '/';
    }
}
