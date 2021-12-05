<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Contacto;
class ContactoController extends Controller {

  protected $viewBag = [];
  public function __construct(){
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/contactos", "name" => "Contactos" ]
    ];
  }
   
  public function index(Request $request) {
    $search = $request->input('search');
    if(!empty($search)){
      $listado = Contacto::search($search)->paginate(15)->appends(request()->query());
    } else {
      $listado = Contacto::where('eliminado', false )->orderBy( 'id', 'desc')->paginate(15)->appends(request()->query());
    }
    return view('contactos.index', ['listado' => $listado]);
  }

  public function show( Request $request, Contacto $contacto ) {
     $cliente = $contacto->cliente();
     $breadcrumbs[] = [ 'name' => "Detalle Contacto" ];
     return view( 'contactos.show'  , compact('contacto', 'cliente','breadcrumbs'));
  }
  
  public function create() {
    $this->viewBag['contacto'] = new Contacto(); 
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Nuevo Contacto" ];
    return view('contactos.add', $this->viewBag );
  }
  
  public function store(Request $request,Contacto  $contacto ) {
    $contacto->fill($request->all());
    $contacto->save();
    $contacto->log( 'creado');
    return response()->json([ 
      'status' => "success",
      'data' => [
        "value" => $contacto->nombres . " " . $contacto->apellidos,
        "id" => $contacto->id 
      ],
      'redirect' => '/contactos'
    ]);
  }

  public function edit(Request $request, Contacto $contacto) {
    $this->viewBag['contacto'] = $contacto;
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Editar Contacto" ]; 
    return view('contactos.edit',$this->viewBag );    
  }

  public function update( Request $request,Contacto  $contacto  ) {
    $contacto->update($request->all());
    $contacto->log('editado');
    return response()->json([ 
      'status' => true,
      'redirect' => '/contactos',
    ]);
  }

  public  function destroy(Contacto $contacto  ){
    $contacto->eliminado = true;
    $contacto->save();
    $contacto->log('eliminado');    
    return response()->json(['status'=> true , 'refresh' => true  ]); 
  }

  public function autocomplete(Request $request) {
    $term = $request->input('query');
    $data = Contacto::search($term)->selectRaw(" contacto.id, concat_ws(' ',contacto.nombres, contacto.apellidos) as value")->get();
    return response()->json($data);
  }
  public function observacion(Request $request, Contacto $contacto) {
    $contacto->log('texto',$request->input('texto'));
    return back();
  }
  public function fast( Contacto $contacto ){
    return view( 'contactos.fast', [ 'contacto' => $contacto ]); 
  }

}
