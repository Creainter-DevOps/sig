<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Carta extends Model
{
    protected $table = 'osce.carta';
    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'direccion' ,'orden','proyecto_id','nomenclatura','texto','estado_id', 'created_by','eliminado'
    ];
    public function proyecto() {
      return $this->belongsTo('App\Proyecto','proyecto_id')->first();
    }
    public function folder() {
      return  $this->proyecto()->folder(). 'CARTAS\\CARTA ' . str_pad($this->orden , 3, '0', STR_PAD_LEFT) .  '\\'; 
    }

    public  function orden($proyecto_id){
     $cod = collect(DB::select("
            SELECT COUNT(id) as cantidad
            FROM osce.carta 
            WHERE proyecto_id = {$proyecto_id}"))->first();
     $this->orden = $cod->cantidad + 1;
    }
    /*public function nomenclatura(){
      $this->nomenclatura = 'C' . date('Y-m') . str_pad( $this->orden, 4,'0', STR_PAD_LEFT);
    }*/

     static function fillEstados() {
      return [
        1 => 'Pendiente',
        2 => 'Progreso',
        3 => 'Listo',
      ];
    }



}
