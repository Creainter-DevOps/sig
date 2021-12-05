<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
      $search = $request->input("search");
      if ( !empty($search) ){
        $listado = Actividad::search($search)->paginate(15)->appends(request()->query());
      } else {
        $listado = Actividad::where('tipo','accion')->orderBy('id', 'DESC')->paginate(15)->appends(request()->query());     
      }
      return view('actividad.index',compact('listado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Actividad $actividad )
    {
      $actividad = $actividad;
       return view('actividad.add', compact($actividad));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Actividad $actividad )
    {
      $actividad->fill($request->all());
      $actividad->tipo = 'accion';
       $actividad->save();
       return response()->json([   
         'status' => "success",  
         'redirect' => '/actividades'
       ]); 
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
    public function edit(Actividad  $actividad )
    {
        return view('actividad.edit', compact('actividad'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
