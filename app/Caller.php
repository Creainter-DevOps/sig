<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{
     
    protected $table = 'osce.callerid';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
       'rotulo' , 'uri', 'number', 'empresa_id'
    ];

    public function empresa(){
      return  $this->belongsTo('App\Empresa', 'empresa_id')->first();
    }   
}
