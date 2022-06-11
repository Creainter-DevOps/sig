<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Personal;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Auth;

class PersonalController extends Controller {

  protected $viewBag = [];

  public function __construct() {
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/personales", "name" => "Personales" ]
    ];
  }
   
  public function index(Request $request) {
    $search = $request->input('search');
    if(!empty($search)){
      $listado = Personal::search($search)->paginate(15)->appends(request()->query());
    } else {
      $listado = Personal::orderBy( 'id', 'desc')->paginate(15)->appends(request()->query());
    }
    return view('personal.index', ['listado' => $listado]);
  }

  public function show( Request $request, Personal $personal) {
     $breadcrumbs[] = [ 'name' => "Detalle Personal" ];
     return view( 'personal.show'  , compact('personal','breadcrumbs'));
  }
  
  public function create(Request $request, Personal $personal) {
    $this->viewBag['personal'] = new Personal(); 
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Nuevo Personal" ];
    if($request->ajax()) {
      return view( 'personal.fast', [ 'personal' => $personal ]);
    }
    return view('personal.add', $this->viewBag );
  }
  public function store(Request $request)
  {
    $data = $request->input();
    $data['tenant_id'] = Auth::user()->tenant_id;
    Personal::create($data);
    return redirect('/personales');
  } 

  public function edit(Request $request, Personal $personal) {
    $this->viewBag['personal'] = $personal;
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Editar Personal" ]; 
    return view('personal.edit',$this->viewBag );    
  }

  public function update( Request $request,Personal  $personal  ) {
    $personal->update($request->all());
    return response()->json([ 
      'status' => true,
      'redirect' => '/personales',
    ]);
  }

  public  function destroy(Personal $personal  ){
    $personal->eliminado = true;
    $personal->save();
    $personal->log('eliminado');    
    return response()->json(['status'=> true , 'refresh' => true  ]); 
  }

  public function autocomplete(Request $request) {
       $query = $request->input('query');
       $data = Personal::search($query)
         ->selectRaw('osce.personal.nombres as value, osce.personal.id');
       if(isset($_GET['propias'])) {
         $data->whereRaw('osce.personal.tenant_id = ' . Auth::user()->tenant_id);
       }
       return Response()->json($data->get());
     }
}
