<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use App\Cliente;
use App\Contacto;
use App\Empresa;
use App\Etiqueta;
use App\Persona;
use App\Ubigeo;
use App\Helpers\Helper;
use App\Actividad;
use App\Documento;
use App\EmpresaEtiqueta;
use App\EmpresaFirma;
use Auth;

class EmpresaController extends Controller {

    protected $viewBag = [];
    public function __construct()
    {
      $this->middleware('auth');
      $this->viewBag['pageConfigs'] = ['pageHeader' => true];
      $this->viewBag['breadcrumbs'] = [
        ["link" => "/dashboard", "name" => "Home" ],
        ["link" => "/empresas", "name" => "Empresas" ]
      ];
    }
    public function index(Request $request)
    {
      $search = $request->input('search');
      if(!empty($search)) {
        $this->viewBag['listado'] = Empresa::search($search)->paginate(15)->appends(request()->query());
      } else {
          $this->viewBag['listado'] = Empresa::orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
      }
      return view('empresas.index', $this->viewBag);
    }
    public function create(Request $request, Empresa $empresa )
    {
      $this->viewBag['breadcrumbs'][]  = [ 'name' => 'Nueva Empresa' ];
      $this->viewBag['empresa'] = $empresa;
      return view( $request->ajax() ? 'empresas.fast' : 'empresas.create ', $this->viewBag )  ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\lain  $lain
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Empresa $empresa )
    {
      $empresa->fill($request->all());
      $empresa->save();
      
      $empresa->log('creado');
      return response()->json([
        'status' => "success",
        'data' => [
          "value" => $empresa->razon_social,
          "id" => $empresa->id
        ],
        'redirect' => '/empresas'
      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Empresa $empresa)
    {
      $cliente = $empresa->cliente();
      return view('empresas.show', compact('cliente','empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
      /* $empresa = $cliente->empresa();
        if (!empty($empresa->ubigeo_id)) {
            $distrito      = Ubigeo::distrito($empresa->ubigeo_id);
            $departamentos = Ubigeo::departamentos($empresa->ubigeo_id);
            $provincias    = Ubigeo::provincias($empresa->ubigeo_id);
            $distritos     = Ubigeo::distritos($empresa->ubigeo_id);
        } else {
            $distrito      = null;
            $departamentos = Ubigeo::departamentos();
            $provincias    = [];
            $distritos     = [];
        }*/
        return view('empresas.edit', compact('cliente','empresa', 'distrito', 'departamentos', 'provincias', 'distritos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */

    public function firmas_eliminar(Request $request, Empresa $empresa ){
        
        $firmas = EmpresaFirma::porEmpresa($empresa->id, 'FIRMA');
        //dd($firmas);
        foreach( $firmas as $firma ){ 
          Helper::gsutil_rm( config('constants.ruta_storage') . $firma['archivo'] );
          EmpresaFirma::where('id',$firma['id'] )->delete();
          Documento::where('id', $firma['documento_id'] )->delete();  
        }   

        return response()->json(['status' => true ]);
    }


    public function sellos_eliminar(Request $request, Empresa $empresa ){
        
        $sellos = EmpresaFirma::porEmpresa($empresa->id, 'VISADO', 100);
        //dd($firmas);
        foreach( $sellos as $sello ){ 
          //Helper::gsutil_rm( config('constants.ruta_storage') . $firma['archivo'] );
          EmpresaFirma::where('id',$sello['id'] )->delete();
          Documento::where('id', $sello['documento_id'] )->delete();  
        }   

        return response()->json(['status' => true ]);
    }

    public function firmas_sellos_procesar( StoreFileRequest $request, Empresa $empresa ){

      if($request->hasFile("file") ){

        $extension = $request->file->extension();
        $fileName = auth()->id() . '_' . time() . '.'. $extension;
        $folderName =  auth()->id() . '_' . time(); 
        $destino = public_path('storage') . '/' . $fileName;
        $request->file->move(public_path('storage'), $fileName);
        exec("/bin/pdf-split-sellos " . $destino . " ".$folderName );
        //$request->gsutil($request->file, $dirName, $fileName);
        //$request->gsutil( )
        $files = [];
        if($handler = opendir( "/tmp/".$folderName )){
          $index = 1;
          while (false !== ($file = readdir($handler))) {
            if (strpos($file ,'jpg')  || strpos($file,'png')){
              
              //$destino_cloud = "FIRMAS/Firmas_" .$empresa->id . "_". $index. ".png" ; 
              $files[] =$folderName ."/". $file ;

            //Helper::gsutil_cp( "/tmp/".$folderName ."/" . $file, config('constants.ruta_storage') . $destino_cloud);
$index++;
            }
          }
          closedir($handler);
        }  
        return response()->json( [ 'status' =>  true, "data" => $destino , "folder" => $folderName, "files" => $files ] );

      }
    }
     
    public function update(  StoreFileRequest   $request, Empresa $empresa )
    {
      if( $request->_update == "logo_head" && $request->hasFile("value") ){

          $fileName = str_replace( " ", "_", "LogoHead_" . $empresa->seudonimo . "_" . $empresa->id . ".png") ;     
          $destino_cloud ="GRAFICOS/".$fileName; 
          
          $request->value->move(public_path('storage') , $fileName);
          //Helper::gsutil_rm( config('constants.ruta_storage') . $empresa->logo_head );
          Helper::gsutil_cp( public_path('storage') . "/" . $fileName, config('constants.ruta_storage') . $destino_cloud, false );

          $empresa->logo_head = $destino_cloud;
          $empresa->save();
          unlink( public_path('storage') . "/" . $fileName );

          return response()->json([ 'path' => public_path('storage') ]);
          //unset($request->logo_head);
          //$request->request->remove('logo_head');
      }  

      if( $request->_delete == "logo_head" && !empty( $empresa->logo_head )) {
        Helper::gsutil_rm( config('constants.ruta_storage') . $empresa->logo_head );   
        $empresa->logo_head = null;
        $empresa->save();
        return response()->json([ 'status' => true ]);
      } 

      if( $request->_delete == "logo_central" && !empty( $empresa->logo_central )) {
        Helper::gsutil_rm( config('constants.ruta_storage') . $empresa->logo_central );   
        $empresa->logo_central = null;
        $empresa->save();
        return response()->json([ 'status' => true ]);
      } 

      if ( $request->_update == "logo_central" && $request->hasFile("value")) {

          $fileName = str_replace(" ","_", "LogoCentral_" . $empresa->seudonimo . "_" .$empresa->id . ".png") ;     
          $destino_cloud = "GRAFICOS/". $fileName; 
          $request->value->move( public_path('storage'),  $fileName );
          Helper::gsutil_cp( public_path('storage') ."/" . $fileName, config('constants.ruta_storage') .  $destino_cloud, false );

          $empresa->logo_central = $destino_cloud;
          $empresa->save();

          //$pid = Helper::parallel_command($commands);

          return response()->json([ 'path' => public_path('storage')]);

      }
      
      if ( isset($request->folder_firmas) &&  !empty($request->folder_firmas)  ) {
        
        $request->merge( [
          'nombre' => "Firma " . $empresa->seudonimo,
          'archivo'  => $request->archivo_firmas,
          'tipo' => "FIRMA",
          'folder' =>  $request->folder_firmas,
          'empresa_id' =>  $empresa->id
        ]);

        app( DocumentoController::class )->store( $request );  
        return response()->json(['status' => true ]); 
     }
      
      if (isset($request->folder_sellos) && empty( $request->folder_sellos )) {

        $request_doc = $request;
        $request->merge([
          'nombre' => "Visado " . $empresa->seudonimo,
          'archivo'  => $request->archivo_sellos,
          'tipo' => "VISADO",
          'folder' =>  $request->folder_sellos,
          'empresa_id' =>  $empresa->id
        ]) ;

        app( DocumentoController::class )->store(
          $request_doc    
        );  

        return response()->json(['status' => true ]); 
      }
      if( isset($empresa->es_agente_retencion ) ) {
        $empresa->es_agente_retencion = $request->boolean('es_agente_retencion');
      }

      $empresa->update($request->except('logo_head','logo_central'));
      //$empresa->log( 'editado', null );
      return response()->json([
        'status' => "success",
        'redirect' => '/empresas'
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa )
    {
      /* Proceso para eliminar */
      $empresa->eliminado = true;
      $empresa->save();
      $empresa->log('eliminado');
      return response()->json(['status'=> true , 'refresh' => true  ]); 
    }

    public function mis_empresas(){
      $empresas = Empresa::where('tenant_id',Auth::user()->tenant_id )->orderBy('id','asc')->get();
      $this->viewBag['empresas'] = $empresas;
      return view('empresas.misempresas',$this->viewBag );
    }

    public function datos(Empresa $empresa ){
       
      $etiquetas = EmpresaEtiqueta::with('etiqueta','empresa')->where('empresa_id',$empresa->id)->get();   
      $this->viewBag['breadcrumbs'][] = [ 'name' =>  $empresa->razon_social ];
      $this->viewBag['empresa']   = $empresa;
      $this->viewBag['etiquetas'] = $etiquetas;
      $this->viewBag['sellos']    = Helper::unique_multidim_array( EmpresaFirma::porEmpresa( $empresa->id, "VISADO"),'archivo');
      $this->viewBag['firmas']    = Helper::unique_multidim_array( EmpresaFirma::porEmpresa( $empresa->id, "FIRMA"), 'archivo')  ;
      //dd($this->viewBag);
      // dd($etiquetas);
      return view('empresas.ficha',$this->viewBag );  
    }

    public function addRepresentante(Request $request, Cliente $cliente)
    {
        $persona = Persona::updateOrCreate([
            'tipo_documento_id' => $request->input('tipo_documento_id'),
            'numero_documento' => $request->input('numero_documento'),
        ], [
            'nombres' => $request->input('nombres'),
            'apellidos' => $request->input('apellidos'),
            'correo_electronico' => $request->input('correo_electronico'),
            'telefono' => $request->input('telefono'),
        ]);

        $contacto = Contacto::updateOrCreate([
            'cliente_id' => $cliente->id,
            'persona_id' => $persona->id,
        ], [
            'cliente_id' => $cliente->id,
            'persona_id' => $persona->id,
            'correo_electronico' => $request->input('correo_electronico'),
            'telefono' => $request->input('telefono'),
        ]);

        return back();
     }

     public function delRepresentante(Request $request, Cliente $cliente, Contacto $contacto)
     {
        $contacto->delete();
        return back();
     }

     public function autocomplete(Request $request) {
       $query = $request->input('query');
       $data = Empresa::search($query)
         ->selectRaw('(CASE WHEN osce.cliente.id IS NULL THEN osce.empresa.razon_social ELSE CONCAT(\'=> \', COALESCE(osce.cliente.nomenclatura, osce.empresa.razon_social)) END) as value, osce.empresa.id');
       if(isset($_GET['propias'])) {
         $data->whereRaw('osce.empresa.tenant_id = ' . Auth::user()->tenant_id);
       }
       return Response()->json($data->get());
     }

     public function observacion(Request $request, Empresa $empresa ) {
       $empresa->log('texto',$request->input('texto'));
       return back();
     }
}
