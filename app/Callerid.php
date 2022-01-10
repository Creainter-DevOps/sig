<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Empresa;
use App\Actividad;
class Callerid extends Model
{
     
    protected $table = 'osce.callerid';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
       'rotulo' , 'uri', 'number', 'empresa_id'
    ];

    public function empresa(){
      return $this->belongsTo('App\Empresa', 'empresa_id')->first();
    } 

    public static function search($term) {
      $term = strtolower(trim($term));
      return static::join('osce.empresa', 'osce.empresa.id', '=', 'osce.callerid.empresa_id')
      ->where(function($query) use($term) {
          $query->WhereRaw("LOWER(osce.empresa.razon_social) LIKE ?",["%{$term}%"])
            ->orWhereRaw("LOWER(osce.empresa.seudonimo) LIKE ?",["%{$term}%"])
            ->orWhereRaw("LOWER(osce.callerid.uri) LIKE ?",["%{$term}%"])
            ->orWhereRaw("LOWER(osce.callerid.number) LIKE ?",["%{$term}%"])
            ->orWhereRaw("LOWER(osce.callerid.rotulo) LIKE ?",["%{$term}%"])
          ;
      });
    }
    public function log( $evento = null, $texto = '' ){
      Actividad::create([
        'tipo'   => 'log',
        'evento' => $evento,
        'texto'  => $texto 
      ]);
    } 

}
