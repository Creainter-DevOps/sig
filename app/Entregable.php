<?php

namespace App;

use App\Persona;
use App\Actividad;
use Illuminate\Database\Eloquent\Model;

class Entregable extends Model
{
    protected $table = 'osce.entregable';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'fecha' ,'numero','proyecto_id','pago_id','descripcion','estado_id'
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
        'email_verified_at' => 'datetime',
    ];
    public function folder() {
      return $this->proyecto()->folder() . 'ENTREGABLES\\ENTREGABLE ' . str_pad($this->numero, 3, '0', STR_PAD_LEFT) . '\\';
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
        2 => 'Progreso',
        3 => 'Listo',
      ];
    }
}
