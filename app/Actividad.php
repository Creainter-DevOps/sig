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
      'usuario_id', 'oportunidad_id', 'cliente_id', 'contacto_id', 'cotizacion_id', 'proyecto_id', 'evento', 'empresa_id', 'candidato_id', 'texto', 'created_by', 'tipo'
       ,'fecha_limite', 'asignado_id','fecha_comienzo', 'color', 'orden', 'bloque_id' , 'nombre', 'eliminado'
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
    public function empresa( $evento ){
       return $this->belongsTo('App\Empresa', 'empresa_id', 'id' );
    }
    public function usuario() {
      $rpt = $this->belongsTo('App\User', 'asignado_id')->first();
      return isset($rpt) ? $rpt->usuario : '' ;
    }

    public static function search($term){
      $term = strtolower(trim($term));

      return static:: where(function ($query )  use ($term){
        $query->WhereRaw("LOWER(evento) LIKE ? ", ["%{$term}%"])
              ->orWhereRaw("LOWER(texto) LIKE ? ", ["%{$term}%"]);    
      }); 
    }
}
