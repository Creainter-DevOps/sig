<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ACLUsuario extends Model
{
    protected $table = 'public.usuario';
    protected $primaryKey = 'id';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'rotulo', 'link', 'permisos'
    ];
    protected $hidden = [];
    protected $casts = [
    ];
    public function permisos() {
        return DB::select("
            SELECT
                UG.grupo_id
            FROM public.acl_usuario_grupo UG
            WHERE UG.usuario_id = " . $this->id . " AND UG.eliminado = 0");
    }
}
