<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\hasFillable;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use App\Facades\DB;
use App\Empresa;
use App\CandidatoOportunidad;
use App\Actividad;
use App\Proyecto;
use Auth;

class Pago extends Model
{
  use hasFillable;#Notifiable,HasApiTokens,HasRoles;

    protected $connection = 'interno';
    protected $table = 'osce.pago';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'proyecto_id','numero','fecha','descripcion','monto','movimiento_id','descripcion','moneda_id','estado_id','contenido','monto_penalidad','monto_depositado','monto_detraccion','created_by','updated_by',
      'fecha_deposito','codigo_siaf','factura_codigo',
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
      'numero'           => 'integer',
      'fecha'            => 'date',
      'fecha_deposito'   => 'date',
      'descripcion'      => 'string',
      'codigo_siaf'      => 'string',
      'estado_id'        => 'integer',
      'moneda_id'        => 'integer',
      'monto'            => 'decimal:2',
      'monto_depositado' => 'decimal:2',
      'monto_penalidad'  => 'decimal:2',
      'monto_detraccion' => 'decimal:2',
      'factura_codigo'   => 'string',
    ];

    public static function pagination() {
      return DB::PaginationQuery("
        SELECT
          PP.*,
          M.codigo moneda,
          T.rotulo estado,
          P.rotulo proyecto_rotulo,
          osce.fn_usuario_rotulo(PP.created_by) usuario
        FROM osce.pago PP
        JOIN osce.proyecto P ON P.id = PP.proyecto_id
        JOIN osce.moneda M ON M.id = PP.moneda_id
        LEFT JOIN osce.actividad_tipo T ON T.id = PP.estado_id
        WHERE P.tenant_id = :tenant
        --search AND (UPPER(PP.descripcion) LIKE CONCAT('%', (:q)::text, '%'))
        --filters
        ORDER BY (PP.fecha <= NOW() + INTERVAL '5' DAY) DESC,
        PP.fecha DESC
      ", [
        'tenant' => Auth::user()->tenant_id,
//        'user'   => Auth::user()->id,
      ])
      ->hydrate('App\Pago');
    }
    public static function paginationPorProyecto(Proyecto $proyecto) {
      return DB::PaginationQuery("
        SELECT
          PP.*,
          M.codigo moneda,
          T.rotulo estado,
          osce.fn_usuario_rotulo(PP.created_by) usuario
        FROM osce.proyecto P
        JOIN osce.pago PP ON PP.proyecto_id = P.id
        JOIN osce.moneda M ON M.id = PP.moneda_id
        LEFT JOIN osce.actividad_tipo T ON T.id = PP.estado_id
        WHERE P.tenant_id = :tenant AND P.id = :proyecto AND PP.fecha <= NOW() + INTERVAL '7' DAY
        --row AND PP.id = :id
        --search AND (UPPER(PP.descripcion) LIKE CONCAT('%', (:q)::text, '%'))
        --filters
        ORDER BY PP.fecha ASC, PP.numero ASC, PP.created_on ASC
      ", [
        'tenant' => Auth::user()->tenant_id,
//        'user'   => Auth::user()->id,
        'proyecto' => $proyecto->id
      ])
      ->hydrate('App\Pago');
    }
    public static function tablefy($ce) {
      return $ce
      ->on('edit', 'estado_id', function($pago) {
        return [
          'type' => 'select',
          'attrs' => [
            'value' => 0,#$pago->estado_id
          ],
          'options' => [
            1 => 'PENDIENTE',
            2 => 'EN PROCESO',
            3 => 'FINALIZADO',
          ]
        ];
      })
      ->on('edit', 'moneda_id', function($pago) {
        return [
          'type' => 'select',
          'attrs' => [
            'value' => $pago->moneda_id
          ],
          'options' => [
            1 => 'SOLES',
            2 => 'DOLARES'
          ]
        ];
      });
    }
    public function monto($field = 'monto') {
      if(in_array(Auth::user()->id, [12,3,15])) {
        $m = $this->{$field};
      } else {
        $m = 1;
      }
      return Helper::money($m, $this->moneda_id);
    }
    public function folder($unix = false) {
      if($unix) {
        return $this->proyecto()->folder(true) . 'PAGOS/PAGO ' . str_pad($this->numero, 3, '0', STR_PAD_LEFT) . '/';
      } else {
        return $this->proyecto()->folder() . 'PAGOS\\PAGO ' . str_pad($this->numero, 3, '0', STR_PAD_LEFT) . '\\';
      }
    }    
    public function log($evento, $texto) {
      Actividad::create([
        'oportunidad_id' => $this->id,
        'evento' => $evento,
        'texto'  => $texto,
      ]);
    }
    public function rotulo() {
      return 'Pago ' . $this->numero;
    }
    public function proyecto() {
      return $this->belongsTo('App\Proyecto', 'proyecto_id')->first();
    }
    public static function registrar($data) {
      $data['created_by'] = Auth::user()->id;
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
}
