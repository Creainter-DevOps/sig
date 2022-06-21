<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\ProveedorProducto;
use App\Empresa;
use Auth;


class ProveedorController extends Controller
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
        ["link" => "/proyectos", "name" => "Proveedores" ]
      ];
    }

    public function index(Request $request )
    {
        $search = $request->input('search');

        if ( !empty($search) ) {
            $listado = Proveedor::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Proveedor::orderBy('created_at', 'desc')->paginate(15)->appends(request()->query());
        }

        $this->viewBag['listado'] = $listado;
        return view( 'proveedores.index',  $this->viewBag ); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request, Proveedor $proveedor)
    {
       $this->viewBag['breadcrumbs'][] = ['name' => 'Nuevo'];
       $this->viewBag['cliente'] = $proveedor;
       return view(  $request->ajax() ?  'proveedores.fast'  : 'proveedores.create' ,$this->viewBag);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Proveedor $proveedor )
    {
      $empresa_id = $request->input('empresa_id');
      $cc = Proveedor::where('empresa_id', $empresa_id)->get();
      if(count($cc) > 0) {
        $proveedor = $cc->first();
      } else {
        $proveedor->fill($request->all());
        $proveedor->save();
        return response()->json(['status' => true , 'redirect'  => '/proveedores']);
      }
      if($request->ajax() || true) {
        return response()->json(['status' => true ,
          'message' => 'La empresa ya fue registrada como proveedor', 'redirect' => '/proveedores/' . $proveedor->id ]);
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
    public function show(Proveedor $proveedor)
    {
      $empresa = Empresa::find($proveedor->empresa_id);
      return view('proveedores.show',compact('empresa','proveedor')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor )
    {
       $empresa = Empresa::find($proveedor->empresa_id);
       return view ('proveedores.edit',compact('proveedor','empresa' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor )
    {
      $count = count( Proveedor::where( 'empresa_id', $proveedor->empresa_id)->get());
      if($count > 0  ){
        $response['status'] = false;
        $response['message'] = "La empresa ya fue registrada como proveedor";
      } else {
        $proveedor->update( $request->all()); 
        $response['status'] = true;
        $response['redirect'] = "/proveedores";
      }
      return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Proveedor $proveedor )
    {
      $proveedor->eliminado = true;
      $proveedor->save();
      return response()->json([ 'status' => true , 'refresh' => true ] ); 
    }
    public function productos( Request $request, Proveedor $proveedor ){
      $this->viewBag['breadcrumbs'][] = [ 'name' => $proveedor->empresa()->razon_social ];  
      $this->viewBag['proveedor'] = $proveedor;
      return view('proveedores.productos', $this->viewBag); 
      //return response()->json( [ 'status' => true , 'object' => $ps ] );
    }

    public function saveproducto(Request  $request ){
      dd($request->all()) ;
      $id_pp = $request->input('id');
      if( $id_pp  != 0 ){
        $pproducto = ProveedorProducto::find($id_pp);  
        $pproducto->update($request->all()); 
        //dd($pproducto);
      }else{
        $pproducto = ProveedorProducto::create( $request->all() );
      }
      return response()->json( [ 'status' => true , 'refresh' => true ] );
    }
    
    public function autocomplete(Request $request) {
      $query = strtolower($request->input('query'));
      $data = Proveedor:: search($query)
              ->selectRaw("osce.proveedor.id, osce.empresa.razon_social as value")
              ->get();
      return response()->json($data);
    }

}
