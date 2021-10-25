<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class Ubigeo extends Model
{
    protected $table = 'comercial.tarifa_detalle';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'tarifa_id','programa_id','bloque_id','moneda_id','precio','dia','hora_inicio','hora_fin','estado'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function distrito($ubigeo) {
        if($ubigeo == '000000') {
            $std = new stdClass;
            $std->id = '000000';
            $std->distrito = '[Ninguno]';
            return $std;
        }
        return collect(DB::select("
            SELECT *
            FROM public.ubigeos D
            WHERE D.ubigeo = '{$ubigeo}'"))->first();
    }
    public static function departamentos($ubigeo = null) {
        $rp = DB::select("
            SELECT DISTINCT ON (coddepa) departamento as value, coddepa as id
            FROM public.ubigeos
            ORDER BY coddepa");
            $std = new stdClass;
            $std->value = '[Ninguno]';
            $std->id = '00';
            array_unshift($rp, $std);
        return $rp;
    }
    public static function provincias($ubigeo) {
        $ubigeo = substr($ubigeo, 0, 2);
        if($ubigeo == '00') {
            $std = new stdClass;
            $std->value = '[Ninguno]';
            $std->id = '0000';
            return [$std];
        }
        return DB::select("
            SELECT DISTINCT ON (codprov) provincia as value, substring(ubigeo from 1 for 4) as id
            FROM public.ubigeos
            WHERE ubigeo LIKE '" . $ubigeo . "%'
            ORDER BY codprov");
    }
    public static function distritos($ubigeo) {
        $ubigeo = substr($ubigeo, 0, 4);
        if($ubigeo == '0000') {
            $std = new stdClass;
            $std->value = '[Ninguno]';
            $std->id = '000000';
            return [$std];
        }
        return DB::select("
            SELECT DISTINCT ON (coddist) distrito as value, ubigeo as id
            FROM public.ubigeos
            WHERE ubigeo LIKE '" . $ubigeo . "%'
            ORDER BY coddist");
    }
}
