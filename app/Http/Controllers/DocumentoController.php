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
use App\Helpers\Helper;
use App\Cotizacion;

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
    return view('documento.index', ['listado' => $listado]);
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

   $cotizacion_id = $request->get("cotizacion_id");
   $orden = $request->get("order");
   $plantilla = null;

   if(!empty( $request->get("documento_id"))) {
     $documento = Documento::find($request->get("documento_id"));
   }

   if(!empty($request->get("generado_de_id"))) {
     $plantilla = Documento::find($request->get("generado_de_id"));
     $plantilla->generado_de_id = $request->get("generado_de_id");

     $documento = new Documento();
     $documento->fill($plantilla->toArray());
   }

   return view('documento.form', compact('plantilla','documento','orden','cotizacion_id' ) );

  }  

  public function store(StoreFileRequest $request)
  {
    $data = $request->input();
    $orden = $request->orden;
      if(!empty($request->generado_de_id)) {
        $plantilla = Documento::find($request->generado_de_id);
        if(empty($plantilla)) {
          exit(11);
        }
       if (!empty($request->cotizacion_id )) {
         $cotizacion   = Cotizacion::find($request->cotizacion_id);
         $destino_tmp  = Helper::fileTemp('docx');
         $docx         = $plantilla->generar_documento($cotizacion, $data, $destino_tmp);
         $filename_tmp = Helper::file_name(Helper::replace_extension($destino_tmp, 'pdf'));
         $filename     = Helper::replace_extension($plantilla->filename, 'pdf', '-' . uniqid());
         $ruta_pdf     = $cotizacion->oportunidad()->folder(true) .  'EXPEDIENTE/';
         $path_pdf     = config('constants.ruta_storage') .  $ruta_pdf;
         $destino_pdf  = $path_pdf . $filename;

         exec("/usr/bin/libreoffice --convert-to pdf '" . $destino_tmp . "' --outdir " . $path_pdf);
         exec("/bin/mv '" . $path_pdf . $filename_tmp . "' '" . $path_pdf . $filename . "'");

         $data['es_plantilla']   = false;
         $data['generado_de_id'] = $request->generado_de_id;
         $data["archivo"] = $ruta_pdf . $filename;
         $data['filename'] = $filename;
         $meta = Helper::metadata($destino_pdf);
         $data["folio"] = $meta["Pages"];

         $documento = Documento::nuevo($data);

         if ( $request->ajax() ) {
           return response()->json(['status' => true, 'eval' => 'agregarDocumento('.$documento->id . ','. $orden . ',true)']); 
         } else {
           echo "404";
           exit;
         }
       } else {
         exit(22);
       }
     }

      $fileName = auth()->id() . '_' . time() . '.'. $request->archivo->extension();
      $type = $request->archivo->getClientMimeType();
      $size = $request->archivo->getSize();

      $destino = public_path('storage/' . $request->tipo) . '/' . $fileName;
      $request->archivo->move(public_path('storage/' . $request->tipo), $fileName);

      $meta = Helper::metadata($destino);

      $data['archivo'] = $request->tipo . '/' . $fileName;
      $data['folio']   = $meta['Pages'] ?? 1;
      $data['formato'] = strtoupper($request->archivo->extension());

      $doc = Documento::nuevo($data);

      if(in_array($doc->tipo, ['VISADO','FIRMA'])) {
        $carpeta = uniqid();
        exec("/bin/pdf-split-sellos '" . config('constants.ruta_storage') . $doc->archivo . "' '" . $carpeta . "'");
        $path = '/tmp/' . $carpeta . '/';
        $files = array_diff(scandir($path), array('.', '..'));

        foreach($files as $k => $f) {
          $output = 'FIRMAS/' . strtolower($doc->tipo) . '_' . $doc->empresa_id . '_' . $k . '.png';
          rename($path . $f, config('constants.ruta_storage') . $output);
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

  public  function destroy(Documento $documento  ){
    $documento->eliminado = true;
    $documento->save();
    $documento->log('eliminado');    
    return response()->json(['status'=> true , 'refresh' => true  ]); 
  }
  public function generarImagen(Request $request, Documento $documento) {
    $page   = $request->get('page');
    $input  = config('constants.ruta_storage') . $documento->archivo;
    $name   = 'thumb_' . md5($documento->id . '-' . $page) . '.jpg';
    $output = config('constants.ruta_temporal') . $name;
//echo $output;exit;
    if(!file_exists($input)){
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
}
