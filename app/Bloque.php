<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Bloque extends Model
{
    protected $connection = 'interno';
    protected $table = 'osce.bloque';

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [ 'id' , 'proyecto_id','orden', 'nombre', 'eliminado','created_by','eliminado'];

    public function empresa(){
        return belongsTo('App\Proyecto', 'Proyecto');
    }

    public  function orden(){
     $cod = collect(DB::select("
            SELECT COUNT(id) as cantidad
            FROM osce.bloque"))->first();
     $this->orden = $cod->cantidad + 1;
    } 
    public function item(){
      return $this->hasMany('App\Actividad', 'bloque_id','id' )->where('eliminado', false )  ;
    }
    public function actividades(){
      return $this->hasMany('App\Actividad', 'bloque_id','id' );
    }

    public static function search ($term ){
      $term = strtolower($term);
      return static::where(function($query) use ($term){
        $query->whereRaw('LOWER(nombre) LIKE ?',["%{$term}%"]);
      });
    }

}
