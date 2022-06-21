<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oportunidad;
use App\OportunidadLog;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use Illuminate\Support\Facades\DB;
use App\Cotizacion;
use App\Licitacion;
use App\Proyecto;
use App\Helpers\Chartjs;
use App\Helpers\Helper;

class OportunidadController extends Controller {
  
  protected $viewBag;

  public function __construct() {
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/proyectos", "name" => "Oportunidades" ]
    ];
  }
  public function index(Request $request)
  {
      $search = $request->input('search');
      if(!empty($search)) {
          $listado = Oportunidad::search($search)->selectRaw('licitacion.*,  empresa.* ,oportunidad.*')->paginate(15)->appends(request()->query()) ;
      } else {
          $listado = Oportunidad::list()->paginate(15)->appends(request()->query());
      }

      $this->viewBag['listado'] = $listado;

      return view('oportunidad.index', $this->viewBag );
  }
  public function create(Request $request)
  {
    $oportunidad = new Oportunidad;
    $oportunidad->rotulo = '';
    return view( $request->ajax() ? 'oportunidad.fast' : 'oportunidad.create', compact( 'oportunidad'));
  }
  public function store(Request $request)
  {
    $data = $request->all();
    $data['tenant_id'] = Auth::user()->tenant_id;
    $data['aprobado_el'] = DB::raw('now');
    $data['aprobado_por'] = Auth::user()->id;
    $oportunidad = Oportunidad::create($data)->fresh();
    if($request->ajax()) {
      return response()->json([ 'status' => true , 'data' => [
        'id'    => $oportunidad->id,
        'value' => $oportunidad->rotulo()
      ] ]);
    }
    return response()->json([ 'status' => true , 'redirect' => '/oportunidades']);
  }
  public function show( Oportunidad $oportunidad )
  {
    $contacto = $oportunidad->contacto(); 
    return view('oportunidad.show', compact('oportunidad'));
  }
  public function proyecto(Request $request, Cotizacion $cotizacion, Proyecto $proyecto ){
     $proyecto->oportunidad_id = $cotizacion->oportunidad_id;
     $proyecto->empresa_id     = $cotizacion->empresa_id;
     $proyecto->cotizacion_id   = $cotizacion->id;
     $proyecto->codigo = $proyecto::generarCodigo();
     $proyecto->nombre = strtolower($cotizacion->oportunidad()->licitacion()->rotulo);   
     //dd($cotizacion->oportunidad()->licitacion()->rotulo );
     $proyecto->save();
     return redirect()->route( 'proyecto.edit', [ 'proyecto' => $proyecto->id ]);
  }
  public function cerrar(Request $request, Oportunidad $oportunidad) {
    $oportunidad->conclusion_el = DB::raw('now()');
    $oportunidad->conclusion_por = Auth::user()->id;
    $oportunidad->save();
    return redirect()->route('licitaciones.show', ['licitacion' => $oportunidad->licitacion_id]);
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
  public function edit(Oportunidad $oportunidad)
  {
      return view('oportunidad.edit', compact('oportunidad'));
  }
  public function update(Request $request, Oportunidad $oportunidad )
  {
    $data = $request->all();
    if($oportunidad->estado == 3) {
      if(!empty($data['_update'])) {
        if(!empty($oportunidad->{$data['_update']})) {
          return response()->json([ 'status' =>  false , 'message' => 'Oportunidad Cerrada' ]);
        }
      }
    }
    if(!empty($data['_update'])) {
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }
    
    $oportunidad->updateData($data);
#    $oportunidad->cliente_id = $request->input('cliente_id');
#    $oportunidad->save();
    //dd($oportunidad);
    return response()->json([ 'status' =>  true , 'redirect' => '/oportunidades' ]);
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Oportunidad $oportunidad )
    {
      $oportunidad->eliminado = date('Y-m-d h:i:sa');
      $oportunidad->save();
      $oportunidad->log('eliminado');
      return response()->json(['status'=> true , 'refresh' => true  ]);
    }
   public function autocomplete(Request $request) {
     $query = $request->input('query');
     $data = Oportunidad::search($query)
       ->select(DB::raw("COALESCE(oportunidad.rotulo, licitacion.rotulo, licitacion.descripcion, licitacion.nomenclatura) as value"),'oportunidad.id');
     if(isset($_GET['directas'])) {
       $data->whereRaw('osce.oportunidad.licitacion_id IS NULL');
     }
     return Response()->json($data->get());
   }
   public function search_autocomplete(Request $request ){
     $query = $request->input('query');

     $data = Oportunidad::search($query)->select(DB::raw("oportunidad.codigo as value"),'oportunidad.id');

     return Response()->json( $data->get() );
   
   }
}
