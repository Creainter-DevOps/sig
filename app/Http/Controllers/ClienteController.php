<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Empresa;
use Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    protected $viewBag; 

    public function __construct()
    {
      $this->middleware('auth');
      $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
      $this->viewBag['breadcrumbs'] = [
        ["link" => "/dashboard", "name" => "Home" ],
        ["link" => "/proyectos", "name" => "Clientes" ]
      ];
    }
  
    public function index(Request $request )
    {
         $search = $request->input('search');
        if(!empty($search)) {
            $listado = Cliente::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Cliente::where('eliminado',false )->orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
        }
        $this->viewBag['listado'] = $listado; 
        return view('clientes.index', $this->viewBag ); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request, Cliente $cliente)
    {
       $this->viewBag['breadcrumbs'][] = ['name' => 'Nuevo Cliente'];
       $this->viewBag['cliente'] = $cliente;
       return view( $request->ajax() ? 'clientes.fast' : 'clientes.create', $this->viewBag );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request , Cliente $cliente )
    {
      $empresa_id = $request->input('empresa_id');
      $cc = Cliente::where('empresa_id', $empresa_id)->get();
      if(count($cc) > 0) {
        $cliente = $cc->first();
      } else {
        $cliente->fill($request->all());
        $cliente->save();
      }

      if($request->ajax() || true) {
        return response()->json(['status' => true ,
          'message' => 'La empresa ya fue registrada como cliente', 'redirect' => '/clientes/' . $cliente->id ]);
      } else {
        return back();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
      $empresa = Empresa::find($cliente->empresa_id);
      return view('clientes.show',compact('empresa','cliente')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente )
    {
       $empresa = Empresa::find($cliente->empresa_id);
       return view ('clientes.edit',compact('cliente','empresa' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente )
    {
      $count = count( Cliente::where( 'empresa_id' , $cliente->empresa_id )->get());
      if($count > 0  ){
        $response['status'] = false;
        $response['message'] = "La empresa ya fue registrada como cliente";
      } else {
        $cliente->update( $request->all()); 
        $response['status'] = true;
        $response['redirect'] = "/clientes";
      }
      return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente )
    {
      $cliente->eliminado = true;
      $cliente->save();
      return response()->json([ 'status' => true , 'refresh' => true ] ); 
    }

    public function autocomplete(Request  $request  ) {
      $query = strtolower($request->input('query'));
      $data = Cliente::search($query)
              ->selectRaw("osce.cliente.id, osce.empresa.razon_social as value")
              ->get();
      return response()->json($data);
    }
}
