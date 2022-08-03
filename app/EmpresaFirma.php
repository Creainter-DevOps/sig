<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class EmpresaFirma extends Model
{
    protected $connection = 'interno';
    protected $table = 'osce.empresa_firma';

    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'empresa_id','tipo','archivo','documento_id',
    ];

    public function empresa() {
      return $this->belongsTo('App\Empresa', 'empresa_id')->first();
    }
    public static function porEmpresa($empresa_id, $tipo, $limit = 12) {
      return static::where('empresa_id', '=', $empresa_id)->where('tipo','=', $tipo)->limit($limit)->orderBy('id', 'ASC')->get()->toArray();
    }
    public static function porTenant() {
      $rp = DB::select("SELECT * FROM osce.fn_empresa_obtener_firmas(:id)", ['id' => Auth::user()->tenant_id]);
      $ls = [];
      foreach($rp as $n) {
        $ls[$n->id] = $n;
      }
      return $ls;
    }
}
