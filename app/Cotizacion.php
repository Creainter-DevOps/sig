<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Oportunidad;
use App\Helpers\Helper;
use Auth;


class Cotizacion extends Model
{
  use Notifiable,HasApiTokens,HasRoles;
  
  protected $connection = 'interno';
  protected $table = 'osce.cotizacion';
  const UPDATED_AT = null;
  const CREATED_AT = null;


  public function oportunidad() {
    return $this->belongsTo('App\Oportunidad', 'oportunidad_id')->first();
  }
  public function licitacion() {
    return $this->oportunidad()->belongsTo('App\Licitacion', 'licitacion_id')->first();
  }
  public function empresa() {
    return $this->belongsTo('App\Empresa', 'empresa_id')->first();
  }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','empresa_id','fecha','monto','monto_propuesto','duracion_meses','rotulo','oportunidad_id','interes_el','interes_por','participacion_el','participacion_por','propuesta_el','propuesta_por',
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


    public function proyecto() {
      return $this->belongsTo('App\Proyecto', 'id','cotizacion_id')->first();
    }
    public function codigo() {
      return $this->oportunidad()->codigo . '-' . $this->numero;
    }
    public function monto() {
      if(in_array(Auth::user()->id, [1,3,15])) {
        $m = $this->monto;
      } else {
        $m = 1;
      }
      return Helper::money($m, 1);
    }
    public function folder() {
      return '\\OPORTUNIDADES\\' . $this->oportunidad()->codigo . '\\COTIZACIONES\\' . str_pad($this->numero, 3, '0', STR_PAD_LEFT) . '\\';
    }
    public function rotulo() {
      if(!empty($this->rotulo)) {
        return $this->rotulo;
      }
//      $rp  = trim($this->rotulo);
//      if(empty($rp)) {
        $rp = $this->oportunidad()->nomenclatura;
//      }
      return substr($rp, 0, 20);
    }
    public function registrar_participacion() {
      DB::select('UPDATE osce.cotizacion SET participacion_el = NOW(), participacion_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->oportunidad()->log('accion', 'Ha registrado su PARTICIPACIÓN en el SEACE con la empresa ' . $this->empresa()->razon_social);
      if(empty($this->oportunidad()->fecha_participacion)) {
        $this->oportunidad()->update([
          'fecha_participacion' => 'NOW()',
        ]);
      }
    }
    public function registrar_propuesta() {
      DB::select('UPDATE osce.cotizacion SET propuesta_el = NOW(), propuesta_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
      $this->oportunidad()->log('accion', 'Ha enviado su PROPUESTA en el SEACE con la empresa ' . $this->empresa()->razon_social);
      if(empty($this->oportunidad()->fecha_propuesta)) {
        $this->oportunidad()->update([
          'fecha_propuesta' => 'NOW()',
        ]);
      }
    }
    public function timeline() {
      return $this->hasMany('App\Actividad','cotizacion_id')->orderBy('id', 'desc')->get();
    }
    public function margen() {
      return Helper::money(!empty($this->monto_base) ? ($this->monto_propuesto - $this->monto_base) * 100 / $this->monto_propuesto : 0) . '%';
    }
    public function mensualidad() {
      if(!empty($this->duracion_meses)) {
        return Helper::money($this->monto_propuesto / $this->duracion_meses);
      }
      return 'No existe duración';
    } 
    public function cronograma() {
      return $this->oportunidad()->cronograma();
    }
    public function estado() {
//      dd($this->oportunidad());
      $ahora = time();
      $participacion_desde = strtotime($this->licitacion()->fecha_participacion_desde);
      $participacion_hasta = strtotime($this->licitacion()->fecha_participacion_hasta);
      $propuesta_desde = strtotime($this->licitacion()->fecha_propuesta_desde);
      $propuesta_hasta = strtotime($this->licitacion()->fecha_propuesta_hasta);

      if($ahora >= $propuesta_hasta) {
        if(!empty($this->propuesta_el)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'ENVIADO',
          ];
        } else {
          return [
            'timeout' => true,
            'status' => false,
            'class' => 'badge badge-light-danger',
            'message' => 'TIMEOUT1',
          ];
        }
      } elseif($ahora >= $propuesta_desde) {
        if(!empty($this->propuesta_el)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'ENVIADO',
          ];
        } if(!empty($this->participacion_el)) {
          return [
            'timeout' => false,
            'status' => false,
            'class' => 'badge badge-light-warning',
            'message' => 'PROPUESTA',
          ];
        } else {
          return [
            'timeout' => true,
            'status' => false,
            'class' => 'badge badge-light-danger',
            'message' => 'TIMEOUT2',
          ];
        }

      } elseif($ahora >= $participacion_hasta) {
        if(!empty($this->participacion_el)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'REGISTRADO',
          ];
        } else {
          return [
            'timeout' => true,
            'status' => false,
            'class' => 'badge badge-light-danger',
            'message' => 'TIMEOUT3',
          ];
        }
      } elseif($ahora >= $participacion_desde) {
        if(!empty($this->participacion_el)) {
          return [
            'timeout' => false,
            'status' => true,
            'class' => 'badge badge-light-success',
            'message' => 'REGISTRADO',
          ];
        } else {
          return [
            'timeout' => false,
            'status' => false,
            'class' => 'badge badge-light-warning',
            'message' => 'PARTICIPACIÓN',
          ];
        }
      } else {
        return [
          'timeout' => false,
          'status' => true,
          'class' => 'badge badge-light-secondary',
          'message' => 'ESPERANDO',
        ];
      }
    }
    public static function visible() {
      return static::select('osce.cotizacion.*')
        ->join('osce.oportunidad', 'oportunidad.id','cotizacion.oportunidad_id')
        ->leftJoin('osce.empresa','empresa.id', 'oportunidad.empresa_id')
        ->whereRaw('osce.oportunidad.licitacion_id IS NULL');
    }
    public static function search($query) {
      $query = strtolower($query);
      return static::join('osce.oportunidad', 'oportunidad.id','cotizacion.oportunidad_id')
        ->leftJoin('osce.empresa','empresa.id', 'oportunidad.empresa_id')
        ->leftJoin('osce.licitacion','licitacion.id','oportunidad.licitacion_id')
        ->where(function($r) use($query) {
          $r->orWhereRaw("LOWER(empresa.razon_social) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(empresa.seudonimo) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.descripcion) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(oportunidad.rotulo) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(oportunidad.codigo) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.nomenclatura) LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("licitacion.procedimiento_id::text LIKE ? ", ["%{$query}%" ])
          ->orWhereRaw("LOWER(licitacion.descripcion) LIKE ? ", ["%{$query}%" ]);
      });
    }
}
