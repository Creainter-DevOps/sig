<?php

namespace App;

use App\Traits\hasFillable;
use Illuminate\Database\Eloquent\Model;
use App\Facades\DB;
use Auth;

class Carta extends Model
{
    use hasFillable;
    protected $table = 'osce.carta';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'fecha' ,'numero','proyecto_id','nomenclatura','rotulo','estado_id', 'created_by','eliminado','entregable_id','pago_id','acta_id','contenido',
    ];
    protected $casts = [
      'estado_id' => 'integer',
      'rotulo'    => 'string',
      'numero'    => 'integer',
      'nomenclatura' => 'string',
    ];
    public static function paginationPorProyecto(Proyecto $proyecto) {
      return DB::PaginationQuery("
        SELECT
          PP.*
        FROM osce.carta PP
        JOIN osce.proyecto P ON P.id = PP.proyecto_id
        LEFT JOIN osce.actividad_tipo T ON T.id = PP.estado_id
        WHERE P.tenant_id = :tenant AND P.id = :proyecto
        --search AND (UPPER(PP.descripcion) LIKE CONCAT('%', (:q)::text, '%'))
        ORDER BY PP.fecha DESC
      ", [
        'tenant' => Auth::user()->tenant_id,
        'proyecto' => $proyecto->id
      ])
      ->hydrate('App\Carta');
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
    public function proyecto() {
      return $this->belongsTo('App\Proyecto','proyecto_id')->first();
    }
    public function folder($unix = false) {
      if($unix) {
        return $this->proyecto()->folder(true) . 'CARTAS/CARTA ' . str_pad($this->numero , 3, '0', STR_PAD_LEFT) .  '/';
      } else {
        return $this->proyecto()->folder() . 'CARTAS\\CARTA ' . str_pad($this->numero , 3, '0', STR_PAD_LEFT) .  '\\'; 
      }
    }
    public function entregable() {
      return $this->belongsTo('App\Entregable', 'entregable_id', 'id')->first();
    }
    public function pago() {
      return $this->belongsTo('App\Pago', 'pago_id', 'id')->first();
    }
    public function acta() {
      return $this->belongsTo('App\Acta', 'acta_id', 'id')->first();
    }

    public  function orden($proyecto_id){
     $cod = collect(DB::select("
            SELECT COUNT(id) as cantidad
            FROM osce.carta 
            WHERE proyecto_id = {$proyecto_id}"))->first();
     $this->numero = $cod->cantidad + 1;
    }
    /*public function nomenclatura(){
      $this->nomenclatura = 'C' . date('Y-m') . str_pad( $this->orden, 4,'0', STR_PAD_LEFT);
    }*/
    public function estado() {
      return static::fillEstados()[$this->estado_id];
    }
     static function fillEstados() {
      return [
        1 => 'Pendiente',
        2 => 'Progreso',
        3 => 'Listo',
      ];
    }



}
