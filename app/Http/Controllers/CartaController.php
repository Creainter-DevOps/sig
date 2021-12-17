<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carta;


class CartaController extends Controller
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
    public function create(Request $request )
    {
      $proyecto_id = $request->input('proyecto_id');
      $carta = new Carta;
      if (!empty($proyecto_id )){
        $carta->proyecto_id = $proyecto_id;
      } 
      return view( $request->ajax() ? 'carta.fast' : 'carta.create', compact('carta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Carta $carta)
    {
      $carta->fill($request->all());
      $carta->orden($carta->proyecto_id);
      $carta->save();
      return response()->json(['status' => true, 'refresh'  => true  ]);
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
    public function edit(Request $request, Carta  $carta)
    {
      return view( $request->ajax() ? 'carta.fast_edit' : 'carta.create', compact('carta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carta $carta )
    {
      $carta->update($request->all());
      return response()->json( [ 'status' => true, 'refresh' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Carta $carta )
    {
       $carta->eliminado = true; 
      return response()->json( [ 'status' => true, 'refresh' => true ]);
    }
    
}
