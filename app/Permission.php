<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    protected $table = null;
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [];
    protected $hidden = [];
    protected $casts = [];

    public static function usuarios()
    {
        return DB::select("
            SELECT
                U.id,
                U.usuario
            FROM public.usuario U
            ORDER BY U.usuario");
    }

    public static function grupos()
    {
        return DB::select("
        SELECT
            G.id,
            G.nombre,
            G.descripcion
        FROM public.acl_grupo G
        ORDER BY G.nombre");
    }

    public static function modulos()
    {
        return DB::select("
        SELECT
            c.id,
            CASE WHEN c.controlador_padre_id IS NOT NULL THEN 1 ELSE 0 END AS es_hijo,
            c.rotulo,
            c.link,
            array_to_string(c.permisos, ',') as permisos
        FROM public.acl_controlador c
        LEFT JOIN public.acl_controlador cp ON cp.id = c.controlador_padre_id
        ORDER BY COALESCE(cp.rotulo, c.rotulo) ASC, c.controlador_padre_id DESC, c.rotulo ASC");
    }
}

