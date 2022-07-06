<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Etiqueta;
class EtiquetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( )
    {
       $etiqueta = Etiqueta::nuevo($request->nombre);
       $etiqueta->solicitado_el = DB::raw('now()');
       $etiqueta->solicitado_por = Auth::user()->id;
       $etiqueta->aprobado_el = DB::raw('now()');
       $etiqueta->aprobado_por = Auth::user()->id;
       EmpresaEtiqueta::create([ 'tenant_id' => Auth::user()->tenant_id, 'empresa_id' => $request->input('empresa_id'), 'etiqueta_id' => $etiqueta->id , 'tipo' => $request->input('tipo') ]);
       return response()->json([ 'success'=> true , 'id' => $etiqueta->id ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request, Etiqueta $etiqueta )
    {
       $etiqueta = Etiqueta::nuevo($request->nombre);
       $etiqueta->solicitado_el = DB::raw('now()');
       $etiqueta->solicitado_por = Auth::user()->id;
       $etiqueta->aprobado_el = DB::raw('now()');
       $etiqueta->aprobado_por = Auth::user()->id;
       EmpresaEtiqueta::create([ 'tenant_id' => Auth::user()->tenant_id, 'empresa_id' => $request->input('empresa_id'), 'etiqueta_id' => $etiqueta->id , 'tipo' => $request->input('tipo') ]);
       return response()->json([ 'success'=> true , 'id' => $etiqueta->id ]);
    }
    public function mini(){
      $etiqueta = Etiqueta::whereNull('verificada_el')->whereNull('rechazado_el')->first();
      return view('etiqueta.mini', compact('etiqueta'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function verificar( Request $request, Licitacion $licitacion ){
      $licitacion->verificar();
      $licitacion->save();
      return response()->json(['status' => true, 'refresh' => true ]);
    }

    public function rechazar( Request $request, Licitacion $licitacion ){
      $licitacion->recharzar();
      $licitacion->save();
      return response()->json(['status' => true, 'refresh' => true ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $etiqueta = EmpresaEtiqueta::where('empresa_id',$request->input('empresa_id') )->where( 'etiqueta_id', $request->input('etiqueta_id') )->delete();  
      //$etiqueta->delete(); 
      return response()->json([ 'success'=> true  ]);
        //
    }
}
