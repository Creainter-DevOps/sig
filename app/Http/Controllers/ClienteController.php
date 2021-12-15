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
    public function index(Request $request )
    {
         $search = $request->input('search');
        if(!empty($search)) {
            $listado = Cliente::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Cliente::orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
        }
        return view('clientes.index', ['listado' => $listado]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Cliente $cliente)
    { 
       return view('clientes.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      Cliente::create($request->all());
      
      return response()->json(['status' => true , 'redirect' => '/clientes' ] );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
      $empresa = Empresa::find ($cliente->empresa_id);
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
       $cliente->update( $request->all() ); 
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
    }

    public function autocomplete(Request  $request  ) {
      $query = strtolower($request->input('query'));
      $data = Cliente::search($query)
              ->selectRaw("osce.cliente.id, osce.empresa.razon_social as value")
              ->get();
      return response()->json($data);
    }
}
