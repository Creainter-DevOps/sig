<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Contacto;
use App\Empresa;
use App\Persona;
use App\Ubigeo;
use App\Actividad;

class ClientesController extends Controller {

  protected $viewBag = [];
  public function __construct()
  {
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/clientes", "name" => "Clientes" ]
    ];
  }
  public function index(Request $request)
  {
        $search = $request->input('search');
        if(!empty($search)) {
            $listado = Cliente::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Cliente::orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
        }
        return view('clientes.index', ['listado' => $listado]);
   }
    public function create(Request $request)
    {
        $empresa       = null;
        $ubigeo        = '150101';
        $distrito      = Ubigeo::distrito($ubigeo);
        $departamentos = Ubigeo::departamentos($ubigeo);
        $provincias    = Ubigeo::provincias($ubigeo);
        $distritos     = Ubigeo::distritos($ubigeo);

        if ($request->ajax()) {
            $empresa = new Empresa;
            $empresa->direccion = 'Lima';
            $empresa->telefono  = '000 000 000';
            $empresa->correo_electronico = 'comercial@creainter.com.pe';
            $empresa->web = 'web';
        }
 
        return view($request->ajax() ? 'clientes.fast' : 'clientes.create', compact('empresa', 'distrito', 'departamentos', 'provincias', 'distritos'));
              
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\lain  $lain
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe_ruc = Empresa::where('ruc', '=', $request->input('ruc'))->first();
        $existe_razon = Empresa::where('razon_social', '=', $request->input('razon_social'))->first();
        if ($existe_ruc !== null) {
            $empresa = $existe_ruc;
        } else if ($existe_razon !== null) {
            $empresa = $existe_razon;
        } else {
          $empresa = Empresa::create($request->all());
        }

        $existe_vinculo = Cliente::where('empresa_id', '=', $empresa->id)->first();
        if ($existe_vinculo !== null) {
            $error = 'La empresa ya ha sido registrada como cliente, y es la siguiente:';
            goto response;
        }

        $cliente = new Cliente;
        $cliente->empresa_id = $empresa->id;
        $cliente->tenant_id = Auth::user()->id;
        $cliente->descripcion = $request->input('descripcion');
        $cliente->save();
        $cliente->log('creado',null);
        response:
        if($request->ajax()) {
            if(!empty($error)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $error,
                ]);
            } else {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Se ha realizado registro con éxito.',
                    'data' => [
                        'id'    => $cliente->id,
                        'value' => $cliente->empresa()->razon_social,
                    ],
                ]);
            }
        } else {
            if(!empty($error)) {
//                Session::flash('message_error', $error);
                //return back();
                return redirect()->route('clientes.edit', [$existe_vinculo->id]);
            } else {
//                Session::flash('message_success', 'Se ha realizado registro con éxito.');
                return redirect()->route('clientes.edit', [$cliente->id]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Cliente $cliente)
    {
      $empresa = $cliente->empresa();
      return view('clientes.show', compact('cliente','empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
      $empresa = $cliente->empresa();
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
        }
        return view('clientes.edit', compact('cliente','empresa', 'distrito', 'departamentos', 'provincias', 'distritos'));
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
       $data = Cliente::search($query)->select("osce.empresa.razon_social as value",'osce.cliente.id')->get();
       return Response()->json($data);
     }
     public function observacion(Request $request, Cliente $cliente ) {
       $cliente->log('texto',$request->input('texto'));
       return back();
     }
}
