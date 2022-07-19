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
use App\EmpresaEtiqueta;
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
      dd($request->all());
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
    public function actualizar_imagen( StoreFileRequest $request, Empresa $empresa){
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
              $files[] ="https://sig.creainter.com.pe/static/temporal/".$folderName ."/". $file ;

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
      if( isset($_GET["_update"]) ){
        if($request->hasFile("value")){
          

          if ( $request->_update == "logo_head" ){
            $fileName = "LogoHead_" . $empresa->seudonimo . "_" . $empresa->id . ".png" ;     
            $destino_cloud ="GRAFICOS/".$fileName; 
            
            $request->value->move(public_path('storage') , $fileName);

            Helper::gsutil_cp( public_path('storage') . "/" . $fileName, config('constants.ruta_storage') . $destino_cloud);
            $empresa->logo_head = $destino_cloud;
            $empresa->save();
            //unlink("/tmp/".$fileName);
            return response()->json([ "status" =>true, "ruta" => public_path('storage'). "/" . $fileName, "ruta_cloud" =>  config('constants.ruta_storage') . $destino_cloud ]);  
          }  

          if( $request->_update == "logo_central" ){
            $fileName = "LogoCentral_" . $empresa->seudonimo . "_" .$empresa->id . ".png" ;     
            $destino_cloud = "GRAFICOS/". $fileName; 
            $request->value->move( public_path('storage'),  $fileName);
            Helper::gsutil_cp( public_path('storage') ."/" . $fileName, config('constants.ruta_storage') .  $destino_cloud);
            $empresa->logo_central = $destino_cloud;
            $empresa->save();
            //unlink("/tmp/".$fileName);
            return response()->json([ "status" =>true]   );  
          }
        }
      }

      if ( isset($request->folder_firmas) &&  !empty($request->folder_firmas)  ) {
        
        $request->merge( [
          'nombre' => "Firma " . $empresa->seudonimo,
          'archivo'  => $request->archivo_firmas,
          'tipo' => "FIRMA",
          'folder' =>  $request->folder_firmas,
          'empresa_id' =>  $empresa->id
        ]);

        app( DocumentoController::class )->store(
          $request    
        );  

        unset($request->folder_firmas);

      }
      
      if (isset($request->folder_sellos)) {

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

        unset( $request->folder_sellos);
      }
      if( isset($empresa->es_agente_retencion ) ) {
        $empresa->es_agente_retencion = $request->boolean('es_agente_retencion');
      }

      $empresa->update($request->all());
      $empresa->log( 'editado', null );
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
      $this->viewBag['empresa'] = $empresa;
      $this->viewBag['etiquetas'] = $etiquetas;
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
     public function etiqueta_verificar(){

       $etiquestas = Etiqueta::whereNotNull('verificada_el')->whereNotNull('rechazado_el')->first();     
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

     public function tags(){
       $empresas = Empresa::where('tenant_id', Auth::user()->tenant_id)-> get();  
       $empresa_etiquetas = Etiqueta::empresas()->paginate(15);
       //dd( $empresa_etiquetas );
       $this->viewBag['breadcrumbs'][] = [ 'name'=> 'Etiquetas' ]; 
       $this->viewBag['etiquetas'] = $empresa_etiquetas;
       $this->viewBag['empresas'] = $empresas;
       return view('empresas.tags', $this->viewBag );
     }

     public function tags_empresa(Empresa $empresa ){
       $etiquetas = EmpresaEtiqueta::with('etiqueta','empresa')->where('empresa_id',$empresa['id'])->get();   

       $this->viewBag['breadcrumbs'][] = ['name' => $empresa->razon_social ];
       $this->viewBag['empresa'] = $empresa;
       $this->viewBag['etiquetas'] = $etiquetas;

       return view('empresas.tag_empresa', $this->viewBag );

     }
     public function tagCreate( Request $request, Etiqueta $etiqueta, Empresa $empresa ) {
       $etiqueta = Etiqueta::nuevo($request->nombre);
       $etiqueta->solicitado_el = DB::raw('now()');
       $etiqueta->solicitado_por = Auth::user()->id;
       $etiqueta->aprobado_el = DB::raw('now()');
       $etiqueta->aprobado_por = Auth::user()->id;
       EmpresaEtiqueta::create([ 'tenant_id' => Auth::user()->tenant_id, 'empresa_id' => $request->input('empresa_id'), 'etiqueta_id' => $etiqueta->id , 'tipo' => $request->input('tipo') ]);
       return response()->json([ 'success'=> true , 'id' => $etiqueta->id ]);
     }
     
     public function tagDelete(Request $request ){
       $etiqueta = EmpresaEtiqueta::where('empresa_id',$request->input('empresa_id') )->where( 'etiqueta_id', $request->input('etiqueta_id') )->delete();  
      //$etiqueta->delete(); 
      return response()->json([ 'success'=> true  ]);
     }

     public function observacion(Request $request, Empresa $empresa ) {
       $empresa->log('texto',$request->input('texto'));
       return back();
     }
}
