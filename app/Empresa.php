<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CandidatoOportunidad;
use Auth;
use App\Cliente;

class Empresa extends Model
{
    protected $table = 'osce.empresa';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'id', 'ruc', 'razon_social', 'seudonimo', 'direccion', 'referencia', 'telefono', 'correo_electronico', 'web', 'aniversario', 'sector_id', 'categoria_id', 'es_agente_retencion','ubigeo_id'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
      ];

    public function __construct(array $data = array())
    {
      $empresa = $data;
      if(!empty($data['e_empresa_id'])) {
        $empresa['id'] = $data['e_empresa_id'];
      }
      $this->fill($empresa);
      if(!empty($data['c_candidato_id'])) {
        $data['id'] = $data['c_candidato_id'];
        $this->candidato = new CandidatoOportunidad($data);
      }
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

    public static  function search($term){
      $term = strtolower(trim($term));
        return static:: where(function($query) use($term) {
            $query->WhereRaw("LOWER(razon_social) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(seudonimo) LIKE ?",["%{$term}%"])
            ;
        });    
    } 
}
