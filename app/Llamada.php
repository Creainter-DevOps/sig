<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Facades\DB;
use App\Empresa;
use App\Actividad;

class Llamada extends Model
{
    protected $table = 'voip.llamada';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
       'id','asterisk_id,','tenant_id','direccion','fecha','desde_numero','desde_contacto_id','hasta_numero','hasta_contacto_id','caller_numero','caller_contacto_id','speech_inmediate','speech_before','speech_after',
       'estado', 'duracion','archivo','created_by'
    ];
}
