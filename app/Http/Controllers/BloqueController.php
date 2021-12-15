<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bloque;
class BloqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $bloques = Bloque::all();
      return response()->json([ 'status' => true , 'list' => $bloques ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Bloque $bloque)
    {
      $bloque->fill($request->all());
      $bloque->proyecto_id = 3;
      $bloque->orden();
      $bloque->save();
      return response()->json( [ 'status' => true, 'id' => $bloque->id  ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        
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
    public function update(Request $request, Bloque  $bloque )
    {
      $rpta = $bloque->update($request->all());  
      return response()->json(['status' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bloque $bloque )
    {
      $bloque->eliminado = true;
      $bloque->save();
      return response()->json([ 'status' => true ]); 
    }
}
