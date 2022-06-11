<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaEtiqueta extends Model
{
  protected $connection = 'interno';
  protected $table = 'osce.empresa_etiqueta';
    
  const UPDATED_AT = null;
  const CREATED_AT = null;
  protected $primaryKey = 'etiqueta_id';
  protected $fillable = [ 'empresa_id', 'etiqueta_id','tipo', 'tenant_id' ]; 

  public function etiqueta(){
    return $this->belongsTo('App\Etiqueta', 'etiqueta_id' );
  }
  
  public function empresa(){
    return $this->belongsTo( 'App\Empresa', 'empresa_id');
  }

  /*public static function  porEmpresa(){
    return DB::select(" select E.")
  }*/ 
}
