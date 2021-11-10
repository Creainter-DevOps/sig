<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\Contacto;
use App\Empresa;
use App\Persona;
use App\Ubigeo;

class ProyectoController extends Controller {
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index(Request $request)
    {
        $search = $request->input('search');
        if(!empty($search)) {
            $listado = Proyecto::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Proyecto::orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
        }
        return view('proyectos.index', ['listado' => $listado]);
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
        return view($request->ajax() ? 'proyectos.fast' : 'proyectos.create', compact('empresa', 'distrito', 'departamentos', 'provincias', 'distritos'));      
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

        $existe_vinculo = Proyecto::where('empresa_id', '=', $empresa->id)->first();
        if ($existe_vinculo !== null) {
            $error = 'La empresa ya ha sido registrada como cliente, y es la siguiente:';
            goto response;
        }

        $cliente = new Proyecto;
        $cliente->empresa_id = $empresa->id;
        $cliente->tenant_id = Auth::user()->id;
        $cliente->descripcion = $request->input('descripcion');
        $cliente->save();

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
                return redirect()->route('proyectos.edit', [$existe_vinculo->id]);
            } else {
//                Session::flash('message_success', 'Se ha realizado registro con éxito.');
                return redirect()->route('proyectos.edit', [$cliente->id]);
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
    public function show(Proyecto $proyecto)
    {
      return view('proyectos.show', compact('proyecto'));
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
    public function update(Request $request, Proyecto $cliente)
    {
//        Session::flash('message_success', 'Se ha realizado la modificación con éxito.');
      $cliente->empresa()->update($request->all());
      $cliente->update($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        /* Proceso para eliminar */
        return Redirect::to('/proyectos');
    }
    public function autocomplete(Request $request)
    {
        $query = strtolower($request->input('query'));
        $data = Proyecto::select("comercial.empresa.razon_social as value",'comercial.cliente.id')
                ->join('comercial.empresa', 'comercial.empresa.id', '=', 'comercial.cliente.empresa_id')
                ->whereRaw("LOWER(comercial.empresa.razon_social) LIKE ? OR LOWER(comercial.empresa.seudonimo) LIKE ?", ["%{$query}%", "%{$query}%"])
                ->get();
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
//        Session::flash('message_success', 'Se ha eliminado correctamente.');
        return back();
     }
}
