<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProveedorProducto extends Model {

  protected $contection = 'interno';
  protected $table = 'osce.proveedor_producto';

  const UPDATED_AT = null ;
  const CREATED_AT = null ;

  protected $fillable = [ 
    'proveedor_id',
    'producto_id',
    'parametros',
    'monto',
    'plazo_entrega',
    'garantia',
    'moneda_id',
  ];
  function producto(){
    return $this->belongsTo('App\Producto', 'producto_id','id')->first();
  }

}


