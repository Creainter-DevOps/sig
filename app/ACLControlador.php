<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ACLControlador extends Model
{
    protected $table = 'public.acl_controlador';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'rotulo', 'link', 'permisos','controlador_padre_id'
    ];
    protected $hidden = [];
    protected $casts = [
    ];

    public function padre() {
        return $this->belongsTo('App\ACLControlador','controlador_padre_id')->first();
    }

    public function rotulo() {
        return $this->rotulo;
    }

}
