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
  public function pruebas(Request $request, Oportunidad $oportunidad) {
    return response()->json([
      'status'   => false,
      'disabled' => true,
      'message'  => 'No es posible registrar',
      'label'    => 'No es posible eso..',
      'refresh'  => true,
    ]);
  }
  public function create(Request $request)
  {
    $oportunidad = new Oportunidad;
    $oportunidad->rotulo = '';
    return view( $request->ajax() ? 'oportunidad.fast' : 'oportunidad.create', compact( 'oportunidad'));
  }
  public function store(Request $request)
  {
    $data        = $request->all();
    $separacion  = Oportunidad::crearLibre($data['empresa_id']);
    $oportunidad = Oportunidad::find($separacion->id);
    $oportunidad->update($data);

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
    $this->viewBag['breadcrumbs'][] = ['name' => 'Editar oportunidad' ];
    $this->viewBag['oportunidad'] =  $oportunidad;
    return view('oportunidad.edit', $this->viewBag);
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
  public function favorito(Request $request, Oportunidad $oportunidad)
  {
    if(empty($oportunidad->es_favorito)) {
      $oportunidad->favorito();
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Oportunidad en Favoritos!',
        'message'  => 'Oportunidad ha sido registrada como favorito',
        'refresh'  => false,
        'class'    => 'success',
      ]);
    } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Oportunidad ya es favorita',
        'message'  => 'Ya está en Favoritos anteriormente.',
        'refresh'  => true,
        'class'    => 'warning',
      ]);
    }
  }
  public function aprobar(Request $request, Oportunidad $oportunidad)
  {
    if(!empty($oportunidad->aprobado_el)) {
      $oportunidad->aprobar();
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Oportunidad Aprobada!',
        'message'  => 'Oportunidad ha sido registrada como aprobada',
        'refresh'  => true,
        'class'    => 'success',
      ]);
    } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Oportunidad ya aprobada',
        'message'  => 'Ya fue aprobada anteriormente.',
        'refresh'  => false,
        'class'    => 'warning',
      ]);
    }
  }
  public function revisar(Request $request, Oportunidad $oportunidad)
  {
    if(empty($oportunidad->revisado_el)) {
      if(empty($oportunidad->montos_variacion())) {
        return response()->json([
          'status'  => false,
          'message' => 'Debe cotizar la Oportunidad',
        ]);
      }
      $oportunidad->revisar();
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Oportunidad Revisada!',
        'message'  => 'Oportunidad ha sido registrada como revisada',
        'refresh'  => false,
        'class'    => 'success',
      ]);
    } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Oportunidad ya revisada',
        'message'  => 'Ya fue revisada anteriormente.',
        'refresh'  => false,
        'class'    => 'warning',
      ]);
    }
  }
  public function rechazar(Request $request, Oportunidad $oportunidad)
  {
    $motivo = $request->input('value');

    if(empty($motivo)) {
      return response()->json([
        'status'  => false,
        'message' => 'Debe indicar el motivo',
      ]);
    }
    $oportunidad->rechazar($motivo);
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Rechazado!',
        'message'  => 'Se ha rechazado correctamente.',
      ]);
  }

  public function archivar(Request $request, Oportunidad $oportunidad)
  {
    $motivo = $request->input('value');
    if(empty($motivo)) {
      return response()->json([
        'status'  => false,
        'message' => 'Debe indicar el motivo',
      ]);
    }
    $oportunidad->archivar($motivo);
    if($request->ajax()) {
      return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Archivado!',
        'message'  => 'Se ha realizado registro con éxito.',
        'data'     => $oportunidad
      ]);
    } else {
      return redirect('/oportunidades');
    }
  }
  public function interes(Request $request, Oportunidad $oportunidad, Empresa $empresa) {
    $oportunidad->registrar_interes($empresa);
    return response()->json([
        'status'   => true,
        'disabled' => true,
        'label'    => 'Interesante!',
        'message'  => 'Se ha realizado registro con éxito.',
        'refresh'  => true,
      ]);
  }
}
