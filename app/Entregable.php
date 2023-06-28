<?php

namespace App;

use App\Persona;
use App\Actividad;
use App\Traits\hasFillable;
use Illuminate\Database\Eloquent\Model;
use App\Facades\DB;
use Auth;

class Entregable extends Model
{
    use hasFillable;
    protected $table = 'osce.entregable';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'fecha' ,'numero','proyecto_id','pago_id','descripcion','estado_id','fecha_desde','fecha_hasta'
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
      'estado_id'   => 'integer',
      'descripcion' => 'string',
      'numero'      => 'integer',
      'fecha'       => 'date',
    ];
    public static function pagination() {
      return DB::PaginationQuery("
        SELECT
          PP.*,
          T.rotulo estado,
          P.rotulo proyecto
        FROM osce.entregable PP
        JOIN osce.proyecto P ON P.id = PP.proyecto_id
        LEFT JOIN osce.actividad_tipo T ON T.id = PP.estado_id
        WHERE P.tenant_id = :tenant
        --search AND (UPPER(PP.descripcion) LIKE CONCAT('%', (:q)::text, '%'))
        ORDER BY (PP.fecha <= NOW() + INTERVAL '5' DAY) DESC,
        PP.fecha DESC
      ", [
        'tenant' => Auth::user()->tenant_id,
//        'user'   => Auth::user()->id,
      ])
      ->hydrate('App\Entregable');
    }
    public static function paginationPorProyecto(Proyecto $proyecto) {
      return DB::PaginationQuery("
        SELECT
          PP.*,
          T.rotulo estado,
          (SELECT COALESCE(SUM(P1.monto), 0) FROM osce.pago P1 WHERE P1.id = PP.pago_id) monto,
          P.moneda_id
        FROM osce.entregable PP
        JOIN osce.proyecto P ON P.id = PP.proyecto_id
        LEFT JOIN osce.actividad_tipo T ON T.id = PP.estado_id
        WHERE P.tenant_id = :tenant AND P.id = :proyecto
        --search AND (UPPER(PP.descripcion) LIKE CONCAT('%', (:q)::text, '%'))
        ORDER BY PP.fecha ASC, PP.numero ASC
      ", [
        'tenant' => Auth::user()->tenant_id,
        'proyecto' => $proyecto->id
      ])
      ->hydrate('App\Entregable');
    }
    public static function tablefy($ce) {
      return $ce
      ->on('edit', 'estado_id', function($pago) {
        return [
          'type' => 'select',
          'attrs' => [
            'value' => $pago->estado_id
          ],
          'options' => [
            1 => 'PENDIENTE',
            2 => 'EN PROCESO',
            3 => 'FINALIZADO',
          ]
        ];
      });
    }
    public function rotulo() {
      return 'Entregable ' . $this->numero;
    }
    public function folder($unix = false) {
      if($unix) {
        return $this->proyecto()->folder(true) . 'ENTREGABLES/ENTREGABLE ' . str_pad($this->numero , 3, '0', STR_PAD_LEFT) .  '/';
      } else {
        return $this->proyecto()->folder() . 'ENTREGABLES\\ENTREGABLE ' . str_pad($this->numero , 3, '0', STR_PAD_LEFT) .  '\\';
      }
    }
    public function log($evento, $texto = null){
      Actividad::create( [
         'tipo' => 'log',
         'contacto_id' => $this->id,
         'evento'      => $evento,
         'texto'       => $texto
       ]);
    }
    public function proyecto() {
      return $this->belongsTo('App\Proyecto', 'proyecto_id')->first();
    }
    public function pago() {
      return $this->belongsTo('App\Pago', 'pago_id')->first();
    }
    public static function registrar($data) {
      if(!empty($data['auto_cantidad'])) {
        $data['auto_dias'] = !empty($data['auto_dias']) ? $data['auto_dias'] : 30;
        for($i = 1; $i <= $data['auto_cantidad']; $i++) {
          if(!empty($data['auto_pago'])) {
            if(!isset($data['monto'])) {
              $data['monto'] = 0;
            }
            $pago = Pago::create($data);
            $data['pago_id'] = $pago->id;
          }
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
        2 => 'Presentado',
        3 => 'Conforme',
      ];
    }
}
