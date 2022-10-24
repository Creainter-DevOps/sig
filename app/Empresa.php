<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cotizacion;
use App\Actividad;;
use Auth;
use App\Cliente;
use App\Licitacion;
use App\Facades\DB;

class Empresa extends Model
{
    protected $table = 'osce.empresa';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'id', 'ruc', 'razon_social', 'seudonimo', 'direccion', 'referencia','representante_nombres', 'representante_documento', 'telefono', 'correo_electronico', 'web', 'aniversario','dominio_correo','sector_id', 'categoria_id', 'es_agente_retencion','ubigeo_id','privada','logo_head','logo_central','sunarp_registro','color_primario'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
      'email_verified_at' => 'datetime',
      'privada' => 'boolean',
      ];

    public function __construct(array $data = array())
    {
      $empresa = $data;
      if(!empty($data['e_empresa_id'])) {
        $empresa['id'] = $data['e_empresa_id'];
      }
      $this->fill($empresa);
      if(!empty($data['c_cotizacion_id'])) {
        $data['id'] = $data['c_cotizacion_id'];
        $this->cotizacion = new Cotizacion($data);
      }
    }
    public function log($evento, $texto = null){
      Actividad::create( [
         'tipo' => 'log',
         'empresa_id' => $this->id,
         'evento'      => $evento,
         'texto'       => $texto
       ]);
    }
    public function rotulo() {
      if(!empty($this->seudonimo)) {
        return $this->seudonimo;
      }
      return substr($this->razon_social, 0, 100);
    }

    public function cliente() {
      return Cliente::where('empresa_id', $this->id)->where('tenant_id', Auth::user()->tenant_id)->first();
    }

    static function TipoSectores() {
      return [
          1 => 'Público',
          2 => 'Privado',
      ];
    }

    public function getSector() {
        return static::TipoSectores()[$this->sector_id];
    }

    static function TipoCategorias() {
        return [
            1 => 'Alto',
            2 => 'Medio',
            3 => 'Bajo',
        ];
    }
    public function getCategoria() {
        return static::TipoCategorias()[$this->categoria_id];
    }
    public function licitacionesActivas() {
      return Licitacion::hydrate(DB::select("
        SELECT L.*
        FROM osce.licitacion L
        WHERE L.empresa_id = :empresa AND L.buenapro_fecha IS NULL AND L.fecha_buena_hasta >= NOW() - INTERVAL '1' MONTH
        ORDER BY (L.fecha_participacion_hasta <= NOW()) ASC, L.nomenclatura DESC
      ", [
        'empresa' => $this->id,
      ]));
    }
    public function rivales() {
      return collect(DB::select("
      SELECT
        E2.id, E2.ruc, E2.razon_social, COUNT(*) cantidad, SUM(LI.monto_adjudicado) monto_adjudicado
      FROM osce.empresa E1
      JOIN osce.cotizacion C ON C.empresa_id = E1.id AND C.participacion_el IS NOT NULL AND C.propuesta_el IS NOT NULL
      JOIN osce.oportunidad O ON O.id = C.oportunidad_id AND O.licitacion_id IS NOT NULL
      JOIN osce.licitacion_item LI ON LI.licitacion_id = O.licitacion_id AND LI.empresa_id <> E1.id
      JOIN osce.empresa E2 ON E2.id = LI.empresa_id
      WHERE E1.id = :id
      GROUP BY E2.id, E2.ruc, E2.razon_social
      ORDER BY 4 DESC
      LIMIT 20", [
        'id' => $this->id,
      ]));
    }
    public function licitacionesGanadas() {
      return collect(DB::select("
      SELECT
        L.id,
        L.fecha_buena_hasta::date fecha, L.nomenclatura, osce.fn_etiquetas_a_rotulo(L.etiquetas_id) etiquetas, LI.valor_referencial, LI.monto_adjudicado, (LI.monto_adjudicado - LI.valor_referencial) utilidad
      FROM osce.licitacion_item LI
      JOIN osce.licitacion L ON L.id = LI.licitacion_id
      WHERE LI.empresa_id = :id
      ORDER BY L.fecha_buena_hasta DESC
      ", [
        'id' => $this->id
      ]));
    }
    public static function search($term) {
      $term = strtolower(trim($term));
        return static::leftJoin('osce.cliente', 'osce.cliente.empresa_id', 'osce.empresa.id')->where(function($query) use($term) {
            $query->WhereRaw("LOWER(osce.empresa.razon_social) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(osce.empresa.seudonimo) LIKE ?",["%{$term}%"])
            ;
        })->select('osce.empresa.*')->orderBy('osce.cliente.id', 'ASC');
    } 

    public static function propias() {
      return static::where('tenant_id', Auth::user()->tenant_id)->get();
    }
}
