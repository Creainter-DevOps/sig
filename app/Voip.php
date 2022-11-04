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
        WHERE (C.is_inbound IS TRUE OR C.is_exten IS TRUE) AND C.tenant_id = :tenant
        ORDER BY C.nombres ASC", [
          'tenant' => Auth::user()->tenant_id
        ]));
    }
    public static function llamadas() {
      return static::hydrate(DB::select("
        SELECT LL.*, C1.nombres desde, C2.nombres hasta, C3.nombres caller
        FROM voip.llamada LL
        LEFT JOIN osce.contacto C1 ON C1.id = LL.desde_contacto_id
        LEFT JOIN osce.contacto C2 ON C2.id = LL.hasta_contacto_id
        LEFT JOIN osce.contacto C3 ON C3.id = LL.caller_contacto_id
        WHERE LL.tenant_id = :tenant
        ORDER BY LL.id DESC
        LIMIT 50", [
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
    public static function audios($asterisk_id) {
      $url  = 'http://asterisk.creainter.com.pe:8082/api/v1.0/cdr/audios';
      $data = [
        'id' => $asterisk_id,
      ];
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $res = curl_exec($ch);
      curl_close ($ch);
      return json_decode($res);
    }
}
