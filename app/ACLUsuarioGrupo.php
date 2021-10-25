<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ACLUsuarioGrupo extends Model
{
    protected $table = 'public.acl_usuario_grupo';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'usuario_id', 'grupo_id', 'eliminado'
    ];
    protected $hidden = [];
    protected $casts = [];

}
