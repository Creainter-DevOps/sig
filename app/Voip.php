<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Facades\DB;
use App\Empresa;
use App\Actividad;
use Auth;

class Voip extends Model
{
     
    protected $table = null;
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
       'rotulo' , 'uri', 'numero', 'empresa_id'
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
    public static function habilitados() {
      return static::hydrate(DB::select("
        SELECT C.*
        FROM osce.contacto C
        WHERE C.is_outbound IS TRUE AND C.tenant_id = :tenant
        ORDER BY C.nombres ASC", [
          'tenant' => Auth::user()->tenant_id
        ]));
    }
    public static function destinatarios() {
      return static::hydrate(DB::select("
        SELECT C.*
        FROM osce.contacto C
        WHERE C.is_inbound IS TRUE OR C.is_exten IS TRUE AND C.tenant_id = :tenant
        ORDER BY C.nombres ASC", [
          'tenant' => Auth::user()->tenant_id
        ]));
    }
    public function log( $evento = null, $texto = '' ){
      Actividad::create([
        'tipo'   => 'log',
        'evento' => $evento,
        'texto'  => $texto 
      ]);
    } 

}
