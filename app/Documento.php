<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Helpers\Helper;

class Documento extends Model
{
    protected $connection = 'interno';
    protected $table = 'osce.documento';
    protected $primaryKey = 'id';

    const UPDATED_AT = null;
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
      'tipo','archivo','folio','es_plantilla', 'es_ordenable','rotulo','portada','created_by','formato','generado_de_id','documentos_id',
      'empresa_id','personal_id','vinculo_empresa_id','fecha_firma','fecha_desde','fecha_hasta','plazo_servicio','monto_texto','monto','fecha_acta','filename','es_reusable',
    ];
    protected $casts = [
      'es_reusable'  => 'boolean',
    ];


    public static function nuevo($data) {
      $data['created_by'] = Auth::user()->id;
      $data['tenant_id']  = Auth::user()->tenant_id;
      return static::create($data);
    }
    public static function plantillas() {
      return static::hydrate(DB::select("SELECT * FROM osce.fn_documento_plantillas(:id)", ['id' => Auth::user()->tenant_id]));
    }

    public static function recomendadas($oportunidad_id) {
      return static::hydrate(DB::select("SELECT * FROM osce.fn_documento_recomendadas(:tenant, :oportunidad)", [
        'tenant' => Auth::user()->tenant_id,
        'oportunidad' => $oportunidad_id
      ]));
    }
    public function empresa() {
      return $this->belongsTo('App\Empresa', 'empresa_id')->first();
    }

    public function vinculo_empresa() {
      return $this->belongsTo('App\Empresa', 'vinculo_empresa_id')->first();
    }
    public static function busqueda($query) {
      return static::where('rotulo','ILIKE','%'. $query . '%')->get();
    }

    public function generar_documento( $cotizacion, $data , $destino) {

     $documento = new Documento(); 
     $documento->fill($data);  
     $inputs = [];
     
     if ( !empty( $data->pesonal_id ) ) {
        $personal = Documento::find($data->personal_id);
        $inputs["PERSONAL.ID"] = $personal->nombres;
        $input["PERSONAL.DOCUMENTO"] = $personal->documento;
        $input["PERSONAL.DIRECCION"] = $personal->direccion;
     }

     //$inputs["CUSTOM.IMAGEN_HEADER"] = $data["logo_head"];
     //$inputs["CUSTOM.IMAGEN_FOOTER"] = $data["logo_footer"];
     //$inputs["CUSTOM.PADDING"] = $data["padding"];
     //$inputs["CUSTOM.MARGIN"] = $data["margin"];
     
     if (!empty($cotizacion->oportunidad()->licitacion_id)) {

       $licitacion = $cotizacion->oportunidad()->licitacion();
       $inputs["LICITACION.ID"] = $licitacion->id;
       $inputs["LICITACION.NOMENCLATURA"] = $licitacion->nomenclatura;
       $inputs["LICITACION.ENTIDAD"] = strtoupper($licitacion->empresa()->razon_social);
       $inputs["LICITACION.TIPO"] = $licitacion->tipo;
       $inputs["LICITACION.ROTULO"] = strtoupper($licitacion->rotulo);
       $inputs["LICITACION.FECHA_PROPUESTA"] = $licitacion->fecha_propuesta;
       $inputs["LICITACION.PLAZO_SERVICIO"] = $licitacion->plazo_servicio;
       
       $inputs["ROTULO"] = $data['rotulo'];
       $inputs["FECHA"] = Helper::fecha_letras($licitacion->fecha_propuesta_hasta); 
       /*$inputs["FECHA_INICIO"] = $data["fecha_inicio"];
       $inputs["FECHA_FIN"] = $data["fecha_fin"];
       $inputs["FECHA_ACTA"] = $data["fecha_acta"];
       $inputs["MONTO_NUMERO"] = $data["monto_numero"];
        */
       $inputs["MONTO_NUMERO"] = Helper::money($cotizacion->monto, $cotizacion->moneda_id);
       $inputs["MONTO_TEXTO"]  = Helper::dinero_a_texto($cotizacion->monto, $cotizacion->moneda_id);
       $inputs["MONTO_TOTAL"]  = Helper::money($cotizacion->monto, $cotizacion->moneda_id);
       $inputs["MONEDA"] = isset($data["moneda"]) ? $data["moneda"] : "SOLES";
     }

     if ( !empty( $cotizacion->empresa_id ) ) {

        $empresa = Empresa::find( $cotizacion->empresa_id ); 
        $inputs["EMPRESA.RAZON_SOCIAL"] = strtoupper($empresa->razon_social);
        $inputs["EMPRESA.RUC"] = $empresa->ruc;
        $inputs["EMPRESA.DIRECCION"] = strtoupper($empresa->direccion);
        $inputs["EMPRESA.REPRESENTANTE_NOMBRES"] = strtoupper($empresa->representante_nombres);
        $inputs["EMPRESA.REPRESENTANTE_DOCUMENTO"] = strtoupper($empresa->representante_documento);
        //$inputs["EMPRESA.IMAGEN_FIRMA"] = $empresa->imagen_firma;
        //$inputs["EMPRESA.IMAGEN_VISADO"] = $empresa->imagen_visado;
        //$inputs["EMPRESA.IMAGEN_FOOTER"] = $empresa->logo_head;
        $inputs["EMPRESA.IMAGEN_HEADER"] = $empresa->logo_head;
        $inputs["EMPRESA.SUNARP_REGISTRO"] = $empresa->sunarp_registro;
        $inputs["EMPRESA.DIRECCION"] = strtoupper($empresa->direccion);
        $inputs["EMPRESA.CORREO"] = $empresa->correo;
        $inputs["EMPRESA.TELEFONO"] = $empresa->telefono;
          
     } 
     
     if( !empty( $data['empresa_vinculada_id']) ) {

        $empresa = Empresa::find( $cotizacion->empresa_id ); 
        $inputs["EMPRESA_VINCULADA.RAZON_SOCIAL"] = $empresa->razon_social; 
        $inputs["EMPRESA_VINCULADA.RUC"] = $empresa->ruc; 
        $inputs["EMPRESA_VINCULADA.DIRECCION"] = $empresa->razon_social; 
        $inputs["EMPRESA_VINCULADA.REPRESENTANTE_NOMBRES"] = $empresa->representante_nombres; 
        $inputs["EMPRESA_VINCULADA.REPRESENTANTE_DOCUMENTO"] = $empresa->representante_documento;
        //$inputs["EMPRESA_VINCULADA.IMAGEN_FIRMA"] = $empresa->imagen_firma;
        //$inputs["EMPRESA_VINCULADA.IMAGEN_VISADO"] = $empresa->representante_documento;

     } 
     
     //$empresa = Empresa::find( $cotizacion->empresa_id );   

     //$inputs = array_merge($empresa->toArray(),$inputs); 
     $plantilla = config('constants.ruta_storage') . $this->archivo;
     //dd($plantilla);
     Helper::docx_fill_template($plantilla, $inputs, $destino);

     return  $documento;
    }
}
