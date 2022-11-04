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
      'es_mesa','respaldado_el','original','procesado_desde','elaborado_step',
      'revisado_por','revisado_el','revisado_status'
    ];
    protected $casts = [
      'es_reusable'  => 'boolean',
      'es_mesa'      => 'boolean',
      'revisado_status' => 'boolean',
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
    public function generar_documento($cotizacion, $data, $destino) {

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
       $inputs["LICITACION.TIPO"] = $licitacion->tipo_objeto;
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
    public static function expedientesTrabajando() {
      return collect(DB::select("
  SELECT
	D.elaborado_desde::date fecha, D.rotulo, D.id,
  D.oportunidad_id,
  D.elaborado_desde, (CASE WHEN D.elaborado_hasta IS NULL THEN CONCAT((hora(NOW() - D.elaborado_desde))::text, '...') ELSE hora(D.elaborado_hasta - D.elaborado_desde)::text END) duracion_elaborado,
  D.procesado_desde, (CASE WHEN D.procesado_desde IS NULL THEN NULL ELSE (CASE WHEN D.procesado_hasta IS NULL THEN CONCAT(hora(NOW() - D.procesado_desde)::text, '...') ELSE hora(D.procesado_hasta - D.procesado_desde)::text END) END) duracion_procesado,
  osce.fn_usuario_rotulo(D.elaborado_por) usuario,
  osce.fn_usuario_rotulo(D.revisado_por) revisado_por,
  D.revisado_status,
  D.revisado_el,
  osce.fn_usuario_rotulo(C.propuesta_por) propuesta_por
  FROM osce.documento D
  JOIN osce.oportunidad O ON O.id = D.oportunidad_id AND (O.rechazado_el IS NULL OR O.rechazado_el >= NOW() - INTERVAL '2' DAY)
  LEFT JOIN osce.cotizacion C ON C.id = D.cotizacion_id AND C.documento_id = D.id
  WHERE D.es_mesa IS TRUE AND D.elaborado_por IS NOT NULL AND D.elaborado_desde IS NOT NULL AND D.tenant_id = :tenant
    AND (D.elaborado_desde::date = NOW()::date OR D.elaborado_hasta >= NOW() - INTERVAL '12' HOUR)
ORDER BY 1 DESC, 9 DESC, 5 DESC", ['tenant' => Auth::user()->tenant_id]));
    }
    public function CompressWorkspace() {
      return 'doc-workspace-' . $this->id . '.tar.gz';
    }
    public function json_load() {
      return json_decode($this->elaborado_json, true);
    }
    public function json_save($x) {
      $this->elaborado_json = json_encode($x);
      return $this->save();
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
    public function procesarFolder(&$workspace, $escanear = true, &$metrados = []) {
      $documento = $this;
      exec('ps -A | grep -i "ProcessExpediente/' . $documento->id . '" | grep -v grep', $pids);
      if(!empty($pids)) {
        ##Otro proceso lo ha iniciado
        return false;
      }
      $folios = 0;
      $commands = [];
      $commands[] = 'echo "ProcessExpediente/' . $documento->id . '"';
      $commands[] = 'sleep 2';
      $commands[] = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';
      $commands[] = 'echo "Respaldando Carpeta..."';
      $documento->respaldarFolder($commands);
      $commands[] = '/usr/bin/php /var/www/html/interno.creainter.com.pe/util/background.php "expediente-inicio" ' . $documento->id;
      $commands[] = 'echo "Se ha iniciado el proceso..."';

      $estampados = [];

      if(!empty($workspace['addons'])) {
        foreach($workspace['addons'] as $tipo => $ns) {
          if(in_array($tipo, ['firma','visado'])) {
            foreach($ns as $ee => $cantidad) {
              if(!empty($cantidad)) {
                $temp = EmpresaFirma::porEmpresa($ee, strtoupper($tipo), $cantidad);
                if(!empty($temp)) {
                  $temp = array_map(function($n) use(&$commands, $documento) {
                    return gs_async(config('constants.ruta_storage') . $n['archivo'], $documento->folder_workspace(), $commands);
                  }, $temp);
                  if(!isset($estampados[$ee])) {
                    $estampados[$ee] = [];
                  }
                  $estampados[$ee][$tipo . '_original'] = $temp;
                }
              }
            }
          }
        }
      }
      $pedir_estampado = function($empresa_id, $tipo) use(&$estampados) {
        if(empty($estampados[$empresa_id][$tipo . '_original'])) {
          return 'NO-HAY-' . $empresa_id . '-' . $tipo;
        }
        if(empty($estampados[$empresa_id][$tipo])) {
          $estampados[$empresa_id][$tipo] = $estampados[$empresa_id][$tipo . '_original'];
        }
        return array_shift($estampados[$empresa_id][$tipo]);
      };
      $tiene_estampa = function($card, $tipo) {
        if(!empty($card['addons'])) {
          foreach($card['addons'] as $pp => $ff) {
            foreach($ff as $nn) {
              if($nn['tool'] == $tipo) {
                return true;
              }
            }
          }
        }
        return false;
      };
      $ant_repe = [];

      $workspace['paso03'] = Helper::workspace_ordenar($workspace['paso03']);
      $workspace['paso04']  = $workspace['paso03'];

      foreach($workspace['paso03'] as $key => $file) {
        if(!$file['is_part']) {
          if($tiene_estampa($file, 'firma') || $tiene_estampa($file, 'visado')) {
            $workspace['paso03'][$key] = $file;
            $input  = $file['root'];
            $output = $documento->folder_workspace() . $file['hash'] . '-%d.pdf';

            $commands[] = 'echo "Proceso de separación de PDF"';
            $commands[] = "/usr/bin/pdfseparate '" . $input . "' '" . $output . "'";

            $workspace['paso03'][$key]['root'] = range(0, $file['folio'] - 1);
            $workspace['paso03'][$key]['root'] = array_map(function($n) use ($file, $documento) {
              return $documento->folder_workspace() . $file['hash'] . '-' . ($n + 1) . '.pdf';
            }, $workspace['paso03'][$key]['root']);

          } else {
            $file['hash'] = uniqid();
            $workspace['paso03'][$key]['root'] = $file['root'];
            continue;
          }
        } else {

          $file_page = Helper::file_name(Helper::replace_extension($file['hash'], 'pdf', '-' . ($file['page'] + 1)));
//          print_r($file_page); echo "\n";
          //if(!file_exists(config('constants.ruta_temporal') . $file_page) && !in_array($file['archivo'], $ant_repe)) {
          if(!in_array($file['root'], $ant_repe)) {
            $ant_repe[] = $file['root'];
            $input  = $file['root'];
            $output = $documento->folder_workspace() . Helper::file_name(Helper::replace_extension($file['hash'], 'pdf', '-%d'));
            $commands[] = "/usr/bin/pdfseparate '" . $input . "' '" . $output . "'";
          }
          $workspace['paso03'][$key]['root'] = $documento->folder_workspace() . $file_page;
#          continue;
        }
        if(!empty($file['addons'])) {
          foreach($file['addons'] as $pp => $ff) {
            foreach($ff as $nn) {
              if(in_array($nn['tool'], ['firma','visado'])) {
                $input  = $documento->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
                $output = $documento->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
                $sello  = $pedir_estampado($nn['eid'], $nn['tool']);
                if(file_exists($input) || true) {
                  $commands[] = 'echo "Proceso de estampado de pdf"';
                  $commands[] = '/bin/estampar ' . $input . ' ' . $sello . ' ' . $nn['x'] . ' ' . $nn['y'] . " '" . $output . "'";
                  if($file['page'] == $pp && $file['is_part']) {
                    $workspace['paso03'][$key]['root'] = $output;
                  } else {
                    $workspace['paso03'][$key]['root'][$pp] = $output;
                  }
                } else {
                  $commands[] = '/bin/noexiste ' . $input;
                }
              }
            }
          }
        }
      }
     // echo "<pre>";
      //print_r($workspace['paso03']);
      //exit;

      /* Hasta este paso tenemos los pdf finales, para unir */
      $pdf_individuales_expediente = [];
      $pdf_individuales_secure = [];

      $documentos_ids = [];
      foreach($workspace['paso03'] as $key => $file) {
        $folios += $file['folio'] ?? 1;
        if(!empty($file['id'])) {
          $documentos_ids[] = $file['id'];
        } elseif(!empty($file['generado_de_id'])) {
          $documentos_ids[] = $file['generado_de_id'];
        }
        if($file['contexto'] == 'secure') {
          if(is_array($file['root'])) {
            foreach($file['root'] as $ff) {
              $pdf_individuales_secure[] = $ff;
            }
          } else {
            $pdf_individuales_secure[] = $file['root'];
          }
        } else {
          if(is_array($file['root'])) {
            foreach($file['root'] as $ff) {
              $pdf_individuales_expediente[] = $ff;
            }
          } else {
            $pdf_individuales_expediente[] = $file['root'];
          }
        }
      }
      $dir = $documento->folder_workspace();

      $output_draw   = $dir . 'PropuestaSeace.pdf';
      $output_secure = $dir . 'PropuestaSecure.pdf';


      /* Unimos los PDFs */
      $commands[] = 'echo "Uniendo los documento en PDF del EXPEDIENTE"';
      $commands[] = '/usr/bin/convert -alpha remove -density 200 -quality 100 '. implode(' ', $pdf_individuales_expediente) . ' ' . $output_draw;
      $commands[] = 'echo "Escaneando documento..."';
      $commands[] = '/usr/bin/convert -density 140 ' . $output_draw . ' -rotate 0.5 -attenuate 0.1 +noise Multiplicative -attenuate 0.01 +noise Multiplicative -sharpen 0x1.0 ' . $output_draw;
      $commands[] = 'echo "Proceso de foliación de PDF"';
      $commands[] = '/bin/pdf-foliar ' . $output_draw;
      $commands[] = "/snap/bin/gsutil -h Cache-Control:\"Cache-Control:private, max-age=0, no-transform\" cp '" . $output_draw . "' '" . config('constants.ruta_storage') . $documento->archivo . "'";

      if(!empty($pdf_individuales_secure)) {
        $commands[] = 'echo "Uniendo los documento en PDF del SECURE"';
        $commands[] = '/usr/bin/convert -alpha remove -density 200 -quality 100 '. implode(' ', $pdf_individuales_secure) . ' ' . $output_secure;
        $commands[] = 'echo "Escaneando documento..."';
        $commands[] = '/usr/bin/convert -density 140 ' . $output_secure . ' -rotate 0.5 -attenuate 0.1 +noise Multiplicative -attenuate 0.01 +noise Multiplicative -sharpen 0x1.0 ' . $output_secure;
        $commands[] = 'echo "Proceso de foliación de PDF"';
        $commands[] = '/bin/pdf-foliar ' . $output_secure;
        $commands[] = "/snap/bin/gsutil -h Cache-Control:\"Cache-Control:private, max-age=0, no-transform\"  cp '" . $output_secure . "' '" . config('constants.ruta_storage') . $documento->getAttribute('original') . "'";
      }

      $commands[] = 'echo "Eliminando directorio de trabajo: ' . $documento->folder_workspace() . '"';

      $commands[] = "/bin/rm -rf '" . $documento->folder_workspace() . "'";

      $commands[] = '/usr/bin/php /var/www/html/interno.creainter.com.pe/util/background.php "expediente-fin" ' . $documento->id;

      $commands[] = 'echo "Finalizó el proceso"';
      $commands[] = "sleep 5";


      $workspace['paso03'] = $workspace['paso04'];
      unset($workspace['paso04']);
      $documentos_ids = array_unique($documentos_ids);

      $pid = Helper::parallel_command($commands, 'expediente');
      $workspace['parallel'] = [
        'method' => 'paso04',
        'pids'   => $pid,
      ];

      $documento->filename      = Helper::replace_extension($documento->rotulo, 'pdf');
      $documento->documentos_id = '{' . implode(',', $documentos_ids) . '}';
      $documento->folio         = $folios;
      $documento->filesize      = 10000;#filesize($output_final);
      $documento->elaborado_por    = Auth::user()->id;
      $documento->es_mesa         = true;
      $documento->elaborado_hasta = DB::raw('now()');

      $workspace['documento_final'] = 'https://sig.creainter.com.pe/static/cloud/' . $documento->archivo . '?t=' . time();

      $documento->json_save($workspace);
      $metrados['folios'] = $folios;
    }
    public function log($tipo, $texto) {
      DB::select('SELECT osce.fn_documento_actividad(' . Auth::user()->tenant_id . ',' . $this->id . ', ' . Auth::user()->id . ", '" . $tipo . "', :texto)", [
        'texto' => $texto,
      ]);
    }
    public function paso($numero) {
      DB::select("SELECT osce.fn_documento_accion_paso(:tenant, :id, :user, :paso)", [
        'tenant' => Auth::user()->tenant_id,
        'id'     => $this->id,
        'user'   => Auth::user()->id,
        'paso'   => $numero,
      ]);
    }
}
