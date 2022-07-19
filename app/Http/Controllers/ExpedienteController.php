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
      $workspace = $cotizacion->json_load();
      $cotizacion->elaborado_por   = Auth::user()->id;
      $cotizacion->elaborado_desde = DB::raw('now()');
      $cotizacion->elaborado_step  = 1;
      $cotizacion->json_save($workspace);

      $cotizacion->log('EXPEDIENTE/INICIO', 'Se inició la elaboración del Expediente');
      return redirect('/expediente/'. $cotizacion->id . '/paso01');
    }

    public function paso01(Cotizacion $cotizacion) {
      $plantillas = Documento::plantillas();
      $workspace = $cotizacion->json_load();
      $licitacion = $cotizacion->oportunidad()->licitacion();
      $empresa = $cotizacion->empresa()->toArray();

      if(!empty($workspace['inputs'])) {
        $workspace['inputs'] = array_merge($workspace['inputs'], $empresa);
      } else {
        $workspace['inputs'] = $empresa;
      }
      // echo "<pre>";print_r($workspace);exit;
      $cotizacion->json_save($workspace);
      return view('expediente.paso01', compact('cotizacion','licitacion','workspace','plantillas'));

    }

    public function paso01_store(Cotizacion $cotizacion, Request $request) {

      $workspace = $cotizacion->json_load();
      $workspace['paso01'] = $_POST['anexos'] ?? [];
      $workspace['paso02'] = [];

      $dir_tmp = $cotizacion->folder_workspace();
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
          'uri'            => $cotizacion->folder_workspace(true) . $doc->filename,
          'timestamp'      => time(),
        ];
      }
//      echo "<pre>";print_r($workspace);exit;
      $cotizacion->json_save($workspace);
      $cotizacion->elaborado_por   = Auth::user()->id;
     // $cotizacion->elaborado_desde = DB::raw('now()');
      $cotizacion->elaborado_step  = 2;
      $cotizacion->save();
      //$cotizacion->log('EXPEDIENTE/PASO01', 'Se ha iniciado con el paso 1');
      return redirect('/expediente/' . $cotizacion->id . '/paso02');

    }

    public function paso02(Cotizacion $cotizacion) {
      $workspace = $cotizacion->json_load();
      $licitacion = $cotizacion->oportunidad()->licitacion();
      return view('expediente.paso02', compact('cotizacion','licitacion','workspace'));
    }

    public function paso02_store(Cotizacion $cotizacion, Request $request) {
      $workspace = $cotizacion->json_load();
      /* Aquí llega los words finales, para ser convertidos en PDF */
      /* Convertimos en PDF cada anexo y */

      $workspace['paso03'] = array();

      if(!empty($workspace['parallel'])) {
        //$finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);
        /*if(!$finished) {
          return redirect('/expediente/' . $cotizacion->id . '/' . $workspace['method']);
      }*/
      }

      $order = 0;
      $commands = [];

      foreach($workspace['paso02'] as $id => $file ) {
        $input   = $file['root'];
        $output  = Helper::replace_extension($file['root'], 'pdf');
        $outputd = dirname(Helper::replace_extension($file['root'], 'pdf'));
        $thumb   = Helper::replace_extension($file['root'], 'jpg');
        $thumb_0 = Helper::replace_extension($file['root'], 'jpg', '-0');
        $thumb_r = Helper::replace_extension($file['root'], 'jpg', '-*');

        exec('/bin/rm ' . $output);
        exec('/usr/bin/libreoffice --convert-to pdf ' . $input . ' --outdir ' . $outputd);
        #exec('/usr/bin/convert -alpha remove -density 150 '.  $output . ' -quality 100 '. $thumb);
        #exec('/bin/mv ' . $thumb . ' ' . $thumb_0);

        $metadata = Helper::metadata($output);
        /*$documento = Documento::nuevo([
          'tipo'           => $file['tipo'],
          'es_plantilla'   => false,
          'generado_de_id' => $id,
          'archivo'        => Helper::replace_extension($file['root'], 'pdf'),
          'folio'          => $metadata['Pages'],
        ]);*/

        $workspace['paso03'][$id. '/n']  = static::formatoCard([
          'orden'     => $order,
          'hash'      => uniqid(),
          'page'      => 0,
          'folio'     => $metadata['Pages'],
          'tipo'      => $file['tipo'],
          'rotulo'    => $file['rotulo'],
          'archivo'   => Helper::replace_extension($file['root'], 'pdf'),
          'root'      => Helper::replace_extension($file['root'], 'pdf'),
          'imagen'    => Helper::replace_extension($file['root'], 'jpg', '-0'),
          'is_part'   => false,
          'timestamp' => time(),
        ]);

        $order++;
      }
      /*$pid = Helper::parallel_command($commands);
      $workspace['parallel'] = [
        'method' => 'paso03',
        'pids'   => $pid,
      ];*/

      $cotizacion->json_save($workspace);
      $cotizacion->elaborado_por   = Auth::user()->id;
      $cotizacion->elaborado_step  = 3;
      $cotizacion->save();


      if(empty($cotizacion->documento_id)) {
        $doc = Documento::nuevo([
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
          'elaborado_json' => json_encode($workspace)
        ]);
        $cotizacion->documento_id = $doc->id;
        $cotizacion->save();
      } else {
        $doc = Documento::find($cotizacion->documento_id);
        $doc->directorio     = trim($cotizacion->folder(true), '/');
        $doc->elaborado_json = json_encode($workspace);
        $doc->save();
      }

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
      $oportunidad = $cotizacion->oportunidad();
      return view('expediente.paso03', compact('oportunidad' ,'workspace','cotizacion','documento'));
    }

    public function paso03_store(Cotizacion $cotizacion, Request $request) {

      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      $folios = 0;
      $commands = []; 
      $commands[] = 'sleep 2';
      $commands[] = 'echo "Se ha iniciado el proceso..."';

      $estampados = [];
      $temp = EmpresaFirma::porEmpresa($cotizacion->empresa_id, 'FIRMA');
      if(!empty($temp)) {
        $temp = array_map(function($n) {
          return gs(config('constants.ruta_storage') . $n['archivo']);
        }, $temp);
        $estampados['firma_original'] = $temp;
      }
      $temp = EmpresaFirma::porEmpresa($cotizacion->empresa_id, 'VISADO');
      if(!empty($temp)) {
        $temp = array_map(function($n) {
          return gs(config('constants.ruta_storage') . $n['archivo']);
        }, $temp);
        $estampados['visado_original'] = $temp;
      }
      $pedir_estampado = function($tipo) use(&$estampados) {
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
            $output = $cotizacion->folder_workspace() . $file['hash'] . '-%d.pdf';

            $commands[] = 'echo "Proceso de separación de PDF"';
            $commands[] = "/usr/bin/pdfseparate '" . $input . "' '" . $output . "'";

            $workspace['paso03'][$key]['root'] = range(0, $file['folio'] - 1);
            $workspace['paso03'][$key]['root'] = array_map(function($n) use ($file, $cotizacion) {
              return $cotizacion->folder_workspace() . $file['hash'] . '-' . ($n + 1) . '.pdf';
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
            $output = $cotizacion->folder_workspace() . Helper::file_name(Helper::replace_extension($file['hash'], 'pdf', '-%d'));
            $commands[] = "/usr/bin/pdfseparate '" . $input . "' '" . $output . "'";
          }
          $workspace['paso03'][$key]['root'] = $cotizacion->folder_workspace() . $file_page;
#          continue;
        }

        if(!empty($file['estampados']['firma'])) {
          foreach($file['estampados']['firma'] as $pp => $ff) {
            //$input  = config('constants.ruta_storage') . Helper::replace_extension($file['archivo'], 'pdf', '-' . ($pp + 1));
            $input  = $cotizacion->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $output = $cotizacion->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $sello  = $pedir_estampado('firma');
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
            $input  = $cotizacion->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $output = $cotizacion->folder_workspace() . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $sello  = $pedir_estampado('visado');
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

      $dir = $cotizacion->folder_workspace();

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

      $cotizacion->elaborado_por   = Auth::user()->id;
      $cotizacion->elaborado_step  = 4;
      $cotizacion->save();

      $documento->archivo       = 'tenant-' . Auth::user()->tenant_id . '/' . $filename;
      $documento->filename      = Helper::replace_extension($documento->rotulo, 'pdf');
      $documento->documentos_id = '{' . implode(',', $documentos_ids) . '}';
      $documento->folio         = $folios;
//      $documento->directorio    = trim($cotizacion->folder(true), '/');
      $documento->filesize      = 10000;#filesize($output_final);
      $documento->elaborado_por    = Auth::user()->id;
      $documento->elaborado_hasta = DB::raw('now()');

      $workspace['documento_final'] = 'https://sig.creainter.com.pe/static/cloud/' . $documento->archivo . '?t=' . time();

      $documento->json_save($workspace);

      $cotizacion->log('EXPEDIENTE/FIN', 'Se finalizó la elaboración del Expediente de ' . $folios . ' páginas.');

      return redirect('/expediente/' . $cotizacion->id . '/paso04');
    }
    public function paso04(Cotizacion $cotizacion) {
      $documento = $cotizacion->documento();
      $workspace = $documento->json_load();

      return view('expediente.paso04', compact('workspace','cotizacion','documento'));
      /*
       * AQUI LLEGA FINALIZADO, O EN PROCESO Y ESO DEBEMOS VERIFICAR CON AJAX
       * ASI MISMO IR MOSTRANDO EL LOG PARA QUE EL USUARIO LOGRE VER ALGO DEL AVANCE...
       * NO DEBERÍA EXISTIR OTRO PASO....
       */
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
      $workspace = $cotizacion->json_load();
      $file   = $request->file;

      if(empty($file)) {
        exit(11);
      }
      $dir = $cotizacion->folder_workspace();

      $root = $dir . $file;

      if(!file_exists($root)) {
        echo "404;" . $root;
        exit;
      }
      return \Response::file($root);
    }

    public function view( Cotizacion $cotizacion ){

    }

    public function show($id)
    {

    }

    private static function formatoCard($x) {
      $default = [
        'documento' => null,
        'imagen' => null,
        'estampados' => [
          'visado' => [],
          'firma'  => [],
        ],
      ];
      if(!empty($x['is_part'])) {
        $default['estampados']['visado'][$x['page']] = [
          'x' => rand(10000, 20999) / 100000,
          'y' => rand(85000, 92999) / 100000,
        ];
      } else {
        for($i = 0; $i < $x['folio']; $i++) {
          $default['estampados']['visado'][$i] = [
            'x' => rand(10000, 20999) / 100000,
            'y' => rand(85000, 92999) / 100000,
          ];
        }
      }
      return array_merge($default, $x);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function actualizar(Cotizacion $cotizacion, StoreFileRequest $request ){

      $cid = $request->input('cid');

      $workspace = $cotizacion->json_load();
      if(!isset($workspace['paso02'][$cid])) {
        return '404:' . $cid;
      }
      $card = $workspace['paso02'][$cid];
      $dir = $cotizacion->folder_workspace();
      $destino = $card['root'];

      $request->archivo->move($dir, $card['filename']);

      $meta = Helper::metadata($destino);

      $workspace['paso02'][$cid]['folio'] = $meta['Pages'];

      $cotizacion->json_save($workspace);

      return response()->json(['status' => true]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
