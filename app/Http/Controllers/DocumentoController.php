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
      $listado = Documento::list()->orderBy( 'id', 'desc')->paginate(15)->appends(request()->query());
    }
    $this->viewBag['listado'] = $listado;
    return view('documento.index', $this->viewBag  );
  }
  public function explorer(Request $request) {
    $url    = $request->input('url');
    $format = $request->input('format');
    return view('documento.explore'  , compact('url','format'));
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
      if($card['folio'] == '#') {
        $meta = Helper::metadata($card['root']);
        $workspace['paso03'][$cid]['folio'] = $meta['Pages'];
        $card = $workspace['paso03'][$cid];
        $documento->json_save($workspace);
      }

      return view('documento.imagen', compact('documento', 'card', 'cid'));   
  }

  public function crearExpediente(Request $request) {

    $path = $request->input('path');
    $name = $request->input('name');
    $oid  = $request->input('oid');

    $data['es_plantilla'] = false;
    $data['archivo']      = 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf');
    $data['formato']      = 'PDF';
    $data['folio']        = 0;
    $data['rotulo']       = $name;
    $data['filename']     = $name;
    $data['filesize']     = 0;
    $data['directorio']   = trim($path, '/');
    $data['tipo']         = 'EXPEDIENTE';
    $data['oportunidad_id'] = $oid;
    $data['elaborado_por']   = Auth::user()->id;
    $data['elaborado_desde'] = DB::raw('now()');
    $data['es_mesa']         = true;

    Documento::nuevo($data);

    return response()->json([
      'status' => true,
    ]);
  }
  public function expediente_inicio (Request $request, Documento $documento) {
    $licitacion   = $documento->licitacion();
    $validaciones = [];
    $empresa      = $documento->cotizacion()->empresa();

    $logo_header  = config('constants.ruta_storage') . $empresa->logo_header;
    $logo_central = config('constants.ruta_storage') . $empresa->logo_central;
    $firma        = EmpresaFirma::porEmpresa($documento->cotizacion()->empresa_id, 'FIRMA');
    $visado       = EmpresaFirma::porEmpresa($documento->cotizacion()->empresa_id, 'VISADO');

    $validaciones['empresa_logos'] = (gs_exists($logo_central) || gs_exists($logo_header)) ? true : false;
    $validaciones['sellos_firmas'] = (!empty($firma) && !empty($visado)) ? true:false;
    $validaciones['representante'] = (!empty($empresa->representante_nombres ) &&  !empty($empresa->representante_documento) ) ? true : false;
    $validaciones['montos']        = (!empty( $cotizacion->monto) && !empty($cotizacion->moneda_id)) ? true : false;

    return view('documento.expediente.inicio', compact('documento', 'licitacion', 'validaciones'));
  }
  public function expediente_inicio_store(Request $request, Documento $documento) {
    if(empty($documento->archivo)) {
      $documento->archivo = 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf');
    }   
    $documento->paso(1);

    $dir_tmp = $documento->folder_workspace();
    exec('/bin/rm -rf ' . $dir_tmp);
    $dir_tmp = Helper::mkdir_p($dir_tmp);

    return redirect('/documentos/'. $documento->id . '/expediente/paso01');
  }

  public function expediente_paso01(Request $request, Documento $documento) {
    if(!empty($documento->finalizado_el)) {
      return redirect('/documentos/' . $documento->id . '/expediente/inicio');
    }
    $workspace = $documento->json_load();
    if(!empty($workspace['parallel'])) {
      $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);
      if(!$finished) {
        return redirect('/documentos/' . $documento->id . '/expediente/inicio?merror=espera');
      }
    }
    $empresa      = $documento->cotizacion()->empresa()->toArray();
    $licitacion   = $documento->licitacion();
    if(!empty($workspace['inputs'])) {
      $workspace['inputs'] = array_merge($workspace['inputs'], $empresa);
    } else {
      $workspace['inputs'] = $empresa;
    }
    $documento->json_save($workspace);
    return view('documento.expediente.paso01', compact('documento','licitacion','workspace','plantillas'));
  }
  public function expediente_paso01_store(Documento $documento, Request $request) {
    $workspace = $documento->json_load();

    if(!empty($documento->finalizado_el)) {
      return redirect('/documentos/' . $documento->id . '/expediente/inicio');
    }

    $workspace['paso01'] = $_POST['anexos'] ?? [];
    $workspace['paso02'] = [];

    $dir_tmp = $documento->folder_workspace();
    $dir_tmp = Helper::mkdir_p($dir_tmp);

    foreach ($workspace['paso01'] as $key => $value) {
      $doc = Documento::find($key);
      $destino = $dir_tmp . $doc->filename;
      $doc->generar_documento($documento->cotizacion(), $workspace['inputs'], $destino);
      $workspace['paso02'][$key] = [
        'generado_de_id' => $doc->id,
        'tipo'           => $doc->tipo,
        'nombre'         => $doc->tipo,
        'rotulo'         => $doc->rotulo,
        'filename'       => $doc->filename,
        'root'           => $destino,
        'uri'            => $documento->folder_workspace(true) . $doc->filename,
        'timestamp'      => time(),
      ];
    }
    $documento->json_save($workspace);

    $documento->paso(2);

    return redirect('/documentos/' . $documento->id . '/expediente/paso02');
  }

  public function expediente_paso02 (Request $request, Documento $documento) {
    $workspace = $documento->json_load();
    if(!empty($documento->finalizado_el)) {
      return redirect('/documentos/' . $documento->id . '/expediente/inicio');
    }
    if(!empty($workspace['parallel'])) {
      $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);
      if(!$finished) {
        return redirect('/documentos/' . $documento->id . '/expediente/inicio?merror=espera');
      }
    }
    if(!isset($workspace['paso02'])) {
      return redirect('/documentos/' . $documento->id . '/expediente/paso01');
    }
    $licitacion = $documento->cotizacion()->oportunidad()->licitacion();
    return view('documento.expediente.paso02', compact('documento','licitacion','workspace'));
  }

  public function expediente_paso02_store(Request $request, Documento $documento) {
      $workspace = $documento->json_load();

      if(!empty($documento->finalizado_el)) {
        return redirect('/documento/' . $documento->id . '/expediente/inicio');
      }

      $workspace['paso03'] = array();
      $workspace['addons'] = [
        'firma'  => [],
        'visado' => [],
      ];

      $order = 0;
      $commands = [];

      foreach($workspace['paso02'] as $id => $file) {
        $cid     = $id. '/n';
        $input   = $file['root'];
        $output  = Helper::replace_extension($file['root'], 'pdf');
        $outputd = dirname(Helper::replace_extension($file['root'], 'pdf'));

        $commands[] = '/bin/rm ' . $output;
        $commands[] = '/usr/bin/libreoffice --convert-to pdf ' . $input . ' --outdir ' . $outputd;
        $commands[] = '/usr/bin/php /var/www/html/interno.creainter.com.pe/util/oportunidades/expediente_folio_documento.php ' . $documento->id . " '" . $cid . "'";
        #exec('/usr/bin/convert -alpha remove -density 150 '.  $output . ' -quality 100 '. $thumb);
        #exec('/bin/mv ' . $thumb . ' ' . $thumb_0);

//        $metadata = Helper::metadata($output);

        $workspace['paso03'][$cid]  = Helper::formatoCard([
          'orden'     => $order,
          'hash'      => uniqid(),
          'page'      => 0,
          'folio'     => '#',
          'tipo'      => $file['tipo'],
          'rotulo'    => $file['rotulo'],
          'archivo'   => Helper::replace_extension($file['root'], 'pdf'),
          'root'      => Helper::replace_extension($file['root'], 'pdf'),
          'is_part'   => false,
          'timestamp' => time(),
        ], $documento->cotizacion()->empresa_id);

        if(!isset($workspace['addons']['visado'][$documento->cotizacion()->empresa_id])) {
          $workspace['addons']['visado'][$documento->cotizacion()->empresa_id] = 0;
        }
        $workspace['addons']['visado'][$documento->cotizacion()->empresa_id] ++;
        $order++;
      }
      $pid = Helper::parallel_command($commands);
      unset($workspace['paso02']);

      $documento->json_save($workspace);

      $documento->paso(3);

      return redirect('/documentos/' . $documento->id . '/expediente/paso03');
    }
    public function expediente_paso03(Request $request, Documento $documento) {
      $workspace = $documento->json_load();

      $workspace['paso03'] = Helper::workspace_ordenar($workspace['paso03']);
      if(isset($_GET['demo'])) {
        echo "<pre>";
        print_r($workspace);
        exit;
      }
      if(!empty($documento->finalizado_el)) {
        return redirect('/documentos/' . $documento->id . '/expediente/inicio');
      }
      if(!empty($workspace['parallel'])) {
        $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);
        if(!$finished) {
          return redirect('/documentos/' . $documento->id . '/expediente/inicio?merror=espera');
        }
      }
      $oportunidad = $documento->cotizacion()->oportunidad();
      return view('documento.expediente.paso03', compact('documento','oportunidad' ,'workspace'));
    }

    public function expediente_paso03_store(Request $request, Documento $documento) {
      $workspace = $documento->json_load();

      if(!empty($documento->finalizado_el)) {
        return redirect('/documentos/' . $documento->id . '/expediente/inicio');
      }

      foreach($workspace['paso03'] as $key => $file) {
        if($file['folio'] == '#') {
          return redirect('/documentos/' . $documento->id . '/expediente/paso03?verror=' . $key);
        }
      }

      foreach($workspace['paso03'] as $key => $file) {
        if (!file_exists($file['root'])) {
          return redirect('/documentos/' . $documento->id . '/expediente/paso03?ferror=' . $file['root']);
        }
      }

      $documento->paso(4);

      $pid = $documento->procesarFolder($workspace, true, $metrados);
      if(empty($pid)) {
        return redirect('/documentos/' . $documento->id . '/expediente/paso03?verror=Ya-está-iniciado');
      }
    
      return redirect('/documentos/' . $documento->id . '/expediente/inicio');
    }
    public function expediente_paso03_revisar(Request $request, Documento $documento) {
      $workspace = $documento->json_load();

      if(!empty($documento->finalizado_el)) {
        return redirect('/documentos/' . $documento->id . '/expediente/inicio');
      }

      foreach($workspace['paso03'] as $key => $file) {
        if($file['folio'] == '#') {
          return redirect('/documentos/' . $documento->id . '/expediente/paso03?verror=' . $key);
        }
      }

      foreach($workspace['paso03'] as $key => $file) {
        if (!file_exists($file['root'])) {
          return redirect('/documentos/' . $documento->id . '/expediente/paso03?ferror=' . $file['root']);
        }
      }

      $documento->paso(5);

      $pid = $documento->procesarFolder($workspace, true, $metrados);
      if(empty($pid)) {
        return redirect('/documentos/' . $documento->id . '/expediente/paso03?verror=Ya-está-iniciado');
      }
      return redirect('/documentos/' . $documento->id . '/expediente/inicio');
    }
    public function expediente_paso04(Request $request, Documento $documento) {
      $workspace = $documento->json_load();
      return redirect('/documentos/' . $documento->id . '/expediente/inicio');
      return view('documento.expediente.paso04', compact('workspace','cotizacion','documento'));
    }
    public function expediente_cancelar_proceso(Request $request, Documento $documento) {
      $workspace = $documento->json_load();

      if(!empty($workspace['parallel'])) {
        $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);
        if(!$finished) {
          $documento->paso(9);
          exec("kill -9 " . $workspace['parallel']['pids']);
          return redirect('/documentos/' . $documento->id . '/expediente/paso03');
        }
      }
    }
    public function expediente_aprobar(Request $request, Documento $documento) {
      $workspace = $documento->json_load();

      if(!Auth::user()->allow('PUEDE_APROBAR', $documento->elaborado_por) && Auth::user()->id != 12) {
        return response()->json([
          'status'   => false,
          'disabled' => true,
          'label'    => 'No disponible',
          'message'  => 'No es posible aprobar por el mismo usuario.',
          'refresh'  => false,
          'class'    => 'warning',
        ]);
      }

      $documento->aprobar();

      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Documento Aprobado!',
        'message'  => 'Aprobado',
        'refresh'  => false,
        'class'    => 'success',
        'redirect' => '/documentos/' . $documento->id . '/expediente/inicio',
      ]);
    }
    public function expediente_observar(Request $request, Documento $documento) {
      $motivo = $request->input('value');

      if(empty($motivo)) {
        return response()->json([
          'status'  => false,
          'message' => 'Debe indicar el motivo',
        ]);
      }

      if(!Auth::user()->allow('PUEDE_APROBAR', $documento->elaborado_por) && Auth::user()->id != 12) {
        return response()->json([
          'status'   => false,
          'disabled' => true,
          'label'    => 'No disponible',
          'message'  => 'No es posible observar por el mismo usuario.',
          'refresh'  => false,
          'class'    => 'warning',
        ]);
      }
      $workspace = $documento->json_load();

      $documento->observar($motivo);

      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Documento Observado!',
        'message'  => 'Observado',
        'refresh'  => false,
        'class'    => 'success',
        'redirect' => '/documentos/' . $documento->id . '/expediente/inicio',
      ]);
    }
    public function expediente_reanudar(Request $request, Documento $documento) {
      $workspace = $documento->json_load();

      $documento->log('DOCUMENTO/PASO', 'Se ha reanudado la edición del expediente');

      $documento->revisado_por    = null;
      $documento->revisado_el     = null;
      $documento->finalizado_el   = null;
      $documento->finalizado_por  = null;
      $documento->save();

      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Documento Reanudado!',
        'message'  => 'Reanuado',
        'refresh'  => false,
        'class'    => 'success',
        'redirect' => '/documentos/' . $documento->id . '/expediente/inicio',
      ]);
    }

  public function store(StoreFileRequest $request) {
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
         Helper::gsutil_mv($path_pdf . $filename_tmp, config('constants.ruta_storage') . $filename, false);

         $data['es_plantilla']   = false;
         $data['generado_de_id'] = $request->generado_de_id;
         $data['archivo']        = $filename;
         $data['filename']       = Helper::file_name($filename);
         $data['directorio']     = $plantilla->directorio;
         $data['folio']          = $meta['Pages'];
         $data['formato']        = 'PDF';

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
        if( !empty($request->folder)){
          $carpeta = $request->folder;
        }else {
          $carpeta = uniqid();
          exec("/bin/pdf-split-sellos '" . $destino . "' '" . $carpeta . "'");
        }

        $path = '/tmp/' . $carpeta . '/';
        
        $i = 0;
        if($handler = opendir( '/tmp/' . $carpeta  )){

          $commands[] = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';
          while ( false !== ( $file = readdir($handler) ) ) {
            if ( strpos($file ,'jpg') || strpos($file,'png') ){
              
              $output = 'FIRMAS/' . strtolower($doc->tipo) . '_' . $doc->empresa_id . '_' . $i . '.png';

              $commands[] = "/snap/bin/gsutil -D -h Cache-Control:\"Cache-Control:private, max-age=0, no-transform\" mv '" . $path . $file . "' '" . config('constants.ruta_storage') . $output. "'";

              EmpresaFirma::create([
                'empresa_id' => $doc->empresa_id,
                'tipo'       => $doc->tipo,
                'archivo'    => $output,
                'documento_id' => $doc->id,
              ]);
              $i++;
            }
          }
          closedir($handler);
          $pid = Helper::parallel_command($commands);
        }  

        /*$files = array_diff(scandir($path), array('.', '..'));

        $commands[] = 'export PATH="$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin"';
        
        $i = 0;
        foreach($files as $k => $f) {
          $output = 'FIRMAS/' . strtolower($doc->tipo) . '_' . $doc->empresa_id . '_' . $i . '.png';
          $commands[] = "/snap/bin/gsutil -D -h Cache-Control:\"Cache-Control:private, max-age=0, no-transform\" mv '" . $path . $f . "' '" . config('constants.ruta_storage') . $output. "'";
          EmpresaFirma::create([
            'empresa_id' => $doc->empresa_id,
            'tipo'       => $doc->tipo,
            'archivo'    => $output,
            'documento_id' => $doc->id,
          ]);
          $i++;
        }
        $pid = Helper::parallel_command($commands);*/
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
        'url_original' => config('constants.static_cloud') . $documento->original,
        'url_archivo'  => config('constants.static_cloud') . $documento->archivo
      ]
    ]);
  }
  public function expediente_actualizar(Documento $documento, StoreFileRequest $request) {

      $cid = $request->input('cid');
      $workspace = $documento->json_load();
      if(!isset($workspace['paso02'][$cid])) {
        return '404:' . $cid;
      }
      $card = $workspace['paso02'][$cid];
      $dir = $documento->folder_workspace();
      $destino = $card['root'];

      $request->archivo->move($dir, $card['filename']);

      $meta = Helper::metadata($destino);

      $workspace['paso02'][$cid]['folio'] = $meta['Pages'];

      $documento->json_save($workspace);

      return response()->json(['status' => true]);
    }


  public function update(StoreFileRequest $request, Documento $documento) {
    $data = $request->all();
    if($request->hasFile('archivo')) {
      $pathinfo = pathinfo($documento->archivo);
      $fileName = $pathinfo['basename'];
      $dirName  = $pathinfo['dirname'];

      $meta = Helper::metadata($request->archivo->getPathName());
      $request->gsutil($request->archivo, $dirName, $fileName);

//      $request->archivo->move($dirName, $fileName);
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
      $orden = $request->input('orden');

      $cid = Helper::workspace_get_id($doc->id, 'n');

      $orden = (int) (!empty($orden) ? $orden : (!empty($workspace['paso03']) ? sizeof($workspace['paso03']) : 0));

      $append = [];
      $hash = uniqid();

      $ruta = config('constants.ruta_storage') . $doc->archivo;
      $ruta = gs($ruta, $documento->folder_workspace());

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

//      $doc->visitar();

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

        $workspace['paso03'] = Helper::workspace_ordenar($workspace['paso03']);

        $documento->json_save($workspace);

        return response()->json([
          'status' => true , 
          'orden'  => $orden,
          'data'   => array_values($append),
        ]);
    }
   
    public function eliminarDocumento(Request $request, Documento $documento) {
      //$documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      $cid = $request->get('cid');
      //Elimina el documento cuando sea unico o sea la ultima pagina que se encuentre en la mesa de trabajo
      if(( $workspace['paso03'][$cid]['is_part'] == false) || ( $workspace['paso03'][$cid]['is_part'] == true &&  (sizeof( preg_grep( '/' . ( explode('/', $cid)[0] ) . '\/\d/i', array_keys($workspace['paso03']))) == 1)   ) ){
       @unlink($workspace['paso03'][$cid]['root']);
      } 
      
      unset( $workspace['paso03'][$cid] );

      $documento->json_save($workspace);

       return response()->json([
         'status' => true ,
         'datos' => preg_grep( '/'.( explode('/', $cid)[0] ) . '\/\d/i', array_keys($workspace['paso03']) )
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

      $cid      = $request->get('id');
      $orden    = $request->get('orden');
      $contexto = $request->get('contexto');

      $workspace['paso03'] = Helper::workspace_move($workspace['paso03'], $cid, $orden, $contexto);
      $documento->json_save($workspace);

      return response()->json([
        'status' => true,
        'data' => $workspace['paso03']
      ]);
    }
  public function estamparDocumento(Request $request, Documento $documento) {
      $workspace = $documento->json_load();
      $cid  = $request->get('cid');
      $eid  = $request->get('eid');
      $page = $request->get('page');
      $tool = $request->get('tool');
      $pos_x = $request->get('pos_x');
      $pos_y = $request->get('pos_y');

      if(!isset($workspace['paso03'][$cid]['addons'][$page])) {
        $workspace['paso03'][$cid]['addons'][$page] = [];
      }
      $fid = uniqid();
      $workspace['paso03'][$cid]['addons'][$page][$fid] = [
        'id'   => $fid,
        'tool' => $tool,
        'eid'  => $eid,
        'x'    => $pos_x,
        'y'    => $pos_y
      ];

      if(!isset($workspace['addons'][$tool])) {
        $workspace['addons'][$tool] = [];
      }
      if(!isset($workspace['addons'][$tool][$eid])) {
        $workspace['addons'][$tool][$eid] = 0;
      }

      $workspace['addons'][$tool][$eid]++;

      $documento->json_save($workspace);

      return response()->json([
        'status' => true ,
        'id'     => $fid,
      ]);
    }
    public function eliminarFirmas( Request $request, Documento $documento ){
      $workspace = $documento->json_load();

      $cid  = $request->get('cid');
      $fid  = $request->get('fid');
      $page = $request->get('page');

      $card = $workspace['paso03'][$cid]['addons'][$page][$fid];
      $tool = $card['tool'];
      $eid  = $card['eid'];

      if(!isset($workspace['addons'][$tool])) {
        $workspace['addons'][$tool] = [];
      }
      if(!isset($workspace['addons'][$tool][$eid])) {
        $workspace['addons'][$tool][$eid] = 0;
      }
      $workspace['addons'][$tool][$eid]--;

      if($workspace['addons'][$tool][$eid] < 0) {
        $workspace['addons'][$tool][$eid] = 0;
      }

      unset($workspace['paso03'][$cid]['addons'][$page][$fid]);

      $documento->json_save($workspace);
      return response()->json(['status' => true]);
    }

  public function expediente_upload(StoreFileRequest $request, Documento $documento) {
    $path = $request->input('path');
    $path = trim($path, '/');
    $destinos = [];
    $files = $request->file('files');
    $orden = 999999;
    $workspace = $documento->json_load();

    $append = [];
    foreach($files as $file) {
      $size     = $file->getSize();
      $formato  = strtolower($file->getClientOriginalExtension());
      $original = $file->getRealPath();
      $filename = $file->getClientOriginalName();

      if(!in_array(strtoupper($formato), ['PDF','DOC','DOCX','XLS','XLSX'])) {
        $file->subido = 'El formato no es válido';
        continue;
      }
      if($formato == 'pdf') {
        $meta = Helper::metadata($original);
        $archivo = gs_file('pdf');
        $file->move($documento->folder_workspace(), $archivo);
        $destino = $documento->folder_workspace() . $archivo;

      } else {
        $archivo  = gs_file($formato);
        $file->move($documento->folder_workspace(), $archivo);
        $original = $documento->folder_workspace() . $archivo;

        $destino  = Helper::replace_extension($original, 'pdf');

        exec("/usr/bin/libreoffice --convert-to pdf '" . $original . "' --outdir " . $documento->folder_workspace());
        $meta = Helper::metadata($destino);
        unlink($original);
        $meta = Helper::metadata($destino);
      }
      $file->subido = 'Ok';

      $cid = Helper::workspace_get_id(uniqid(), 'n');
      $append[$cid] = Helper::formatoCard([
          'cid'     => $cid,
          'orden'   => ++$orden,
          'page'    => 0,
          'hash'    => uniqid(),
          'tipo'    => 'UPLOAD',
          'folio'   => $meta['Pages'],
          'rotulo'  => $filename,
          'archivo' => $destino,
          'root'    => $destino,
          'is_part' => false,
          'timestamp' => time(),
        ]);
    }

    foreach($append as $k => $r) {
      $workspace['paso03'][$k] = $r;
    }
    $workspace['paso03'] = Helper::workspace_ordenar($workspace['paso03']);

    $documento->json_save($workspace);

    $respuestas = array_map(function($n) {
      return $n->subido;
    }, $files);

    return response()->json([
      'status'   => true,
      'messages' => $respuestas,
      'append'   => array_values($append),
    ]);
  }
    public function expediente_respaldar(Request $request, Documento $documento) {
      $destino  = config('constants.ruta_storage') . 'workspace/' . $documento->CompressWorkspace();
      if(file_exists($documento->folder_workspace())) {
        if(empty($documento->respaldado_el) || ((time() - strtotime($documento->respaldado_el)) > 60*2)) {
          $res = $documento->respaldarFolder();
          return response()->json([
            'status'   => true,
            'response' => $res,
            'path'     => $documento->folder_workspace(),
            'message'  => 'Respaldado en la Nube!',
          ]);
        } else {
          return response()->json([
            'status'  => false,
            'message' => 'No es posible.',
          ]);
        }
      } else {
        return response()->json([
          'status'  => false,
          'message' => 'No existe el Folder.',
        ]);
      }
    }
    public function expediente_restaurar(Request $request, Documento $documento) {
      if(!file_exists($documento->folder_workspace())) {
        if(!empty($documento->respaldado_el)) {

          $res = $documento->restaurarFolder();

          return response()->json([
            'status'  => true,
            'message' => 'Restaurando...',
            'pid'     => $res,
          ]);
        } else {
          return response()->json([
            'status'  => false,
            'message' => 'Sin respaldo',
          ]);
        }
      } else {
        return response()->json([
          'status'  => false,
          'message' => 'Ya existe una versión local: ' . $documento->CompressWorkspace(),
        ]);
      }
    }

  public function generarImagen(Request $request, Documento $documento, $path = null) {
    $page   = $request->page;
    $input  = gs(config('constants.ruta_storage') . $documento->archivo);
    $name   = 'temp_thumb02_' . md5($documento->id . '-' . $page) . '.jpg';
    $path   = $path ?? config('constants.ruta_temporal');
    $output = $path . $name;

    if(!file_exists($input)) {
      echo "404:" . $input;
      exit;
    }
    if(!file_exists($output)) {
      exec("/usr/bin/convert -density 150 '" . $input . "[" . $page . "]' -quality 90 -resize x800 -alpha remove '" . $output . "'");
    }
    $headers = [
      'Content-Description' => 'Imagen de Documento',
      'Content-Type' => 'image/jpg',
    ];
    return \Response::download($output, $name, $headers);
  }

   public function generarImagenTemporal(Documento $documento, Request $request) {

      $page = $request->get('page');
      $cid  = $request->get("cid");

      $path = $documento->folder_workspace();

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
        return $this->generarImagen($request, Documento::find($card['id']), $path);
      } 
      $input  = $card['root'];

      $name   = 'temp_thumb01_' . md5($documento->id . '-' . $cid . '-' . $page . '-' . $card['timestamp']) . '.jpg';

      if(!file_exists($input)) {
        //sleep(15);
      }
      if(!file_exists($input)) {
        echo "404";
        exit;
      }
      $output = $path . $name;

      if(!file_exists($output)) {
        exec("/usr/bin/convert -density 150 '" . $input . "[" . $page . "]' -quality 90 -resize x800 -alpha remove '" . $output . "'");
      }
      $headers = [
        'Content-Description' => 'Imagen de Documento',
        'Content-Type' => 'image/jpg',
      ];
      return \Response::download($output, $name, $headers);
    }
  public function descargarParte(Request $request, Documento $documento) {
    $page   = $request->page;
    if(!(preg_match("/^[\d]+\-[\d]+$/", $page) || preg_match("/^[\d]+$/", $page))) {
      echo "404";
      exit;
    }
    $input  = gs(config('constants.ruta_storage') . $documento->archivo);
    $name   = 'part_' . md5($documento->id . '-' . $page) . '.pdf';
    $output = config('constants.ruta_temporal') . $name;

    if(!file_exists($input)) {
      echo "404";
      exit;
    }
    if(!file_exists($output)) {
      $cmd = "/usr/bin/qpdf --empty --pages '" . $input . "' " . $page . " -- '" . $output . "'";
      exec($cmd);
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
      if($n->tipo == 1)  { //Carpeta
        return [
          'tipo'       => $n->tipo,
          'is_file'    => false,
          'download'   => $path . '/' . $n->filename,
          'name'       => $n->filename,
          'rotulo'     => $n->rotulo,
          'created_by' => $n->created_by,
          'folio'      => $n->folio,
          'created_on' => Helper::fecha($n->created_on, true),
          'plantilla'  => false,
          'size'       => '--',
        ];
      } elseif($n->tipo == 2) { //Archivos
        return [
          'tipo'       => $n->tipo,
          'id'         => $n->id,
          'is_file'    => true,
          'download'   => config('constants.static_cloud') . $n->archivo,
          'name'       => $n->filename,
          'rotulo'     => $n->rotulo,
          'created_by' => $n->created_by,
          'folio'      => $n->folio,
          'created_on' => Helper::fecha($n->created_on, true),
          'plantilla'  => $n->plantilla,
          'size'       => $n->filesize,
        ];
      } elseif($n->tipo == 3) { //Modificación de Expediente
        return [
          'tipo'       => $n->tipo,
          'id'         => $n->id,
          'is_file'    => true,
          'download'   => !empty($n->fecha_hasta) ? config('constants.static_cloud') . $n->archivo : null,
          'name'       => $n->filename,
          'rotulo'     => $n->rotulo,
          'created_by' => $n->created_by,
          'folio'      => $n->folio,
          'created_on' => Helper::fecha($n->created_on, true),
          'plantilla'  => $n->plantilla,
          'size'       => $n->filesize,
        ];
      } elseif($n->tipo == 4) { //Link Publico
        return [
          'tipo'       => $n->tipo,
          'id'         => $n->id,
          'is_file'    => true,
          'download'   => $n->archivo,
          'name'       => $n->filename,
          'rotulo'     => $n->rotulo,
          'created_by' => $n->created_by,
          'folio'      => $n->folio,
          'created_on' => Helper::fecha($n->created_on, true),
          'plantilla'  => $n->plantilla,
          'size'       => $n->filesize,
        ];
      }
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
  public function filestore(Request $request) {
    return view('documento.filestore', compact('request'));
  }
}
