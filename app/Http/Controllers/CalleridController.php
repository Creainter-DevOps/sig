<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Callerid;


class CalleridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   protected $viewBag = [];
   public function __construct(){
       $this->middleware('auth');
       
        $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
        $this->viewBag['breadcrumbs'] = [
          ["link" => "/dashboard", "name" => "Home" ],
          ["link" => "/callerids", "name" => "Callerids" ]
        ];
    }

    public function index(Request $request )
    {
      $search = $request->input('search');
      $paginate = 15;
      if( !empty($request->input('paginate'))){
        $paginate = $request->input('paginate');
      }
      if(!empty($search)){
        $this->viewBag['listado'] = Callerid::search($search)->paginate($paginate)->appends($request->input('query'));
      }else{
        $this->viewBag['listado'] = Callerid::paginate( $paginate );
      }
      return view('callerid.index', $this->viewBag );  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Callerid $caller)
    {
       $this->viewBag['breadcrumbs'][] = [ 'name' => "Nuevo Caller" ];
       $this->viewBag['caller'] = $caller;
       return view('callerid.create', $this->viewBag );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Callerid $caller )
    {
      $caller->fill( $request->all() );
      $caller->save();
      //Actividad::log('creado');
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
      $caller = Callerid::find( $id );
      return view('callerid.show', compact('caller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
       $caller = Callerid::find( $id );
       return view('callerid.edit', compact('caller') );
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
       $caller = Callerid::find($id);
       $caller->update($request->all());
       //Actividad::log('actulizado');
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

    public function autocomplete(Request $request ){
      $term =  $request->input('query');
      $data = Callerid::search($term)->selectRaw("callerid.id, rotulo as value ")->get();
      return response()->json($data);
    }
}
