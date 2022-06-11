<?php

namespace App;

use App\Persona;
use App\Actividad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Correo extends Model
{
    protected $table = 'osce.correo';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'asunto','correo_hasta','correo_copia','asunto','texto','contacto_id',
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

    public static function relacionados($id) {
      if(empty($id)) {
        return [];
      }
      $rp = DB::select("SELECT * FROM osce.correo WHERE id = :id OR id IN (SELECT correo_id FROM osce.correo_hilo WHERE token_id = (SELECT token_id FROM osce.correo_hilo WHERE correo_id = :id LIMIT 1))", ['id' => $id]);
      return static::hydrate($rp);
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
    
}
