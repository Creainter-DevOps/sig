<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ACLGrupo extends Model
{
    protected $table = 'public.acl_grupo';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'nombre', 'descripcion'
    ];
    protected $hidden = [];
    protected $casts = [];

    public function permisos() {
        return DB::select("
            SELECT
                GP.controlador_id,
                C.rotulo as controlador,
                array_to_string(GP.permisos, ',') as permisos
            FROM public.acl_grupo_permiso GP
            JOIN public.acl_controlador C ON C.id = GP.controlador_id
            WHERE GP.grupo_id = " . $this->id . " AND GP.eliminado = 0");
    }
}

