<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oportunidad;
use App\OportunidadLog;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use Illuminate\Support\Facades\DB;
use App\CandidatoOportunidad;
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
          $listado = Oportunidad::search($search)->paginate(15)->appends(request()->query());
      } else {
          $listado = Oportunidad::list()->paginate(15)->appends(request()->query());
      }
      return view('oportunidad.index', ['listado' => $listado]);
  }
  public function create(Request $request, Oportunidad $oportunidad )
  {
      return view('oportunidad.create', compact( 'oportunidad'));
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
  public function proyecto(Request $request, CandidatoOportunidad $candidato, Proyecto $proyecto ){
     $proyecto->oportunidad_id = $candidato->oportunidad_id;
     $proyecto->empresa_id     = $candidato->empresa_id;
     $proyecto->candidato_id   = $candidato->id;
     $proyecto->codigo = $proyecto::generarCodigo();
     $proyecto->nombre = strtolower($candidato->oportunidad()->licitacion()->rotulo);   
     //dd($candidato->oportunidad()->licitacion()->rotulo );
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
    dd($oportunidad);
      return view('oportunidad.edit', compact('oportunidad'));
  }
  public function update(Request $request, Oportunidad $oportunidad )
  {
    $oportunidad->update($request->all());
    $oportunidad->log( 'editado', null );
    return  response()->json([ 'status' =>  true]);
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
       $data = Oportunidad::search($query)->select(DB::raw("COALESCE(oportunidad.que_es, licitacion.rotulo, licitacion.descripcion, licitacion.nomenclatura) as value"),'oportunidad.id')->get();
       return Response()->json($data);
     }
}
