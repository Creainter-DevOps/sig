<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Empresa;
use App\CandidatoOportunidad;
use App\Actividad;
use Auth;

class Orden extends Model
{
  use Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.orden';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'proyecto_id','numero','fecha','descripcion','monto','movimiento_id','descripcion','moneda_id','estado_id','tipo','contenido','entregable_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];
    public function monto() {
      if(in_array(Auth::user()->id, [12,3,15])) {
        $m = $this->monto;
      } else {
        $m = 1;
      }
      return Helper::money($m, $this->moneda_id);
    }
    public function folder() {
      return $this->proyecto()->folder() . 'GASTOS\\GASTO ' . str_pad($this->numero, 3, '0', STR_PAD_LEFT) . '\\';
    }    
    public function log($evento, $texto) {
      Actividad::create([
        'oportunidad_id' => $this->id,
        'evento' => $evento,
        'texto'  => $texto,
      ]);
    }
    public function rotulo() {
      return 'Orden ' . $this->numero;
    }
    public function proyecto() {
      return $this->belongsTo('App\Proyecto', 'proyecto_id')->first();
    }
    public static function registrar($data) {
      if(!empty($data['auto_cantidad'])) {
        $data['auto_dias'] = !empty($data['auto_dias']) ? $data['auto_dias'] : 30;
        for($i = 1; $i <= $data['auto_cantidad']; $i++) {
          static::create($data);
          $data['fecha'] = date('Y-m-d', strtotime($data['auto_dias'] == 30 ? '+1 month' : '+' . $data['auto_dias'] . ' days', strtotime($data['fecha'])));
        }
      } else {
        static::create($data);
      }
    }
    public static function search($term) {
        $term = strtolower(trim($term));
        return static::where(function($query) use($term) {
            $query->WhereRaw("LOWER(numero::text) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(descripcion) LIKE ?",["%{$term}%"])
            ;
        });
    }
     public function estado() {
      return static::fillEstados()[$this->estado_id];
    }
    static function fillEstados() {
      return [
        1 => 'Pendiente',
        2 => 'Emitida',
        3 => 'Depositado',
      ];
    }
    public function monedaArray() {
      return static::selectMonedas()[$this->moneda_id];
    }
    static function selectMonedas() {
      return [
        1 => 'Soles',
        2 => 'Dolares',
      ];
    }
    public function render_tipo() {
      return @static::selectTipos()[$this->tipo];
    }
    static function selectTipos() {
      return [
        'OC' => 'ORDEN DE COMPRA',
        'OS' => 'ORDEN DE SERVICIO',
      ];
    }
}
