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
  public function __construct() {
    $this->middleware('auth');
  }
  public function index(Request $request)
  {
      $search = $request->input('search');
      if(!empty($search)) {
          $listado = Oportunidad::search($search)->selectRaw('licitacion.*,  empresa.* ,oportunidad.*')->paginate(15)->appends(request()->query()) ;
      } else {
          $listado = Oportunidad::list()->paginate(15)->appends(request()->query());
      }
      return view('oportunidad.index', ['listado' => $listado]);
  }
  public function create(Request $request, Oportunidad $oportunidad )
  {
      return view( $request->ajax() ? 'oportunidad.fast' : 'oportunidad.create', compact( 'oportunidad'));
  }
  public function store(Request $request , Oportunidad $oportunidad )
  {
    $oportunidad->fill($request->all());
    $oportunidad->tenant_id = Auth::user()->tenant_id;
    $oportunidad->save();
    $oportunidad->log('creado'); 
    $oportunidad->update([ 
      'codigo' => DB::raw('osce.fn_generar_codigo_oportunidad(id)'),
      'aprobado_el' => DB::raw('now'),
      'aprovado_por' => Auth::user()->id
    ]);
    return response()->json([ 'status' => true , 'redirect' => '/oportundides']);
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
    if(!empty($data['_update'])) {
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }
    $oportunidad->update($data);
    return response()->json([ 'status' =>  true]);
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
      $oportunidad->eliminado = true;
      $oportunidad->save();
      $oportunidad->log('eliminado');
      return response()->json(['status'=> true , 'refresh' => true  ]);
    }
     public function autocomplete(Request $request) {
       $query = $request->input('query');
       $data = Oportunidad::search($query)->select(DB::raw("COALESCE(oportunidad.rotulo, licitacion.rotulo, licitacion.descripcion, licitacion.nomenclatura) as value"),'oportunidad.id')->get();
       return Response()->json($data);
     }
}
