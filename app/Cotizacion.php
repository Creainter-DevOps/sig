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
use App\Producto;
use App\Helpers\Helper;
use Auth;


class Cotizacion extends Model
{
  use Notifiable,HasApiTokens,HasRoles;
  
  protected $connection = 'interno';
  protected $table = 'osce.cotizacion';

  const UPDATED_AT = null;
  const CREATED_AT = null;

  public function __construct(array $data = array()) {
    $this->fill($data);
    if(!empty($data['inx_estado_participacion'])) {
      $this->inx_estado_participacion = $data['inx_estado_participacion'];
    }
    if(!empty($data['inx_estado_propuesta'])) {
      $this->inx_estado_propuesta = $data['inx_estado_propuesta'];
    }
    if(!empty($data['inx_estado_buenapro'])) {
      $this->inx_estado_buenapro = $data['inx_estado_buenapro'];
    }
  }
  public function documento() {
    return $this->belongsTo('App\Documento', 'documento_id')->first();
  }
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
      'id','empresa_id','fecha','monto','numero','duracion_meses','oportunidad_id','interes_el','interes_por','participacion_el','participacion_por','propuesta_el','propuesta_por',
      'plazo_servicio','plazo_garantia','plazo_instalacion','validez','moneda_id','observacion','terminos','seace_participacion_log','seace_participacion_fecha','seace_participacion_html','documento_id',
      'elaborado_por','elaborado_desde','elaborado_hasta','elaborado_step','elaborado_json','rotulo','notas','subtotal','igv','updated_by','elaborado_step','finalizado_por',
      'revisado_el','revisado_por','revisado_status','precio_por',
      'subsanacion_cantidad',
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
        'revisado_status' => 'boolean'
      ];
    
    public function proyecto() {
      return $this->belongsTo('App\Proyecto', 'id','cotizacion_id')->first();
    }
    public function nomenclatura() {
      return $this->oportunidad()->codigo . '-' . $this->numero;
    }
    public function codigo() {
      return $this->oportunidad()->codigo . '-' . $this->numero;
#. ': ' . substr($this->oportunidad()->rotulo(), 0, 20);
    }
    public function subsanaciones() {
      return $this->hasMany('App\Subsanacion','cotizacion_id')
        ->orderBy('id', 'asc')->get();
    }
    public function items() {
      return $this->hasMany('App\CotizacionDetalle','cotizacion_id')
        ->where('eliminado',false)
        ->orderBy('orden', 'asc')->get();
    }
    public function monto() {
      if(in_array(Auth::user()->id, [12,3,15])) {
        $m = $this->monto;
      } else {
        $m = 1;
      }
      return Helper::money($m, $this->moneda_id);
    }
    public function log($tipo, $texto) {
      DB::select('SELECT osce.fn_cotizacion_actividad(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ", '" . $tipo . "', :texto)", [
        'texto' => $texto,
      ]);
    }
    public function folder($unix = false) {
      if($unix) {
        return 'OPORTUNIDADES/' . $this->oportunidad()->codigo . '/COTIZACION-' . str_pad($this->numero, 2, '0', STR_PAD_LEFT) . '/';
      }
      return '\\OPORTUNIDADES\\' . $this->oportunidad()->codigo . '\\COTIZACION-' . str_pad($this->numero, 2, '0', STR_PAD_LEFT) . '\\';
    }
    public function rotulo() {
      $rp  = '';
      if(!empty($this->oportunidad_id)) {
        $rp = $this->oportunidad()->nomenclatura;
      }
      return substr($rp, 0, 20);
    }
    public function registrar_participacion() {
      DB::select('SELECT osce.fn_cotizacion_accion_participar(' . Auth::user()->tenant_id . ', ' . $this->id . ', ' . Auth::user()->id . ');');
#      if(empty($this->oportunidad()->fecha_participacion)) {
#        $this->oportunidad()->update([
#          'fecha_participacion' => 'NOW()',
#        ]);
#      }
    }
    public function registrar_propuesta() {
      DB::select('SELECT osce.fn_cotizacion_accion_propuesta(' . Auth::user()->tenant_id . ', ' . $this->id . ', ' . Auth::user()->id . ');');
#      DB::select('UPDATE osce.cotizacion SET propuesta_el = NOW(), propuesta_por = ' . Auth::user()->id . ' WHERE id = ' . $this->id);
#      $this->oportunidad()->log('accion', 'Ha enviado su PROPUESTA en el SEACE con la empresa ' . $this->empresa()->razon_social);
#      if(empty($this->oportunidad()->fecha_propuesta)) {
#        $this->oportunidad()->update([
#          'fecha_propuesta' => 'NOW()',
#        ]);
#      }
    }
    public function solicitudSubsanacion() {
      return collect(DB::select('SELECT * FROM osce.fn_cotizacion_accion_subsanacion(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ', NOW()::date, 1)'))->first();
    }

    public function migrateProyecto() {
      return DB::select('SELECT osce.fn_migrar_cotizacion_a_proyecto(' . Auth::user()->tenant_id . ', ' . $this->id . ', ' . Auth::user()->id . ') id;')[0]->id;
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
      $ahora = time();
      $participacion_desde = strtotime($this->oportunidad()->fecha_participacion_desde);
      $participacion_hasta = strtotime($this->oportunidad()->fecha_participacion_hasta);
      $propuesta_desde = strtotime($this->oportunidad()->fecha_propuesta_desde);
      $propuesta_hasta = strtotime($this->oportunidad()->fecha_propuesta_hasta);

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
    public function estado_participacion() {
      if(!empty($this->inx_estado_participacion)) {
        return json_decode($this->inx_estado_participacion, true);
      }
    }
    public function estado_propuesta() {
      if(!empty($this->inx_estado_propuesta)) {
        return json_decode($this->inx_estado_propuesta, true);
      }
    }
    public function estado_pro() {
      if(!empty($this->inx_estado)) {
        return json_decode($this->inx_estado, true);
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
        ->leftJoin('osce.empresa','empresa.id','oportunidad.empresa_id')
        ->leftJoin('osce.cliente', 'cliente.id','oportunidad.cliente_id')
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
    public function folder_workspace($relative = false) {
      if($relative) {
        return 'cot-workspace-' . $this->id . '/';
      } else {
        return config('constants.ruta_temporal') . 'cot-workspace-' . $this->id . '/';
      }
    }
    public function CompressWorkspace() {
      return 'cot-workspace-' . $this->id . '.tar.gz';
    }
    public function json_load() {
      return Helper::json_load('cotz-' . $this->id);
    }
    public function json_save($x) {
      return Helper::json_save('cotz-' . $this->id, $x);
    }
    public function saveItems(&$items, $empresa_id) {
      $items = array_filter($items, function($n) {
        $n['producto'] = trim($n['producto']);
        return !empty($n['producto']);
      });
      $items = array_values($items);
      if(empty($items)) {
        return false;
      }
      $subtotal = 0;
      foreach($items as $ii => $n) {
        $producto = Producto::where('nombre', '=', $n['producto'])->first();
        if(empty($producto)) {
          $producto = Producto::create([
            'nombre'      => $n['producto'],
            'empresa_id'  => $empresa_id,
            'tipo'        => 'BIEN',
            'descripcion' => $n['descripcion'],
            'moneda_id'   => 1,
          ]);
        }
        $item = CotizacionDetalle::where([
          ['cotizacion_id', '=', $this->id],
          ['orden', '=', $ii],
        ])->first();
        if(empty($item)) {
          CotizacionDetalle::create([
            'cotizacion_id' => $this->id,
            'orden'         => $ii,
            'producto_id'   => $producto->id,
            'cantidad'      => $n['cantidad'],
            'monto'         => $n['costo'],
            'descripcion'   => $n['descripcion'],
          ]);
        } else {
          $item->update([
            'producto_id'   => $producto->id,
            'cantidad'      => $n['cantidad'],
            'monto'         => $n['costo'],
            'descripcion'   => $n['descripcion'],
          ]);
        }
        $subtotal += $n['costo'] * $n['cantidad'];
      }
      static::update([
        'subtotal' => $subtotal,
        'igv'      => $subtotal * 0.18,
        'monto'    => $subtotal * 1.18
      ]);
      return true;
    }
}
