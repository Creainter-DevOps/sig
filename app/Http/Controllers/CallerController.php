<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caller;


class CallerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
       $this->middleware('auth');
       
        $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
        $this->viewBag['breadcrumbs'] = [
          ["link" => "/dashboard", "name" => "Home" ],
          ["link" => "/callers", "name" => "Llamadas" ]
        ];
    }

    public function index(Request $request )
    {
      $search = $request->input('search');
      /*if(empty( $search ) ){
        $list = Caller::search($search)->paginate(15)->appends($request->input('query'));
      }*/
      $list = Caller::paginate(15);
      return view('llamadas.index',[ 'listado' =>  $list ] );  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Caller $caller)
    {
         return view('llamadas.create',compact('caller'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Caller $caller )
    {
      $caller->fill( $request->all() );
      $caller->save();
      return response()->json([ 'status' => true , 'redirect' => '/llamadas']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(  $id )
    {
      $caller = Caller::find( $id );
      return view('llamadas.show', compact('caller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
       $caller = Caller::find( $id );
       return view('llamadas.edit', compact('caller') );
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
       $caller = Caller::find($id);
       $caller->update($request->all());
       return response()->json([ 'status' => true , 'redirect' => '/llamadas' ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Caller $caller )
    {
       $caller->eliminado = true;
       $caller->save();
       return response()->json([ 'status' => true ]);
    }
}
