<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
   protected $table = "osce.producto";
   const UPDATED_AT = null;
   const CREATED_AT = null;

   protected $fillable = [
      'id','empresa_id','nombre','descripcion','tipo','parametros','formula','precio_unida','unidad','categoria_id','created_by' 
    ];

   public static function search($term){
     $term = strtolower(trim($term));
     return static::where( function($query) use($term) {
       $query->WhereRaw("LOWER(nombre) LIKE ?", ["%{$term}%"])
         ->orWhereRaw("LOWER(tipo) LIKE ?",["%{$term}%"])
         ->orWhereRaw("LOWER(descripcion) LIKE ?", ["%{$term}"])
         ;
     });
   }
}
