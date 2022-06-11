<?php 

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Oportunidad;
use Auth;

class Proveedor extends Model {
   
  use Notifiable,HasApiTokens,HasRoles;

  protected $connection = 'interno';
  protected $table = 'osce.proveedor';

  protected $fillable = [ 'empresa_id', 'cuentas_bacarias','observacionse'];
  
  const UPDATED_AT = null;
  const CREATED_AT = null;
  
  function empresa(){
    return $this->belongsTo('App\Empresa','empresa_id')->first();
  }

    public static function search($term) {
        $term = strtolower(trim($term));
        return static::join('osce.empresa', 'osce.empresa.id', '=', 'osce.proveedor.empresa_id')
        ->where(function($query) use($term) {
            $query->WhereRaw("LOWER(osce.empresa.razon_social) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(osce.empresa.seudonimo) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(osce.empresa.ruc) LIKE ?",["%{$term}%"])
            ;
        });
    }
    public function log($evento, $texto ) {
      Actividad::create([
         'tipo'      => 'log',
        'cliente_id' => $this->id,
        'evento'     => $evento,
        'texto'      => $texto
      ]);
    }
    
   public static function fillMoneda(){
      return [
        1 => 'PEN',
        2 => 'USD'
      ];
   }
   public static function moneda(){
     return $this->fillMoneda()[$this->moneda_id];
   }  
     
    function productos(){
     return $this->hasMany('App\ProveedorProducto','proveedor_id')->get();
    }
    /*public function timeline() {
      return $this->hasMany('App\Actividad','cliente_id')->orderBy('id' , 'DESC')->get();
    }*/
}
?>
