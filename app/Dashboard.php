<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Facades\DB;
use App\Empresa;
use App\Actividad;
use Auth;

class Dashboard extends Model
{
     
    protected $table = null;
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
       'rotulo' , 'uri', 'numero', 'empresa_id'
    ];

    public static function competencias() {
      $file  = config('constants.internal') . 'config_' . Auth::user()->tenant_id . '.json';
      $file  = json_decode(file_get_contents($file), true);
      return $file['competencia'];
    }
    public static function actividades() {
      $file  = config('constants.internal') . 'config_' . Auth::user()->tenant_id . '.json';
      $file  = json_decode(file_get_contents($file), true);
      return $file['actividades'];
    }
    public static function usuarios_elaborados() {
      return DB::collect('SELECT * FROM osce.fn_usuario_rendimiento_fecha(:tenant, :id, :fecha)', [
        'tenant' => Auth::user()->tenant_id,
        'id'     => Auth::user()->id,
        'fecha'  => date('Y-m-d'),
      ]);
    }
}
