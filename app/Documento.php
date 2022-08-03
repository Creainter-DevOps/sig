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
      'empresa_id','personal_id','vinculo_empresa_id','fecha_firma','fecha_desde','fecha_hasta','plazo_servicio','monto_texto','monto','fecha_acta','filename','es_reusable','tenant_id',
      'filesize','filename','directorio','oportunidad_id','cotizacion_id','licitacion_id','elaborado_json','elaborado_por','elaborado_desde','elaborado_hasta','usado',
      'es_mesa','respaldado_el','original','procesado_desde',
    ];
    protected $casts = [
      'es_reusable'  => 'boolean',
      'es_mesa'      => 'boolean',
    ];

    public static function nuevo($data) {
      $data['created_by'] = Auth::user()->id;
      $data['tenant_id']  = Auth::user()->tenant_id;
      return static::create($data);
    }

    public static function plantillas() {
      return static::hydrate(DB::select("SELECT * FROM osce.fn_documento_plantillas(:id)", ['id' => Auth::user()->tenant_id]));
    }
    public static function obtenerArchivos($path) {
      return DB::select("SELECT * FROM osce.fn_documento_get_path(:tenant, :path)", [
        'tenant' => Auth::user()->tenant_id,
        'path'   => $path,
      ]);
    }
    public function empresa() {
      return $this->belongsTo('App\Empresa', 'empresa_id')->first();
    }

    public function oportunidad() {
      return $this->belongsTo( 'App\Oportunidad', 'oportunidad_id' )->first();
    }

    public function licitacion() {
      return $this->belongsTo( 'App\Licitacion', 'licitacion_id' )->first();
    }

    public function cotizacion() {
      return $this->belongsTo( 'App\Cotizacion', 'cotizacion_id' )->first();
    }

    public function vinculo_empresa() {
      return $this->belongsTo('App\Empresa', 'vinculo_empresa_id')->first();
    }
    public function recomendadas() {
      return static::hydrate(DB::select("SELECT * FROM osce.fn_documento_recomendadas(:tenant, :referencia)", [
        'tenant' => Auth::user()->tenant_id,
        'referencia' => $this->id
      ]));
    }
    public function visitar() {
      $this->update([
        'usado' => DB::raw('usado + 1'),
      ]);
    }
    public function busqueda($query) {
      $query = strtoupper($query);
      return static::hydrate(DB::select("SELECT * FROM osce.fn_documento_busqueda(:tenant, :referencia, :texto)", [
        'tenant'     => Auth::user()->tenant_id,
        'referencia' => $this->id,
        'texto'      => $query,
      ]));
    }
    static function variables() {
      return [
        'ROTULO' => '',
        'COTIZACION.ROTULO' => '',
        'COTIZACION.NOMENCLATURA' => '',
        'COTIZACION.FECHA' =>  '',
        'COTIZACION.NOMENCLATURA' => '',
        'COTIZACION.ENTIDAD'      => '',
        'COTIZACION.DIRECCION'    => '',
        'COTIZACION.MONTO_NETO'   => '',
        'COTIZACION.DESCUENTO'    => '',
        'COTIZACION.IGV'          => '',
        'COTIZACION.MONTO_PLAZO'  => '',
        'COTIZACION.PLAZO_INSTALACION' => '',
        'COTIZACION.PLAZO_GARANTIA'    => '',
        'PERSONAL.ID'                  => '',
        'PERSONAL.DOCUMENTO'           => '',
        'PERSONAL.DIRECCION'           => '',
        'LICITACION.ID'                => '',
        'LICITACION.NOMENCLATURA'      => '',
        'LICITACION.ENTIDAD'           => '',
        'LICITACION.TIPO'              => '',
      ];
    }
    public function generar_documento( $cotizacion, $data , $destino) {

     $documento = new Documento(); 
     $documento->fill($data);  
     $inputs = [];

     if(!empty($data['rotulo'])) {
       $inputs["ROTULO"] = $data['rotulo'];
     } elseif(!empty($cotizacion->rotulo)) {
       $inputs["ROTULO"] = $cotizacion->rotulo;
     }

     if(!empty($cotizacion->rotulo) && isset($cotizacion) ) {
       $inputs['COTIZACION.ROTULO']       = $cotizacion->rotulo;
       $inputs['COTIZACION.NOMENCLATURA'] = $cotizacion->nomenclatura();
       if(!empty($cotizacion->oportunidad()->empresa_id)) {
         $inputs['COTIZACION.ENTIDAD']      = $cotizacion->oportunidad()->empresa()->razon_social;
         $inputs['COTIZACION.DIRECCION']    = $cotizacion->oportunidad()->empresa()->direccion;
       }
       $inputs['COTIZACION.FECHA']        = Helper::fecha($cotizacion->fecha);
       $inputs['COTIZACION.MONTO_NETO']   = 200;
       $inputs['COTIZACION.DESCUENTO']    = 20;
       $inputs['COTIZACION.IGV']          = 100;
       $inputs['COTIZACION.MONTO_TOTAL']  = $cotizacion->monto;
       $inputs['COTIZACION.PLAZO_INSTALACION'] = $cotizacion->plazo_instalacion;
       $inputs['COTIZACION.PLAZO_GARANTIA']    = $cotizacion->plazo_garantia;
     }


     if (!empty($data->pesonal_id)) {
        $personal = Documento::find($data->personal_id);
        $inputs["PERSONAL.ID"] = $personal->nombres;
        $input["PERSONAL.DOCUMENTO"] = $personal->documento;
        $input["PERSONAL.DIRECCION"] = $personal->direccion;
     }

     //$inputs["CUSTOM.IMAGEN_HEADER"] = $data["logo_head"];
     //$inputs["CUSTOM.IMAGEN_FOOTER"] = $data["logo_footer"];
     //$inputs["CUSTOM.PADDING"] = $data["padding"];
     //$inputs["CUSTOM.MARGIN"] = $data["margin"];
     
     if (!empty($cotizacion) && !empty($cotizacion->oportunidad()->licitacion_id)) {

       $licitacion = $cotizacion->oportunidad()->licitacion();
       $inputs["LICITACION.ID"] = $licitacion->id;
       $inputs["LICITACION.NOMENCLATURA"] = $licitacion->nomenclatura;
       $inputs["LICITACION.ENTIDAD"] = strtoupper($licitacion->empresa()->razon_social);
       $inputs["LICITACION.TIPO"] = $licitacion->tipo;
       $inputs["LICITACION.ROTULO"] = strtoupper($licitacion->rotulo);
       $inputs["LICITACION.FECHA_PROPUESTA"] = $licitacion->fecha_propuesta;
       $inputs["LICITACION.PLAZO_SERVICIO"] = $cotizacion->plazo_servicio;
      
       $inputs["FECHA"] = Helper::fecha_letras($licitacion->fecha_propuesta_hasta); 

       $inputs["FECHA_INICIO"] = @$data["fecha_inicio"];
       $inputs["FECHA_FIN"] = @$data["fecha_fin"];
       $inputs["FECHA_ACTA"] = @$data["fecha_acta"];
       $inputs["MONTO_NUMERO"] = @$data["monto_numero"];
        
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
        $inputs["EMPRESA.IMAGEN_CENTRAL"] = $empresa->logo_central;
        $inputs["EMPRESA.SUNARP_REGISTRO"] = $empresa->sunarp_registro;
        $inputs["EMPRESA.DIRECCION"] = strtoupper($empresa->direccion);
        $inputs["EMPRESA.CORREO"] = $empresa->correo_electronico;
        $inputs["EMPRESA.TELEFONO"] = $empresa->telefono;
          
     } 
     
     if ( !empty( $data['empresa_vinculada_id']) ) {

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
     $plantilla = gs(config('constants.ruta_storage') . $this->archivo);
     //dd($plantilla);
     Helper::docx_fill_template($plantilla, $inputs, $destino);

     return $documento;
    }
    public static  function search($term){
         
      $term = strtolower(trim($term));
        return static::where(function($query) use($term) {
            $query->WhereRaw("LOWER(osce.documento.tipo) LIKE ?",["%{$term}%"])
              ->orWhereRaw("LOWER(osce.documento.rotulo) LIKE ?",["%{$term}%"])
            ;
        })->select('osce.documento.*')->orderBy('osce.documento.id', 'ASC');
    }
    public function folder_workspace($relative = false) {
      if($relative) {
        return 'doc-workspace-' . $this->id . '/';
      } else {
        return config('constants.ruta_temporal') . 'doc-workspace-' . $this->id . '/';
      }
    }
    public function CompressWorkspace() {
      return 'doc-workspace-' . $this->id . '.tar.gz';
    }
    public function respaldarFolder(&$commands = null) {
      if(!file_exists($this->folder_workspace())) {
        return false;
      }
      $destino  = config('constants.ruta_storage') . 'workspace/' . $this->CompressWorkspace();
      $commands[] = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';
      $commands[] = "cd " . config('constants.ruta_temporal');
      $commands[] = "tar -zchvf '" . $this->CompressWorkspace() . "' '" . $this->folder_workspace(true) . "'";
      $commands[] = "/snap/bin/gsutil mv '" . $this->CompressWorkspace() . "' '" . $destino . "'";

      if(is_null($commands)) {
        $pid = Helper::parallel_command($commands);
      }
      $this->update([
        'respaldado_el' => DB::raw('now()'),
      ]);
      return true;
    }
    public function restaurarFolder(&$commands = null) {
      if(file_exists($this->folder_workspace())) {
        return false;
      }
      $destino = config('constants.ruta_temporal') . $this->CompressWorkspace();
      $commands[] = "cd " . config('constants.ruta_temporal');
      $commands[] = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';
      $commands[] = "/snap/bin/gsutil cp '" . config('constants.ruta_storage') . 'workspace/' . $this->CompressWorkspace() . "' '" . $destino . "'";
      $commands[] = "tar -zxvf '" . $destino . "'";
      $commands[] = "/bin/rm '" . $destino . "'";
      $pid = Helper::parallel_command($commands);
    }
    public function json_load() {
      return json_decode($this->elaborado_json, true);
    }

    public function json_save($x) {
      $this->elaborado_json = json_encode($x);
      return $this->save();
    }
}
