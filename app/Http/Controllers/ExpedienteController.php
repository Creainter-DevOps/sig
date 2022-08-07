<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Licitacion;
use App\Empresa;
use App\EmpresaFirma;
use App\Cotizacion;
use App\Oportunidad;
use App\Documento;
use App\Helpers\Helper;
use PhpOffice\PhpWord; 
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use Auth;
use Illuminate\Support\Facades\DB;

class ExpedienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('expediente.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inicio(Request $request, Cotizacion $cotizacion ){
      
      $licitacion = $cotizacion->oportunidad()->licitacion();
      $validaciones = [];   
      $empresa = $cotizacion->empresa();
      $logo_header = config('constants.ruta_storage') . $empresa->logo_header;
      $logo_central = config('constants.ruta_storage') . $empresa->logo_central;
      $firma = EmpresaFirma::porEmpresa( $cotizacion->empresa_id, 'FIRMA');
      $visado = EmpresaFirma::porEmpresa( $cotizacion->empresa_id, 'VISADO');

      $validaciones['empresa_logos'] = (gs_exists($logo_central) || gs_exists($logo_header)) ? true : false; 

      $validaciones['sellos_firmas'] = (!empty($firma) && !empty($visado)) ? true:false;

      $validaciones['representante'] = (!empty($empresa->representante_nombres ) &&  !empty($empresa->representante_documento) ) ? true : false;

      $validaciones['montos'] = (!empty( $cotizacion->monto) && !empty($cotizacion->moneda_id)) ? true : false;

      if( $request->ajax()){
        return response()->json([ 'status' => true, 'validaciones' => $validaciones ]);  
      }
      return view('expediente.inicio', compact('cotizacion','licitacion', 'validaciones'));

    }
    public function inicio_store(Cotizacion $cotizacion) {
      if(empty($cotizacion->documento_id)) {
        $documento = Documento::nuevo([
          'cotizacion_id'  => $cotizacion->id,
          'oportunidad_id' => $cotizacion->oportunidad_id,
          'licitacion_id'  => $cotizacion->oportunidad()->licitacion_id,
          'es_plantilla'  => false,
          'es_ordenable'  => false,
          'es_reusable'   => false,
          'tipo'          => 'EXPEDIENTE',
          'folio'         => 0,
          'rotulo'        => 'Expediente: ' . $cotizacion->oportunidad()->codigo,
          'filename'      => 'Propuesta_Seace.pdf',
          'formato'       => 'PDF',
          'directorio'    => trim($cotizacion->folder(true), '/'),
          'filesize'      => 0,
          'es_mesa'       => true,
          'elaborado_desde' => DB::raw('now()'),
          'respaldado_el'  => null,
          'archivo'        => 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf'),
          'original'       => 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf')
        ]);
        $cotizacion->documento_id = $documento->id;
        $cotizacion->elaborado_por   = Auth::user()->id;
        $cotizacion->elaborado_step  = 1;
        $cotizacion->save();
      } else {
        $documento = Documento::find($cotizacion->documento_id);
        $documento->directorio     = trim($cotizacion->folder(true), '/');
        $documento->respaldado_el  = null;
        $documento->elaborado_desde = DB::raw('now()');
        if(empty($documento->original)) {
          $documento->original = 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf');
        }
        if(empty($documento->archivo)) {
          $documento->archivo = 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf');
        }
        $documento->save();

        $cotizacion->elaborado_por   = Auth::user()->id;
        $cotizacion->elaborado_step  = 1;
        $cotizacion->save();
      }

      $dir_tmp = $documento->folder_workspace();
      exec('/bin/rm -rf ' . $dir_tmp);
      $dir_tmp = Helper::mkdir_p($dir_tmp);

      $cotizacion->log('EXPEDIENTE/INICIO', 'Se inició la elaboración del Expediente');
      return redirect('/expediente/'. $cotizacion->id . '/paso01');
    }

    public function paso01(Cotizacion $cotizacion) {
      $plantillas = Documento::plantillas();
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      if(!empty($workspace['parallel'])) {
        $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);
        if(!$finished) {
          return redirect('/expediente/' . $cotizacion->id . '/paso04?merror=espera');
        }
      }

      $licitacion = $cotizacion->oportunidad()->licitacion();
      $empresa = $cotizacion->empresa()->toArray();

      if(!empty($workspace['inputs'])) {
        $workspace['inputs'] = array_merge($workspace['inputs'], $empresa);
      } else {
        $workspace['inputs'] = $empresa;
      }
      $documento->json_save($workspace);
      return view('expediente.paso01', compact('cotizacion','licitacion','workspace','plantillas'));

    }

    public function paso01_store(Cotizacion $cotizacion, Request $request) {
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();
      $workspace['paso01'] = $_POST['anexos'] ?? [];
      $workspace['paso02'] = [];


      $dir_tmp = $documento->folder_workspace();
      $dir_tmp = Helper::mkdir_p($dir_tmp);

      foreach ($workspace['paso01'] as $key => $value) {
        $doc = Documento::find($key);
        $destino = $dir_tmp . $doc->filename;
        $doc->generar_documento($cotizacion, $workspace['inputs'], $destino);
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

      $cotizacion->elaborado_por   = Auth::user()->id;
      $cotizacion->elaborado_step  = 2;
      $cotizacion->save();

      return redirect('/expediente/' . $cotizacion->id . '/paso02');

    }

    public function paso02(Cotizacion $cotizacion) {
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      if(!empty($workspace['parallel'])) {
        $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);
        if(!$finished) {
          return redirect('/expediente/' . $cotizacion->id . '/paso04?merror=espera');
        }
      }

      if(!isset($workspace['paso02'])) {
        return redirect('/expediente/' . $cotizacion->id . '/paso01');
      }
      $licitacion = $cotizacion->oportunidad()->licitacion();
      return view('expediente.paso02', compact('cotizacion','licitacion','workspace'));
    }

    public function paso02_store(Cotizacion $cotizacion, Request $request) {
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();


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
        $commands[] = '/usr/bin/php /var/www/html/interno.creainter.com.pe/util/oportunidades/expediente_folio.php ' . $cotizacion->id . " '" . $cid . "'";
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
        ], $cotizacion->empresa_id);

        if(!isset($workspace['addons']['visado'][$cotizacion->empresa_id])) {
          $workspace['addons']['visado'][$cotizacion->empresa_id] = 0;
        }
        $workspace['addons']['visado'][$cotizacion->empresa_id] ++;
        $order++;
      }
      $pid = Helper::parallel_command($commands);
      unset($workspace['paso02']);

      $documento->json_save($workspace);

      $cotizacion->elaborado_por   = Auth::user()->id;
      $cotizacion->elaborado_step  = 3;
      $cotizacion->save();

      return redirect('/expediente/' . $cotizacion->id . '/paso03');
    }
    public function paso03(Cotizacion $cotizacion) {
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      $workspace['paso03'] = Helper::workspace_ordenar($workspace['paso03']);
      if(isset($_GET['demo'])) {
        echo "<pre>";
        print_r($workspace);
        exit;
      }

      if(!empty($workspace['parallel'])) {
        $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);
        if(!$finished) {
          return redirect('/expediente/' . $cotizacion->id . '/paso04?merror=espera');
        }
      }

      $oportunidad = $cotizacion->oportunidad();

      return view('expediente.paso03', compact('oportunidad' ,'workspace','cotizacion','documento'));

    }

    public function paso03_store(Cotizacion $cotizacion, Request $request) {

      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      if($cotizacion->elaborado_step == 4) {
#        return redirect('/expediente/' . $cotizacion->id . '/paso04?verror=ya-esta-procesando');
      }
      /*if(empty($documento->respaldado_el)) {
        return redirect('/expediente/' . $cotizacion->id . '/paso03?merror=sin-respaldo');
      }

      if(strtotime($documento->respaldado_el) >= time() - 60) {
        return redirect('/expediente/' . $cotizacion->id . '/paso03?merror=esperemosRecienRespaldado');
      }*/

      foreach($workspace['paso03'] as $key => $file) {
        if($file['folio'] == '#') {
          return redirect('/expediente/' . $cotizacion->id . '/paso03?verror=' . $key);
        }
      }

      foreach($workspace['paso03'] as $key => $file) {
        if (!file_exists($file['root'])) {
          return redirect('/expediente/' . $cotizacion->id . '/paso03?ferror=' . $file['root']);
        }
      }

      $pid = $documento->procesarFolder($workspace, true, $metrados);
      if(empty($pid)) {
        return redirect('/expediente/' . $cotizacion->id . '/paso03?verror=Ya-está-iniciado');
      }
      $cotizacion->elaborado_por   = Auth::user()->id;
      $cotizacion->elaborado_step  = 4;
      $cotizacion->save();

      $cotizacion->log('EXPEDIENTE/FIN', 'Inició el proceso del Expediente de ' . $metrados['folios'] . ' páginas.');

      return redirect('/expediente/' . $cotizacion->id . '/paso04');
    }
    public function paso04(Cotizacion $cotizacion) {
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      return view('expediente.paso04', compact('workspace','cotizacion','documento'));
    }
    public function paso04_store(Cotizacion $cotizacion, Request $request) {
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();
      /* Si llega aquí es que aceptó el PDF, $workspace['paso04'], entonces procedemos a realizar los pasos finales:
       * 1> Firmas en fotos random
       * 2> Efecto Escaneo
       * 3> Foliación
       */
      $documento->json_save($workspace);
      return redirect('/expediente/' . $cotizacion->id . '/paso04');
    }

    public function parallelStatus(Request $request, Cotizacion $cotizacion) {
      $documento = $cotizacion->documento();
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
    public function descargarTemporal2(Request $request, Cotizacion $cotizacion, $file) {
      $request->file = $file;
      return $this->descargarTemporal($request, $cotizacion);
    }
    public function descargarTemporal(Request $request, Cotizacion $cotizacion) {
      /*
      Usado en el PASO02 
      */
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      $file   = $request->file;

      if(empty($file)) {
        exit(11);
      }
      $dir = $documento->folder_workspace();

      $root = $dir . $file;

      if(!file_exists($root)) {
        echo "404;" . $root;
        exit;
      }
      return \Response::file($root);
    }
    public function actualizar(Cotizacion $cotizacion, StoreFileRequest $request ){

      $cid = $request->input('cid');
      $documento = $cotizacion->documento();
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
}
