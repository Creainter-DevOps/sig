<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    
    protected $connection = 'interno';
    protected $table = 'osce.documento';

    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id', 'tipo','archivo','folio','es_plantilla', 'es_ordenable','rotulo','portada'  
    ];

}
