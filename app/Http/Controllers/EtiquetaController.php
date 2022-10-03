<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Etiqueta;
use App\EmpresaEtiqueta;
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
    public function create(Request $request)
    {
      return;
       $etiqueta = Etiqueta::nuevo($request->nombre);
       $etiqueta->solicitado_el = now();
       $etiqueta->solicitado_por = Auth::user()->id;
       return response()->json([
        'success'=> true ,
        'id' => $etiqueta->id
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $empresa_id = $request->input('empresa_id');
       $tipo       = $request->input('tipo');
       $tag        = $request->input('nombre');

       $proc = Etiqueta::nuevo($empresa_id, $tipo, $tag);

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
    public function aprobar( Request $request, Etiqueta $etiqueta ){

      $etiqueta->aprobar();

      if(!empty( $request->input("empresa_id")) && !empty( $request->input("tipo")) ){
        $emp = EmpresaEtiqueta::where('etiqueta_id', $etiqueta->id )->where('empresa_id',$request->input('empresa_id') )->first();
        if(empty( $emp )){
          EmpresaEtiqueta::create([ 'tenant_id' => Auth::user()->tenant_id, 'empresa_id' => $request->input('empresa_id'), 'etiqueta_id' => $etiqueta->id , 'tipo' => $request->input('tipo') ]);
           return response()->json([ 'success'=> true , 'id' => $etiqueta->id ]);
        }
      }
      $etiqueta->save();
      return response()->json(['status' => true, 'refresh' => true ]);
    }

    public function rechazar( Request $request, Etiqueta $etiqueta ){

      $etiqueta->rechazar();

      if( !empty( $request->input("empresa_id")) && !empty( $request->input("tipo")) ){

        $emp = EmpresaEtiqueta::where('etiqueta_id', $etiqueta->id )->where('empresa_id',$request->input('empresa_id') )->first();

        if ( empty( $emp )){
          EmpresaEtiqueta::create([ 'tenant_id' => Auth::user()->tenant_id, 'empresa_id' => $request->input('empresa_id'), 'etiqueta_id' => $etiqueta->id , 'tipo' => $request->input('tipo') ]);
        }

      }
      $etiqueta->save();
      return response()->json(['status' => true, 'refresh' => true ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id, Request $request)
    {
       $etiqueta = EmpresaEtiqueta::where('empresa_id',$request->input('empresa_id') )
        ->where('etiqueta_id', $request->input('etiqueta_id'))
        ->delete();
       return response()->json([ 'success'=> true , 'request' => $request->all() ]);
    }
}
