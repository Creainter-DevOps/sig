<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acta;


class ActaController extends Controller
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
      $acta = new Acta;
      if (!empty($proyecto_id )){
        $acta->proyecto_id = $proyecto_id;
      } 
      return view( $request->ajax() ? 'acta.fast' : 'acta.create', compact('acta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Acta $acta)
    {
      $acta->fill($request->all());
      $acta->orden($acta->proyecto_id);
      $acta->save();
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
    public function edit(Request $request, Acta  $acta)
    {
      return view( $request->ajax() ? 'acta.fast_edit' : 'acta.create', compact('acta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acta $acta )
    {
      $data = $request->all();
    if(!empty($data['_update'])) {
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }

      $acta->update($data);
      return response()->json( [ 'status' => true, 'refresh' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Acta $acta )
    {
       $acta->eliminado = true; 
      return response()->json( [ 'status' => true, 'refresh' => true ]);
    }
    
}
