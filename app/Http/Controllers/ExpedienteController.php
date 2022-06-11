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

    public function paso01(Cotizacion $cotizacion) {
      $plantillas = Documento::plantillas();
      $workspace = $cotizacion->json_load();
      $licitacion = $cotizacion->oportunidad()->licitacion();
      $empresa = $cotizacion->empresa()->toArray();

      $workspace['inputs'] = array_merge($workspace['inputs'], $empresa);
//      echo "<pre>";print_r($workspace);exit;
      $cotizacion->json_save($workspace);
      return view('expediente.paso01', compact('cotizacion','licitacion','workspace','plantillas'));

    }

    public function paso01_store(Cotizacion $cotizacion, Request $request) {

      $workspace = $cotizacion->json_load();
      $workspace['paso01'] = $_POST['anexos'];
      $workspace['paso02'] = [];

      $dir = config('constants.ruta_storage') . $cotizacion->oportunidad()->folder(true);
      $dir = Helper::mkdir_p($dir . 'EXPEDIENTE/');

      foreach ($workspace['paso01'] as $key => $value) {
        $doc = Documento::find($key);
        $destino = $dir . $doc->filename;
        $doc->generar_documento($cotizacion, $workspace["inputs"], $destino);
        $workspace['paso02'][$key] = [
          'generado_de_id' => $doc->id,
          'tipo'           => $doc->tipo,
          'nombre'         => $doc->tipo,
          'rotulo'         => $doc->rotulo,
          'filename'       => $doc->filename,
          'root'           => $cotizacion->oportunidad()->folder(true) . 'EXPEDIENTE/' . $doc->filename,
        ];
      }
//      echo "<pre>";print_r($workspace);exit;
      $cotizacion->json_save($workspace);
      $cotizacion->log('EXPEDIENTE/PASO01', 'Se ha iniciado con el paso 1');
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
        $input   = config('constants.ruta_storage') . $file['root'];
        $output  = config('constants.ruta_storage') . Helper::replace_extension($file['root'], 'pdf');
        $outputd = config('constants.ruta_storage') . dirname(Helper::replace_extension($file['root'], 'pdf'));
        $thumb   = config('constants.ruta_storage') . Helper::replace_extension($file['root'], 'jpg');
        $thumb_0 = config('constants.ruta_storage') . Helper::replace_extension($file['root'], 'jpg', '-0');

        $commands[] = '/usr/bin/libreoffice --convert-to pdf ' . $input . ' --outdir ' . $outputd;
        $commands[] = '/usr/bin/convert -alpha remove -density 150 '.  $output . ' -quality 100 '. $thumb;
        $commands[] = '/bin/mv ' . $thumb . ' ' . $thumb_0;

        $metadata = Helper::metadata($input);

        /*$documento = Documento::nuevo([
          'tipo'           => $file['tipo'],
          'es_plantilla'   => false,
          'generado_de_id' => $id,
          'archivo'        => Helper::replace_extension($file['root'], 'pdf'),
          'folio'          => $metadata['Pages'],
        ]);*/

        $workspace['paso03'][$id. '/n']  = $this->formatoCard([
          'orden'   => $order,
          'page'    => 0,
          'folio'   => $metadata['Pages'] ,
          'tipo'    => $file['tipo'],
          'rotulo'  => $file['rotulo'],
          'archivo' => Helper::replace_extension($file['root'], 'pdf'),
          'imagen'  => Helper::replace_extension($file['root'], 'jpg', '-0'),
          'is_part' => false,
        ]);

        $order++;
      }
      $pid = Helper::parallel_command($commands);
      $workspace['parallel'] = [
        'method' => 'paso03',
        'pids'   => $pid,
      ];

      $cotizacion->json_save($workspace);
      $cotizacion->log('EXPEDIENTE/PASO02', 'Se ha iniciado con el paso 2');
      return redirect('/expediente/' . $cotizacion->id . '/paso03');
    }
    public function paso03(Cotizacion $cotizacion) {
      $workspace = $cotizacion->json_load();
      if(isset($_GET['demo'])) {
        echo "<pre>";
        print_r($workspace['paso03']);
        exit;
      }
      $cotizacion->log('EXPEDIENTE/PASO03', 'Se ha iniciado con el paso 3');
      $oportunidad = $cotizacion->oportunidad();
      $entidad = Empresa::find($oportunidad->licitacion()->empresa_id);
      return view('expediente.paso03', compact( 'entidad', 'oportunidad' ,'workspace','cotizacion'));
      /* En este paso renderizamos toda la variable paso03, y cada vez que se saca uno o añade debe afectar solo al paso03 */
    }
    public function paso03_store(Cotizacion $cotizacion, Request $request) {

      $workspace = $cotizacion->json_load();
      $cotizacion->log('EXPEDIENTE/PASO03', 'Se ha iniciado con el paso 3');
      $commands = []; 
      /* Se trabaja los pdf por individuales, realizando el custom */
      $commands[] = 'sleep 2';
      $commands[] = 'echo "Se ha iniciado el proceso..."';


      $estampados = [];
      $temp = EmpresaFirma::porEmpresa($cotizacion->empresa_id, 'FIRMA');
      if(!empty($temp)) {
        $temp = array_map(function($n) {
          return config('constants.ruta_storage') . $n['archivo'];
        }, $temp);
        $estampados['firma_original'] = $temp;
      }
      $temp = EmpresaFirma::porEmpresa($cotizacion->empresa_id, 'VISADO');
      if(!empty($temp)) {
        $temp = array_map(function($n) {
          return config('constants.ruta_storage') . $n['archivo'];
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

      foreach($workspace['paso03'] as $key => $file) {
        if(!$file['is_part']) {
          if(!empty($file['estampados']['firma']) || !empty($file['estampados']['visado'])) {
            $file['hash'] = uniqid();
            $workspace['paso03'][$key] = $file;
            $input  = config('constants.ruta_storage') . $file['archivo'];
            $output = config('constants.ruta_temporal') . $file['hash'] . '-%d.pdf';

            $commands[] = 'echo "Proceso de separación de PDF"';
            $commands[] = "/usr/bin/pdfseparate '" . $input . "' '" . $output . "'";

            $workspace['paso03'][$key]['root'] = range(0, $file['folio'] - 1);
            $workspace['paso03'][$key]['root'] = array_map(function($n) use ($file) {
              return config('constants.ruta_temporal') . $file['hash'] . '-' . ($n + 1) . '.pdf';
            }, $workspace['paso03'][$key]['root']);

          } else {
            $workspace['paso03'][$key]['root'] = config('constants.ruta_storage') . $file['archivo'];
            continue;
          }
        } else {
          $workspace['paso03'][$key]['root'] = config('constants.ruta_storage') . $file['archivo'];
          continue;
        }

        if(!empty($file['estampados']['firma'])) {
          foreach($file['estampados']['firma'] as $pp => $ff) {
            //$input  = config('constants.ruta_storage') . Helper::replace_extension($file['archivo'], 'pdf', '-' . ($pp + 1));
            $input  = config('constants.ruta_temporal') . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $output = config('constants.ruta_temporal') . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $sello  = $pedir_estampado('firma');
            if(file_exists($input) || true) {
              $commands[] = 'echo "Proceso de estampado de pdf"';
              $commands[] = '/bin/estampar ' . $input . ' ' . $sello . ' ' . $ff['x'] . ' ' . $ff['y'] . " '" . $output . "'";
              $workspace['paso03'][$key]['root'][$pp] = $input;
            } else {
              $commands[] = '/bin/noexiste ' . $input;
            }
          }
        }
        if(!empty($file['estampados']['visado'])) {
          foreach($file['estampados']['visado'] as $pp => $ff) {
            $input  = config('constants.ruta_temporal') . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            //$input  = config('constants.ruta_storage') . Helper::replace_extension($file['archivo'], 'pdf', '-' . ($pp + 1));
            $output = config('constants.ruta_temporal') . $file['hash'] . '-' . ($pp + 1) . '.pdf';
            $sello  = $pedir_estampado('visado');
            if(file_exists($input) || true) {
              $commands[] = 'echo "Proceso de estampado de pdf"';
              $commands[] = '/bin/estampar ' . $input . ' ' . $sello . ' ' . $ff['x'] . ' ' . $ff['y'] . " '" . $output . "'";
              $workspace['paso03'][$key]['root'][$pp] = $input;
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
      $dir = config('constants.ruta_storage') . $cotizacion->oportunidad()->folder(true);

      $output = $dir . 'EXPEDIENTE/Propuesta.pdf';
      $output_final = $dir . 'EXPEDIENTE/Propuesta_Seace.pdf';


      /* Unimos los PDFs */
      $commands[] = 'echo "Uniendo los documento en PDF"';
      $commands[] = '/usr/bin/convert -alpha remove -density 200 -quality 100 '. implode(' ', $pdf_individuales) . ' ' . $output;

      /* Ingresando efecto de escaneado */
//      $commands[] = '/usr/bin/convert -density 140 ' . $output . ' -rotate 0.5 -attenuate 0.1 +noise Multiplicative -attenuate 0.01 +noise Multiplicative -sharpen 0x1.0 ' . $output_final;

      $commands[] = '/bin/cp ' . $output . ' ' . $output_final;

      $commands[] = 'echo "Proceso de foliación de PDF"';
      $commands[] = '/bin/pdf-foliar ' . $output_final;

      /*
      echo "<pre>";
      print_r($commands);
      exit;
       */
      //      $meta = Helper::metadata($output_final);
      if(empty($cotizacion->documento_id)) {
        $doc = Documento::nuevo([
          'cotizacion_id'  => $cotizacion->id,
          'oportunidad_id' => $cotizacion->oportunidad_id,
          'licitacion_id'  => $cotizacion->oportunidad()->licitacion_id,
          'es_plantilla'  => false,
          'es_ordenable'  => false,
          'es_reusable'   => false,
          'tipo'          => "EXPEDIENTE",
          'folio'         => 0,
          'rotulo'        => 'Expediente: ' . $cotizacion->oportunidad()->licitacion()->nomenclatura,
          'archivo'       => $cotizacion->oportunidad()->folder(true) .'EXPEDIENTE/Propuesta_Seace.pdf',
          'filename'      => 'Propuesta_Seace.pdf',
          'formato'       => 'PDF',
          'documentos_id' => '{' . implode(',', $documentos_ids) . '}',
        ]);
        $cotizacion->documento_id = $doc->id;
        $cotizacion->save();
      } else {
        $doc = Documento::find($cotizacion->documento_id);
        $doc->documentos_id = '{' . implode(',', $documentos_ids) . '}';
        $doc->save();
      }

      $pid = Helper::parallel_command($commands);
      $workspace['parallel'] = [
        'method' => 'paso04',
        'pids'   => $pid,
      ];
      $workspace["documento_final"] = $doc->archivo;
      $cotizacion->json_save($workspace);

      return redirect('/expediente/' . $cotizacion->id . '/paso04');
    }
    public function paso04(Cotizacion $cotizacion) {
      $workspace = $cotizacion->json_load();
      return view('expediente.paso04', compact('workspace','cotizacion'));
      /*
       * AQUI LLEGA FINALIZADO, O EN PROCESO Y ESO DEBEMOS VERIFICAR CON AJAX
       * ASI MISMO IR MOSTRANDO EL LOG PARA QUE EL USUARIO LOGRE VER ALGO DEL AVANCE...
       * NO DEBERÍA EXISTIR OTRO PASO....
       */
    }
    public function paso04_store(Cotizacion $cotizacion, Request $request) {
      $workspace = $cotizacion->json_load();
      /* Si llega aquí es que aceptó el PDF, $workspace['paso04'], entonces procedemos a realizar los pasos finales:
       * 1> Firmas en fotos random
       * 2> Efecto Escaneo
       * 3> Foliación
       */
      $cotizacion->json_save($workspace);
      return redirect('/expediente/' . $cotizacion->id . '/paso04');
    }
    public function parallelStatus(Request $request, Cotizacion $cotizacion) {
      $workspace = $cotizacion->json_load();
      $finished = Helper::parallel_finished_pool($workspace['parallel']['pids']);

      $log = Helper::parallel_log_pool($workspace['parallel']['pids']);

      return response()->json([
        'status'   => true,
        'finished' => $finished,
        'log'      => $log,
        'data'     => [
          'url'       => 'https://sig.creainter.com.pe/storage/' . $cotizacion->oportunidad()->folder(true) . 'EXPEDIENTE/Propuesta.pdf',
          'url_seace' => 'https://sig.creainter.com.pe/storage/' . $cotizacion->oportunidad()->folder(true) . 'EXPEDIENTE/Propuesta_Seace.pdf',
        ]
      ]);
    }
    public function busquedaDocumentos(Request $request, Cotizacion $cotizacion) {
      $workspace = $cotizacion->json_load();
      $query = $request->input('query');
      if (empty($query)) {
        $resultados = Documento::recomendadas($cotizacion->oportunidad_id);
      } else {
        $resultados = Documento::busqueda($query);
      }
      if(!empty($resultados)) {
        $resultados = $resultados->toArray();
        $resultados = array_map(function($n) {
          if($n['tipo'] == 'CONTRATO') {
            return array_merge($n, [
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

    public function agregarDocumento(Request $request, Cotizacion $cotizacion, Documento $documento) {

      $workspace = $cotizacion->json_load();
      $orden = $request->get('orden');

      $cid = static::workspace_get_id($workspace, $documento->id, 'n');

      $workspace['paso03'][$cid] = $this->formatoCard([
        'cid'     => $cid,
        'id'      => $documento->id,
        'orden'   => sizeof($workspace['paso03']),
        'page'    => 0,
        'tipo'    => $documento->tipo,
        'folio'   => $documento->folio,
        'rotulo'  => $documento->rotulo,
        'archivo' => $documento->archivo,
        'is_part' => false,
      ]);

      if(!$documento->es_reusable) {
        if(!empty($documento->generado_de_id)) {
          unset($workspace['paso03'][$cid]['id']);
          $documento->delete();
        }
      }

      $workspace['paso03'] = $this->workspace_move($workspace['paso03'], $cid, $orden);

      $cotizacion->json_save($workspace);

      return response()->json([
        'status' => true , 
        'orden' => $orden,
        'es_reusable' => $documento->es_reusable,
        'data' => [
          $workspace['paso03'][$cid],
        ]
      ]);
    }
    public function eliminarDocumento(Request $request, Cotizacion $cotizacion) {
      $workspace = $cotizacion->json_load();

      $cid = $request->get('cid');
      unset($workspace['paso03'][$cid]);
      $cotizacion->json_save($workspace);

       return response()->json([
         'status' => true ,
       ]);
    }

    public function view( Cotizacion $cotizacion ){

    }

    public function show($id)
    {

    }

    public function actualizar_orden(Cotizacion  $cotizacion, Request $request) {

      $workspace = $cotizacion->json_load();
      $cid = $request->get('id');
      $orden = $request->get('orden');

      $workspace['paso03'] = $this->workspace_move($workspace['paso03'] , $cid , $orden); 
      $cotizacion->json_save($workspace);
      return response()->json([
        'status' => true,
        'data' => $workspace['paso03']
      ]); 
    }

    public static function workspace_get_id($matrix, $id, $page) {
      return $id . '/' . $page;
    }

    public  function workspace_get_card( $matrix, $cid ) {
      return $matrix[$cid];
    }

    public function workspace_move( $matrix, $cidx, $orden ) {
      
      $o_i = $this->workspace_get_card($matrix, $cidx);

      $o_i = $o_i['orden'];      

      if($o_i == $orden) {
        return $matrix;
      }
      if ( $o_i > $orden ) {
        $cids = $this->workspace_get_range( $matrix, $o_i, $orden );
        foreach($cids as $cid) {
          $c = $this->workspace_get_card($matrix, $cid);
          $c['orden'] += 1;
          $matrix[$cid] = $c;
        }
      } else {
        $cids = $this->workspace_get_range( $matrix, $o_i, $orden);
        foreach($cids as $cid) {
          $c = $this->workspace_get_card($matrix, $cid);
          $c['orden'] -= 1;
          $matrix[$cid] = $c;
        }
      }
      $matrix[$cidx]['orden'] = (int) $orden;
      return $this->workspace_ordenar($matrix);
    }   

    public function workspace_ordenar($matrix) {
      uasort($matrix, function($item1,$item2) {
        return $item1['orden'] - $item2['orden']; 
      });
      $i = 0;
      $matrix = array_map(function($n) use(&$i) {
        $n['orden'] = $i;
        $i++;
        return $n;
      }, $matrix);

      return $matrix;
    }

    public function workspace_get_range($matrix, $o_i, $o_f) {

      $matrix = array_filter($matrix, function($c) use ($o_i, $o_f) {
        if($o_i > $o_f) {
          return $c['orden'] <= $o_i && $c['orden'] >= $o_f;
        } else {
          return $c['orden'] <= $o_f && $c['orden'] > $o_i;
        }
      });
     return array_keys($matrix);
    }

    function visualizar_documento(Request $request, Cotizacion $cotizacion, Documento $documento) {
      $workspace = $cotizacion->json_load();
      $cid = $request->get('cid');
      $card = $workspace['paso03'][$cid];
      return view('expediente.imagen', compact('cotizacion', 'card', 'cid'));   
    }

    public function estamparDocumento(Request $request, Cotizacion $cotizacion) {
      $workspace = $cotizacion->json_load();
      $cid  = $request->get('cid');
      $page = $request->get('page');
      $tool = $request->get('tool');
      $pos_x = $request->get('pos_x');
      $pos_y = $request->get('pos_y');

      $workspace['paso03'][$cid]['estampados'][$tool][$page] = [
        'x' => $pos_x,
        'y' => $pos_y
      ];

      $cotizacion->json_save($workspace);

      return response()->json([
        'status' => true ,
      ]);
    }
    private function formatoCard($x) {
      $default = [
        'documento' => null,
        'imagen' => null,
        'estampados' => [
          'visado' => [],
          'firma'  => [],
        ],
      ];
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
    public function actualizar_archivo(Cotizacion $cotizacion, StoreFileRequest $request ){

      $workspace = $cotizacion->oportunidad()->json_load();

      $doc = Documento::find( $request->get("documento_id") );
      $dir = config('constants.ruta_storage') . $cotizacion->oportunidad()->folder(true);
      $dir = Helper::mkdir_p($dir . 'EXPEDIENTE/');

      $destino = $dir . $doc->filename;

      $request->archivo->move( $dir , $doc->filename );

      $meta = Helper::metadata($destino);
      $doc->folio = $meta['Pages'];

      $workspace['paso02'][$request->get("key")]["folio"] = $meta["Pages"];
      $cotizacion->oportunidad()->json_save($workspace);

      return response()->json( ['status' => true,'data'    ] );
    }
    public function generarImagen(Cotizacion $cotizacion,  Request $request ) {

      $page   = $request->get('page');
      $cid = $request->get("cid");
      $workspace = $cotizacion->json_load();   
      if (!isset($workspace["paso03"][$cid])) {
        exit;
      }
      $card = $workspace["paso03"][$cid];
      if (isset( $card["id"])){
        return app()->call('App\Http\Controllers\DocumentoController@generarImagen', [
          "request" => $request,
          "documento" => Documento::find( $card["id"] )
        ]);
      } 
      $input  = config('constants.ruta_storage') . $card["archivo"];
      $name   = 'thumb_' . md5($cid . '-' . $page) . '.jpg';
      $output = config('constants.ruta_temporal') . $name;

//      dd($workspace["paso03"][$cid]);
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
