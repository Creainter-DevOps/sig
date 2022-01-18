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
      'usuario_id', 'oportunidad_id', 'cliente_id', 'contacto_id', 'cotizacion_id', 'entregable_id', 'proyecto_id', 'evento', 'empresa_id', 'candidato_id', 'texto', 'created_by', 'tipo', 'estado', 'importacia', 'fecha_terminado',
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
        SELECT id, tipo, fecha, fecha_limite, texto, created_by, asignado_id, supervisado_por, estado, importancia,color, tiempo_estimado, vinculado, link
        FROM osce.actividad A
        WHERE tipo <> 'log' AND (" . Auth::user()->id . " = ANY(asignado_id))
        -- OR " . Auth::user()->id . " = ANY(supervisado_por))
        AND fecha <= NOW()::date + INTERVAL '3' DAY
        AND ((A.estado = 3 AND fecha_limite >= NOW()::date) OR A.estado IN (1,2))
        ORDER BY A.vinculado ASC, fecha ASC");
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
          ->selectRaw('actividad.*, contacto.nombres contacto_nombres')
          ->leftJoin('osce.contacto','contacto.id','actividad.contacto_id')
          ->orderBy('fecha', 'DESC')->orderBy('id','DESC')->get();

      } else if(!empty($into['oportunidad_id'])) {
        return Actividad::where('oportunidad_id', '=', $into['oportunidad_id'])
          ->selectRaw('actividad.*, contacto.nombres contacto_nombres')
          ->leftJoin('osce.contacto','contacto.id','actividad.contacto_id')
          ->orderBy('fecha', 'DESC')->orderBy('id','DESC')->get();
      }

      return [];
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
        ORDER BY A.fecha ASC, A.hora ASC;");
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
