<?php

namespace App;

use App\Persona;
use App\Actividad;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Facades\DB;

class Contacto extends Model
{
    protected $table = 'osce.contacto';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'dni' , 'nombres', 'area', 'apellidos', 'correo','area', 'celular','cliente_id','eliminado'
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
    public function log($evento, $texto = null){
      Actividad::create( [
         'tipo' => 'log',
         'contacto_id' => $this->id,
         'evento'      => $evento,
         'texto'       => $texto
       ]);
    }

    public function timeline(){
      return $this->hasMany('App\Actividad','contacto_id')->orderBy('id' , 'DESC')->get();   
    }

    public function persona() {
        return $this->belongsTo('App\Persona', 'persona_id')->first();
    }
    public function cliente() {
       return $this->belongsTo('App\Cliente', 'cliente_id')->first();
    }
    public function getCargo() {
        return 'Representante Legal';
    }
    public function NombresApellidos(){
      return $this->nombres . " " . $this->apellidos; 
    }
    public static function search( $term ) {
        $term = strtolower(trim($term));
        return static:: where(function($query) use($term) {
            $query->WhereRaw("LOWER(nombres) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(apellidos) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(celular) LIKE ?",["%{$term}%"])
            ;
        });
    }
    public static function callAutocomplete($term) {
      return static::hydrate(DB::select("SELECT * FROM osce.fn_contacto_numero_completar(:tenant, :term)", [
        'tenant' => Auth::user()->tenant_id,
        'term'   => $term,
      ]));
    }
    
}
