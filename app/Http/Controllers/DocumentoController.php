<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Documento;
use App\EmpresaFirma;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Cotizacion;

use Auth;

class DocumentoController extends Controller {

  protected $viewBag = [];
  
  public function __construct() {
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/documentos", "name" => "Documentos" ]
    ];
  }
   
  public function index( Request $request ) {
    $search = $request->input('search');
    if(!empty($search)){
      $listado = Documento::search($search)->paginate(15)->appends(request()->query());
    } else {
      $listado = Documento::orderBy( 'id', 'desc')->paginate(15)->appends(request()->query());
    }
    $this->viewBag['listado'] = $listado;
    return view('documento.index', $this->viewBag  );
  }

  public function show( Request $request, Documento $documento ) {
     $breadcrumbs[] = [ 'name' => "Detalle Documento" ];
     return view( 'documento.show'  , compact('documento','breadcrumbs'));
  }
  
  public function create(Request $request, Documento $documento) {

    $this->viewBag['documento'] = new Documento(); 
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Nuevo Documento" ];
    if($request->ajax()) {
      return view( 'documento.fast', [ 'documento' => $documento ]);
    }
    return view('documento.add', $this->viewBag );

  }

  public function form_nuevo(Request $request, Documento $documento ) {

    $expediente_id = $request->get('expediente_id');
    $orden = $request->get('orden');

    $plantilla = null;

   if(!empty($expediente_id)) {
     $expediente = Documento::find($expediente_id);
   }

   if(!empty($request->get("generado_de_id"))) {
     $plantilla = Documento::find($request->get("generado_de_id"));
     $plantilla->generado_de_id = $request->get("generado_de_id");

     $documento = new Documento();
     $documento->fill($plantilla->toArray());
   }

   return view('documento.form', compact('plantilla','documento','orden','expediente','expediente_id'));

  }

  public function visualizar_documento(Request $request, Documento $documento) {
      $workspace = $documento->json_load();
      $cid = $request->get('cid');
      $card = $workspace['paso03'][$cid];
      return view('documento.imagen', compact('documento', 'card', 'cid'));   
  }

  public function crearExpediente(Request $request) {

    $path = $request->input('path');
    $name = $request->input('name');
    $oid  = $request->input('oid');

    $data['es_plantilla'] = false;
    $data['archivo']      = null;
    $data['formato']      = 'PDF';
    $data['folio']        = 0;
    $data['rotulo']       = $name;
    $data['filename']     = $name;
    $data['filesize']     = 0;
    $data['directorio']   = trim($path, '/');
    $data['tipo']         = 'EXPEDIENTE';
    $data['oportunidad_id'] = $oid;
    $data['elaborado_desde'] = DB::raw('now()');

    Documento::nuevo($data);

    return response()->json([
      'status' => true,
    ]);
  }

  public function expediente_inicio( Request $request, Documento $documento ) {

      $licitacion = $documento->licitacion();
      $validaciones = [];   
      /*$logo_header = config('constants.ruta_storage') . $empresa->logo_header;
      $logo_central = config('constants.ruta_storage') . $empresa->logo_central;

      $firma = EmpresaFirma::porEmpresa( $cotizacion->empresa_id, 'FIRMA');
      $visado = EmpresaFirma::porEmpresa( $cotizacion->empresa_id, 'VISADO');

      if (gs_exists($logo_central) || gs_exists($logo_header)) {
        $validaciones['empresa_logos'] = true;
      }
      if (!empty($firma) && !empty($visado) ){
        $validaciones['sellos_firmas'] = true;          
      }
      if (!empty($empresa->representante_nombres ) &&  !empty($empresa->representante_documento) ){
        $validaciones['representante'] = true;  
      }
      dd($cotizacion);
      if ( !empty( $cotizacion->monto) && !empty($cotizacion->moneda_id)){
        $validaciones['montos'] = true;
      }*/  
      return view('documento.inicio', compact('documento', 'validaciones'));

  }
  public function expediente_inicio_store(Request $request, Documento $documento ){
         
      $documento->elaborado_por   = Auth::user()->id;
      $documento->elaborado_desde = DB::raw('now()');
      $documento->save();

      return redirect('/documentos/'. $documento->id . '/expediente/paso01');
  }
  
  /*public function expediente( Request $request, Documento $documento ) {
    $workspace = $documento->json_load();
    return view('documento.expediente', compact('workspace','documento'));
    }*/

  public function expediente_paso01( Request $request, Documento $documento){
    $workspace = $documento->json_load();
    return view('documento.expediente', compact('workspace','documento'));
  }

  public function expediente_paso02( Request $request, Documento $documento){
    $workspace = $documento->json_load();
    return view('documento.paso02', compact('workspace','documento'));
  }
  public function expediente_paso01_store( Documento $documento, Request $request) {
      $workspace = $documento->json_load();

      $folios = 0;
      $commands = [];
      $commands[] = 'sleep 2';
      $commands[] = 'echo "Se ha iniciado el proceso..."';

      $estampados = [];
      $temp = EmpresaFirma::porEmpresa($documento->empresa_id, 'FIRMA');
      if(!empty($temp)) {
        $temp = array_map(function($n) {
          return gs(config('constants.ruta_storage') . $n['archivo']);
        }, $temp);
        $estampados['firma_original'] = $temp;
      }
      $temp = EmpresaFirma::porEmpresa($documento->empresa_id, 'VISADO');
      if(!empty($temp)) {
        $temp = array_map(function($n) {
          return gs(config('constants.ruta_storage') . $n['archivo']);
        }, $temp);
        $estampados['visado_original'] = $temp;
      }
      $pedir_estampado = function($tipo, $empresa_id) use(&$estampados) {
        if(empty($estampados[$tipo . '_original'])) {
          return null;
        }
        if(empty($estampados[$tipo])) {
          $estampados[$tipo] = $estampados[$tipo . '_original'];
        }
        return array_shift($estampados[$tipo]);
      };

      $ant_repe = [];

      $workspace['paso03'] = Helper::workspace_ordenar($workspace['paso03']);
      $workspace['paso04']  = $workspace['paso03'];

      foreach($workspace['paso03'] as $key => $file) {
        if(!$file['is_part']) {
          if(!empty($file['estampados']['firma']) || !empty($file['estampados']['visado'])) {
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

        if(!empty($file['estampados']['firma'])) {
          foreach($file['estampados']['firma'] as $pp => $ff) {
            //$input  = config('constants.ruta_storage') . Helper::replace_extension($file['archivo'], 'pdf', '-' . ($pp + 1));
            $input  = $documento->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $output = $documento->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $sello  = $pedir_estampado('firma', 1);
            if(file_exists($input) || true) {
              $commands[] = 'echo "Proceso de estampado de pdf"';
              $commands[] = '/bin/estampar ' . $input . ' ' . $sello . ' ' . $ff['x'] . ' ' . $ff['y'] . " '" . $output . "'";
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
        if(!empty($file['estampados']['visado'])) {
          foreach($file['estampados']['visado'] as $pp => $ff) {
            $input  = $documento->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $output = $documento->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $sello  = $pedir_estampado('visado', 1);
            if(file_exists($input) || true) {
              $commands[] = 'echo "Proceso de estampado de pdf"';
              $commands[] = '/bin/estampar ' . $input . ' ' . $sello . ' ' . $ff['x'] . ' ' . $ff['y'] . " '" . $output . "'";
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
     // echo "<pre>";
      //print_r($workspace['paso03']);
      //exit;

      /* Hasta este paso tenemos los pdf finales, para unir */
      $pdf_individuales = [];
      $documentos_ids = [];
      foreach($workspace['paso03'] as $key => $file) {
        $folios += $file['folio'] ?? 1;
        if(!empty($file['id'])) {
          $documentos_ids[] = $file['id'];
        } elseif(!empty($file['generado_de_id'])) {
          $documentos_ids[] = $file['generado_de_id'];
        }
        if(is_array($file['root'])) {
          foreach($file['root'] as $ff) {
            $pdf_individuales[] = $ff;
          }
        } else {
          $pdf_individuales[] = $file['root'];
        }
      }

      $dir = $documento->folder_workspace();

      $output = $dir . 'Propuesta.pdf';
      $output_final = $dir . 'Propuesta_Seace.pdf';


      /* Unimos los PDFs */
      $commands[] = 'echo "Uniendo los documento en PDF"';
      $commands[] = '/usr/bin/convert -alpha remove -density 200 -quality 100 '. implode(' ', $pdf_individuales) . ' ' . $output;

      /* Ingresando efecto de escaneado */
//      $commands[] = '/usr/bin/convert -density 140 ' . $output . ' -rotate 0.5 -attenuate 0.1 +noise Multiplicative -attenuate 0.01 +noise Multiplicative -sharpen 0x1.0 ' . $output_final;

      $commands[] = '/bin/cp ' . $output . ' ' . $output_final;

      $commands[] = 'echo "Proceso de foliación de PDF"';
      $commands[] = '/bin/pdf-foliar ' . $output_final;

      $commands[] = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';

      $filename = gs_file('pdf');
      $destino  = config('constants.ruta_storage') . 'tenant-' . Auth::user()->tenant_id . '/' . $filename;
      $commands[] = "/snap/bin/gsutil cp '" . $output_final . "' '" . $destino . "'";

      $workspace['paso03'] = $workspace['paso04'];
      unset($workspace['paso04']);

/*
echo "<pre>";
      print_r($commands);
      exit;
*/
      //      $meta = Helper::metadata($output_final);

      $documentos_ids = array_unique($documentos_ids);

      $pid = Helper::parallel_command($commands);
      $workspace['parallel'] = [
        'method' => 'paso04',
        'pids'   => $pid,
      ];


      $documento->archivo       = 'tenant-' . Auth::user()->tenant_id . '/' . $filename;
      $documento->filename      = Helper::replace_extension($documento->rotulo, 'pdf');
      $documento->documentos_id = '{' . implode(',', $documentos_ids) . '}';
      $documento->folio         = $folios;
      //$documento->directorio    = trim($documento->folder(true), '/');
      $documento->filesize      = 10000;#filesize($output_final);
      $documento->elaborado_por    = Auth::user()->id;
      $documento->elaborado_hasta = DB::raw('now()');

      $workspace['documento_final'] = 'https://storage.googleapis.com/creainter-peru/storage/' . $documento->archivo . '?t=' . time();

      $documento->json_save($workspace);

      //$cotizacion->log('EXPEDIENTE/FIN', 'Se finalizó la elaboración del Expediente de ' . $folios . ' páginas.');

      return redirect('/documentos/' . $documento->id . '/expediente/paso02');
    }
  public function store(StoreFileRequest $request)
  {
    $data = $request->input();
    //$data['tenant_id']  = Auth::user()->tenant_id;
    //$data['created_by'] = Auth::user()->id;
    
    $orden = $request->orden;
      if(!empty($request->generado_de_id)) {
        $plantilla = Documento::find($request->generado_de_id);
        if(empty($plantilla)) {
          return 'sin-plantilla';
        }
       if(!empty($request->expediente_id)) {
         $expediente   = Documento::find($request->expediente_id);
         $destino_tmp  = Helper::fileTemp('docx');
         $docx         = $plantilla->generar_documento($expediente->cotizacion(), $data, $destino_tmp);

         $filename_tmp = Helper::file_name(Helper::replace_extension($destino_tmp, 'pdf'));
         $filename     = Helper::replace_extension( $plantilla->archivo, 'pdf', '-' . uniqid());

         $path_pdf     = config('constants.ruta_temporal');
         $destino_pdf  = $path_pdf . $filename;

         exec("/usr/bin/libreoffice --convert-to pdf '" . $destino_tmp . "' --outdir " . $path_pdf);

         $meta = Helper::metadata($path_pdf . $filename_tmp);
         Helper::gsutil_mv($path_pdf . $filename_tmp, config('constants.ruta_storage') . $filename);

         $data['es_plantilla']   = false;
         $data['generado_de_id'] = $request->generado_de_id;
         $data['archivo']        = $filename;
         $data['filename']       = Helper::file_name($filename);
         $data['directorio']     = $plantilla->directorio;
         $data['folio']          = $meta['Pages'];

         $doc = Documento::nuevo($data);

         if ( $request->ajax() ) {
           return response()->json(['status' => true, 'eval' => 'agregarDocumento('.$doc->id . ','. $orden . ',true)']); 
         } else {
           return '404';
         }
       } else {
         return 'sin-doc-id';
       }
     }
     $extension = $request->archivo->extension();
      $fileName = auth()->id() . '_' . time() . '.'. $extension;
      $type = $request->archivo->getClientMimeType();
      $size = $request->archivo->getSize();
      
      $destino = public_path('storage') . '/' . $fileName;
      $destino_cloud = 'tenant-' . Auth::user()->tenant_id . '/'. $fileName;
      $request->archivo->move(public_path('storage'), $fileName);
      Helper::gsutil_cp($destino, config('constants.ruta_storage') . $destino_cloud);

      $meta = Helper::metadata($destino);
      $data['archivo']  = $destino_cloud;
      $data['folio']    = $meta['Pages'] ?? 1;
      $data['formato']  = strtoupper($extension);
      $data['filename'] = $fileName;

      $doc = Documento::nuevo($data);

      if(in_array($doc->tipo, ['VISADO','FIRMA'])) {
        $carpeta = uniqid();
        exec("/bin/pdf-split-sellos '" . $destino . "' '" . $carpeta . "'");
        $path = '/tmp/' . $carpeta . '/';
        $files = array_diff(scandir($path), array('.', '..'));

        foreach($files as $k => $f) {
          $output = 'FIRMAS/' . strtolower($doc->tipo) . '_' . $doc->empresa_id . '_' . $k . '.png';
          Helper::gsutil_mv($path . $f, config('constants.ruta_storage') . $output);
          EmpresaFirma::create([
            'empresa_id' => $doc->empresa_id,
            'tipo'       => $doc->tipo,
            'archivo'    => $output,
            'documento_id' => $doc->id,
          ]);
        }
      }

      if($request->ajax()){
        return response()->json(['status' => true, 'eval' => 'agregarDocumento('.$doc->id .', 0, true)']); 
      }

      return redirect('/documentos');
  }

  public function edit(Request $request, Documento $documento) {
    $this->viewBag['documento'] = $documento;
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Editar Documento" ]; 
    return view('documento.edit',$this->viewBag );    
  }

  public function buscar(Request $request, Documento $documento) {
    $query = $request->input('query');
    if (empty($query)) {
      $resultados = $documento->recomendadas();
    } else {
      $resultados = $documento->busqueda($query);
    }
    if(!empty($resultados)) {
      $resultados = $resultados->toArray();

      $resultados = array_map(function($n) {
        if($n['tipo'] == 'CONTRATO') {
          return array_merge( $n, [
            'rotulo' => $n['rotulo'],
            'desc01' => $n['empresa'],
            'desc02' => $n['tipo'],
            'desc03' => $n['usuario'],
          ]);
        }
        elseif($n['tipo'] == 'VARIADO') {
          return array_merge($n, [
            'rotulo' => $n['rotulo'],
            'desc01' => '',#$n['empresa'],
            'desc02' => '',#$n['tipo'],
            'desc03' => $n['usuario'],
          ]);
        }
        return $n;
      }, $resultados);
    }

    return response()->json($resultados);

  }
    
  public function parallelStatus(Request $request, Documento $documento) {
    $workspace = $documento->json_load();
    $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);

    $log = Helper::parallel_log_pool($workspace['parallel']['pids']);

    return response()->json([
      'status'   => true,
      'finished' => $finished,
      'log'      => $log,
      'data'     => [
        'url' => $workspace['documento_final'],
      ]
    ]);
  }

  public function update(Request $request, Documento $documento) {
    $data = $request->all();
    if($request->hasFile('archivo')) {
      $pathFile = config('constants.ruta_storage') . $documento->archivo;
      $pathinfo = pathinfo($pathFile);
      $fileName = $pathinfo['basename'];
      $dirName  = $pathinfo['dirname'];
      $request->archivo->move($dirName, $fileName);
      $meta = Helper::metadata($pathFile);
      $data['folio']   = $meta['Pages'] ?? 1;
      unset($data['archivo']);
    }

    $documento->update($data);

    if($request->ajax()) {
      return response()->json([
        'status' => true,
        'redirect' => '/documentos',
      ]);
    } else {
      return redirect('/documentos');
    }
  }
  
  public function agregarDocumento(Documento $documento, Documento  $doc, Request $request) {
      $workspace = $documento->json_load();
      $orden = $request->get('orden');

      $cid = Helper::workspace_get_id($doc->id, 'n');

      $orden = !empty($orden) ? $orden : (!empty($workspace['paso03']) ? sizeof($workspace['paso03']) : 0);
      $append = [];
      $hash = uniqid();

      $ruta = config('constants.ruta_storage') . $doc->archivo;
      $ruta = gs($ruta);



      if(!in_array($doc->formato, ['PDF','DOC','DOCX','XLS','XLSX'])) {
        return response()->json([
          'status'  => false,
          'message' => 'No es posible agregar el formato. (' . $doc->formato . ')',
        ]);
      }
      if($doc->formato != 'PDF') {
        $destino  = Helper::file_name(Helper::replace_extension($ruta, 'pdf'));
        $path_pdf = Helper::mkdir_p($documento->folder_workspace());

        exec("/usr/bin/libreoffice --convert-to pdf '" . $ruta . "' --outdir " . $path_pdf);

        $ruta = $path_pdf . $destino;
        $meta = Helper::metadata($ruta);
        $doc->id = null;
        $doc->folio = $meta['Pages'];

      }



      if(!empty($doc->es_ordenable)) {
        $workspace['paso03'] = Helper::workspace_space($workspace['paso03'], $orden, $doc->folio);
        foreach(range(0, $doc->folio - 1) as $pp) {
          $cid = Helper::workspace_get_id( $doc->id, $pp);
          $append[$cid] = Helper::formatoCard([
            'cid'     => $cid,
            'id'      => $doc->id,
            'orden'   => $orden,
            'hash'    => $hash,
            'page'    => $pp,
            'tipo'    => $doc->tipo,
            'folio'   => 1,#$doc->folio,
            'rotulo'  => $doc->rotulo,
            'archivo' => $ruta,
            'root'    => $ruta,
            'is_part' => true,
            'timestamp' => time(),
          ]);
          if(!$doc->es_reusable) {
            if(!empty($doc->generado_de_id)) {
              unset($append[$cid]['id']);
              $doc->delete();
            }
          }
          $orden++;
        }
      } else {
        $cid = Helper::workspace_get_id($doc->id, 'n');
        $append[$cid] = Helper::formatoCard([
          'cid'     => $cid,
          'id'      => $doc->id,
          'orden'   => $orden,
          'hash'    => $hash,
          'page'    => 0,
          'tipo'    => $doc->tipo,
          'folio'   => $doc->folio,
          'rotulo'  => $doc->rotulo,
          'archivo' => $doc->archivo,
          'root'    => $ruta,
          'is_part' => false,
          'timestamp' => time(),
        ]);
        if(!$doc->es_reusable) {
          if(!empty($doc->generado_de_id)) {
            unset($append[$cid]['id']);
            $doc->es_reusable = true;
            $doc->delete();
          }
        }
      }
        foreach($append as $cid => $v) {
          $workspace['paso03'][$cid] = $v;
        }

        $documento->json_save($workspace);

        return response()->json([
          'status' => true , 
          'orden' => $orden,
          'data' => array_values($append),
        ]);
    }
   
    public function eliminarDocumento(Request $request, Documento $documento) {
      //$documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      $cid = $request->get('cid');
      unset($workspace['paso03'][$cid]);
      $documento->json_save($workspace);

       return response()->json([
         'status' => true ,
       ]);
    }

  public  function destroy(Documento $documento  ){
    $documento->eliminado = true;
    $documento->save();
    $documento->log('eliminado');    
    return response()->json(['status'=> true , 'refresh' => true  ]); 
  }
  public function actualizar_orden(Request $request, Documento $documento) {
      $workspace = $documento->json_load();

      $cid = $request->get('id');
      $orden = $request->get('orden');

      $workspace['paso03'] = Helper::workspace_move($workspace['paso03'], $cid, $orden);
      $documento->json_save($workspace);

      return response()->json([
        'status' => true,
        'data' => $workspace['paso03']
      ]);
    }
  public function estamparDocumento(Request $request, Documento $documento) {
      $workspace = $documento->json_load();
      $cid  = $request->get('cid');
      $page = $request->get('page');
      $tool = $request->get('tool');
      $pos_x = $request->get('pos_x');
      $pos_y = $request->get('pos_y');

      $workspace['paso03'][$cid]['estampados'][$tool][$page] = [
        'x' => $pos_x,
        'y' => $pos_y
      ];

      $documento->json_save($workspace);

      return response()->json([
        'status' => true ,
      ]);
    }
    public function eliminarFirmas( Request $request, Documento $documento){
      $workspace = $documento->json_load();

      $cid = $request->get('cid');
      $workspace['paso03'][$cid]['estampados'] = [];

      $documento->json_save($workspace);
      return response()->json(['status' => true ]);
    }

  public function generarImagen(Request $request, Documento $documento) {
    $page   = $request->page;
    $input  = gs(config('constants.ruta_storage') . $documento->archivo);
    $name   = 'thumb_' . md5($documento->id . '-' . $page) . '.jpg';
    $output = config('constants.ruta_temporal') . $name;

    if(!file_exists($input)) {
      echo "404:" . $input;
      exit;
    }
    if(!file_exists($output)) {
      exec("/usr/bin/convert -density 150 '" . $input . "[" . $page . "]' -quality 70 -resize x400 -alpha remove '" . $output . "'");
    }
    $headers = [
      'Content-Description' => 'Imagen de Documento',
      'Content-Type' => 'image/jpg',
    ];
    return \Response::download($output, $name, $headers);
  }

   public function generarImagenTemporal(Documento $documento,  Request $request) {

      $page = $request->get('page');
      $cid  = $request->get("cid");

      //$documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      if (!isset($workspace['paso03'][$cid])) {
        exit;
      }
      $card = $workspace['paso03'][$cid];
      if($page == 0 && !empty($card['page'])) {
        $page = $card['page'];
        $request->page = $page;
      }
      
      if(!empty($card['id'])) {
        return $this->generarImagen($request, Documento::find($card['id']));
      } 
      $input  = $card['root'];

      $name   = 'thumb_' . md5($documento->id . '-' . $cid . '-' . $page . '-' . $card['timestamp']) . '.jpg';
      $dir_tmp = Helper::mkdir_p($documento->folder_workspace());
      $output = $dir_tmp . $name;

      if(!file_exists($input)) {
        sleep(5);
      }
      if(!file_exists($input)) {
        echo "404";
        exit;
      }
      if(!file_exists($output)) {
        exec("/usr/bin/convert -density 150 '" . $input . "[" . $page . "]' -quality 100 -alpha remove '" . $output . "'");
      }
      $headers = [
        'Content-Description' => 'Imagen de Documento',
        'Content-Type' => 'image/jpg',
      ];
      return \Response::download($output, $name, $headers);
    }
  public function descargarParte(Request $request, Documento $documento) {
    $page   = $request->page;
    $input  = gs(config('constants.ruta_storage') . $documento->archivo);
    $name   = 'part_' . md5($documento->id . '-' . $page) . '.pdf';
    $output = config('constants.ruta_temporal') . $name;

    if(!file_exists($input)) {
      echo "404";
      exit;
    }
    if(!file_exists($output)) {
      exec("/usr/bin/pdfseparate '" . $input . "' -f " . $page . " -l " . $page . " '" . $output . "'");
    }
    $headers = [
      'Content-Description' => 'Parte del Documento: ' . $name,
      'Content-Type' => 'document/pdf',
   ];
    return \Response::download($output, $name, $headers);
  }
  
  public function ajax_get(Request $request) {
    $path = $request->input('path');
    $path = trim($path, '/');
    $data = Documento::obtenerArchivos($path);
    $data = array_map(function($n) use($path) {
      return [
        'id'         => $n->id,
        'is_file'    => !empty($n->es_archivo),
        'download'   => !empty($n->es_archivo) ? $n->archivo : ($path . '/' . $n->filename),
        'name'       => $n->filename,
        'rotulo'     => $n->rotulo,
        'created_by' => $n->created_by,
        'folio'      => $n->folio,
        'created_on' => Helper::fecha($n->created_on, true),
        'plantilla'  => $n->plantilla,
        'size'       => $n->filesize,
      ];
    }, $data);
    return response()->json([
      'status' => true,
      'data'   => $data,
    ]);
  }
  public function ajax_upload(StoreFileRequest $request) {
    $path = $request->input('path');
    $path = trim($path, '/');
    $destinos = [];
    $files = $request->file('files');
    foreach($files as $file) {
      $size = $file->getSize();

      if(strtolower($file->getClientOriginalExtension()) == 'pdf') {
        $meta = Helper::metadata($file->getRealPath());
        $pages = $meta['Pages'];
      } else {
        $pages = 0;
      }

      $archivo = $request->gsutil($file, 'tenant-' . Auth::user()->tenant_id);

      $destinos[] = $archivo;

      Documento::create([
        'tenant_id'  => Auth::user()->tenant_id,
        'tipo'       => 'OPEN',
        'formato'    => strtoupper(file_ext($archivo)),
        'directorio' => $path,
        'archivo'    => $archivo,
        'rotulo'     => $file->getClientOriginalName(),
        'filesize'   => $size,
        'filename'   => $file->getClientOriginalName(),
        'created_by' => Auth::user()->id,
        'folio'      => $pages,
      ]);
    }
    return response()->json([
      'status' => true,
      'data'   => $destinos,
    ]);
  }
  public function visor(Request $request) {
    $path = $request->input('path');
    return view('documento.visor', compact('path','request'));
  }
}
