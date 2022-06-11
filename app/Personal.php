<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $connection = 'interno';
    protected $table = 'osce.personal';

    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'tenant_id','empresa_id','documento_tipo','documento_numero','nombres'
    ];

    public static function search($term){
      $term = strtolower(trim($term));
        return static::where(function($query) use($term) {
            $query->WhereRaw("LOWER(osce.personal.nombres) LIKE ?",["%{$term}%"])
            ;
        })->select('osce.personal.*')->orderBy('osce.personal.id', 'DESC');
    }
}
