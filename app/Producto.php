<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
   protected $table = "osce.producto";
   const UPDATED_AT = null;
   const CREATED_AT = null;

   protected $fillable = [
      'id','empresa_id','nombre','descripcion','tipo', 'parametros', 'moneda_id',  'formula', 'precio_unidad', 'unidad', 'created_by', 'modelo', 'marca' 
   ];
     
   public static function search($term){
     $term = strtolower(trim($term));
     return static::where( function($query) use($term) {
       $query->WhereRaw("LOWER(nombre) LIKE ?", ["%{$term}%"])
         ->orWhereRaw("LOWER(tipo) LIKE ?",["%{$term}%"])
         ->orWhereRaw("LOWER(descripcion) LIKE ?", ["%{$term}"])
         ->orWhereRaw("LOWER(marca) LIKE ?", ["%{$term}"])
         ->orWhereRaw("LOWER(modelo) LIKE ?", ["%{$term}"])
         ;
     });
   }

   public static function fillUnidad(){
    return [
        'UND' => 'UND',
      ];
   }

   public static function fillTipo(){
     return [
        'S' => 'Servicio',
        'L' => 'Licencia',
        'P' => 'Producto',
      ];
   }

   public static function fillMoneda(){
      return [
        1 => 'PEN',
        2 => 'USD'
      ];
   }

   public function empresa(){
      return $this->belongsTo('App\Empresa', 'empresa_id', 'id')->first(); 
   }

}
