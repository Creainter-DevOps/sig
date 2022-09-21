<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\Contacto;
use App\Empresa;
use App\Cliente;
use App\Persona;
use App\Ubigeo;
use App\Helpers\Helper;
use Auth;

class ProyectoController extends Controller {
 
  protected $viewBag; 

  public function __construct()
  {
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/proyectos", "name" => "Proyectos" ]
    ];
  }
  public function index(Request $request)
  {
      $search = $request->input('search');
      if(!empty($search)) {
          $listado = Proyecto::search($search)->paginate(15)->appends(request()->query());
      } else {
          $listado = Proyecto::where( 'eliminado', false )->orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
      }
      $this->viewBag['listado'] = $listado;
      return view('proyectos.index',  $this->viewBag );
  }
  public function create(Request $request, proyecto $proyecto)
  {
      $this->viewBag['proyecto'] = $proyecto;
      $this->viewBag['breadcrumbs'][] = [ 'name' => "Nuevo Proyecto" ];  
      return view($request->ajax() ? 'proyectos.fast' : 'proyectos.create', $this->viewBag );      
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\lain  $lain
   * @return \Illuminate\Http\Response
   */
    public function store(Request $request, Proyecto $proyecto )
    {
        $proyecto->fill($request->all());
        $proyecto->codigo = Proyecto::generarCodigo();
        $proyecto->save();
        $proyecto->log("creado");
        return response()->json(['status'=> "success", 'redirect' => "/proyectos" ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
      $cliente = Cliente::find($proyecto->cliente_id);
      $contacto = Contacto::find($proyecto->contacto_id); 
      return view('proyectos.show', compact('proyecto', 'contacto', 'cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto)
    {
      $this->viewBag['proyecto'] = $proyecto; 
      return view('proyectos.edit', compact('proyecto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto )
    {
      $data = $request->all();
      if(!empty($data['_update'])) {
        $data[$data['_update']] = $data['value'];
        unset($data['value']);
        unset($data['_update']);
      }
      $data['updated_by'] = Auth::user()->id;
      $proyecto->update($data);
      #$proyecto->log("editado");
      return response()->json(['status'=> 'success' ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
      /* Proceso para eliminar */
        $proyecto->eliminado = true;
        $proyecto->save();
        $proyecto->log("eliminado");
        return response()->json(['status'=> true , 'refresh' => true ]);
    }
    public function autocomplete(Request $request)
    {
        $query = strtolower($request->input('query'));
        $data = Proyecto::search( $query )->selectRaw("id, CONCAT_WS(':', codigo,nombre) as value")->get();
        return response()->json($data);
    }
     public function addRepresentante(Request $request, Proyecto $cliente)
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
     public function delRepresentante(Request $request, Proyecto $cliente, Contacto $contacto)
     {
        $contacto->delete();
     // Session::flash('message_success', 'Se ha eliminado correctamente.');
        return back();
     }

     public function observacion(Request $request, Proyecto $proyecto) {
         $proyecto->log('texto',$request->input('texto'));
         return back();
     }
     public function financiero(Request $request, Proyecto $proyecto) {
       $empresa = $proyecto->cotizacion()->empresa();
       return Helper::pdf('proyectos.financiero', compact('proyecto','empresa'), 'L')->stream('demo.pdf');
     }
     public function pdf_situacion(Request $request, Proyecto $proyecto) {
       $empresa = $proyecto->cotizacion()->empresa();
       return Helper::pdf('proyectos.pdf_situacion', compact('proyecto','empresa'), 'L')->stream('demo.pdf');
     }
}
