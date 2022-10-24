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
          $listado = Oportunidad::search($search);
      } else {
          $listado = Oportunidad::list()->paginate(40)->appends(request()->query());
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
  public function show(Oportunidad $oportunidad) {
    $contacto = $oportunidad->contacto(); 
    return view('oportunidad.show', compact('oportunidad'));
  }
  public function part_licitaciones_similares(Oportunidad $oportunidad) {
    return view('oportunidad.part_licitaciones_similares', compact('oportunidad'));
  }
  public function part_oportunidades_similares(Oportunidad $oportunidad) {
    return view('oportunidad.part_oportunidades_similares', compact('oportunidad'));
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
    $refresh = false;

    if(!empty($data['_update'])) {# && !in_array($data['_update'], ['perdido_por'])) {
      if(!empty($oportunidad->{$data['_update']})) {
        if($oportunidad->estado == 3) {
          return response()->json([
            'status' => false,
            'message' => 'Oportunidad Cerrada'
          ]);
        }
      }
    }
    if(!empty($data['_update'])) {
      if($data['_update'] == 'empresa_id') {
        $refresh = true;
      }
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }
    
    $oportunidad->updateData($data);

    if($request->ajax()) {
      return response()->json([
        'status'  => true ,
        'refresh' => $refresh,
      ]);
    } else {
      return redirect()->route('oportunidades.show', ['oportunidad' => $oportunidad->id]);
    }
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
     // $oportunidad->log('eliminado');
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
  $proc = $oportunidad->aprobar();
  if($proc->estado == 200) {
    return response()->json([
      'status'   => true,
      'disabled' => true,
      'label'    => 'Oportunidad Aprobada!',
      'message'  => $proc->mensaje,
      'refresh'  => false,
      'class'    => 'success',
    ]);
  } else if($proc->estado == 500) {
    return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ya existe',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ops! Un problema',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  }
  }
  public function revisar(Request $request, Oportunidad $oportunidad)
  {
      if(empty($oportunidad->montos_variacion())) {
        return response()->json([
          'status'  => false,
          'message' => 'Debe cotizar la Oportunidad',
        ]);
      }
      $proc = $oportunidad->revisar();
      
      if($proc->estado == 200) {
    return response()->json([
      'status'   => true,
      'disabled' => true,
      'label'    => 'Oportunidad Aprobada!',
      'message'  => $proc->mensaje,
      'refresh'  => false,
      'class'    => 'success',
    ]);
  } else if($proc->estado == 500) {
    return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ya existe',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ops! Un problema',
        'message'  => $proc->mensaje,
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
    $proc = $oportunidad->rechazar($motivo);
      if($proc->estado == 200) {
    return response()->json([
      'status'   => true,
      'disabled' => true,
      'label'    => 'Oportunidad Aprobada!',
      'message'  => $proc->mensaje,
      'refresh'  => false,
      'class'    => 'success',
    ]);
  } else if($proc->estado == 500) {
    return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ya existe',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ops! Un problema',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  }
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
    $proc = $oportunidad->archivar($motivo);
    if($proc->estado == 200) {
    return response()->json([
      'status'   => true,
      'disabled' => true,
      'label'    => 'Oportunidad Aprobada!',
      'message'  => $proc->mensaje,
      'refresh'  => false,
      'class'    => 'success',
    ]);
  } else if($proc->estado == 500) {
    return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ya existe',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ops! Un problema',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  }
  }
  public function interes(Request $request, Oportunidad $oportunidad, Empresa $empresa) {
    $proc = $oportunidad->registrar_interes($empresa);
    if($proc->estado == 200) {
    return response()->json([
      'status'   => true,
      'disabled' => true,
      'label'    => 'Oportunidad Aprobada!',
      'message'  => $proc->mensaje,
      'refresh'  => false,
      'class'    => 'success',
    ]);
  } else if($proc->estado == 500) {
    return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ya existe',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  } else {
      return response()->json([
        'status'   => false,
        'disabled' => true,
        'label'    => 'Ops! Un problema',
        'message'  => $proc->mensaje,
        'refresh'  => false,
        'class'    => 'warning',
      ]);
  }
  }
}
