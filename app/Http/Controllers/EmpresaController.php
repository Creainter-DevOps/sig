<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Contacto;
use App\Empresa;
use App\Persona;
use App\Ubigeo;
use App\Actividad;

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
          return view('empresas.index', $this->viewBag );
    }
    public function create(Request $request, Empresa $empresa )
    {
        $this->viewBag['breadcrumbs'][]  = [ 'name' => 'Nueva Empresa' ];
        $this->viewBab['empresa'] = $empresa;
        return view( 'empresas.create', $this->viewBag )  ;
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
      dd($request->all());
      $empresa->fill($request->all());
      $empresa->save();
      $empresa->log('creado');
      return response()->json([
        'status' => "success",
        'data' => [
          "value" => $empresa->razon_social,
          "id" => $empresa->id
        ],
        'redirect' => '/contactos'
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
    public function update(Request $request, Cliente $cliente)
    {
//    Session::flash('message_success', 'Se ha realizado la modificación con éxito.');
      $cliente->empresa()->update($request->all());
      $cliente->update($request->all());
      $cliente->log( 'editado', null );
      return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente )
    {
      /* Proceso para eliminar */
      $cliente->eliminado = true;
      $cliente->save();
      $cliente->log('eliminado');
      //return Redirect::to('/clientes');
      return response()->json(['status'=> true , 'refresh' => true  ]); 
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
       $data = Empresa::search($query)->select("osce.empresa.razon_social as value",'osce.empresa.id')->get();
       return Response()->json($data);
     }
     public function observacion(Request $request, Cliente $cliente ) {
       $cliente->log('texto',$request->input('texto'));
       return back();
     }
     public function fast(){
      return view('empresas.fast');
     }
}
