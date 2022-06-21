<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $viewBag;


    public function __construct(){
       $this->middleware('auth');
       $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
       $this->viewBag['breadcrumbs'] = [
         ["link" => "/dashboard", "name" => "Home" ],
         ["link" => "/proyectos", "name" => "Productos" ]
       ];
    }

    public function index()
    {

      $listado = Producto::where('eliminado',false)->paginate(15); 
      $this->viewBag['listado'] = $listado; 
      return view( 'productos.index', $this->viewBag );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Producto $producto)
    {
       $this->viewBag['producto'] = $producto;
       $this->viewBag['breadcrumbs'][] = ['name' => 'Nuevo producto']; 
       return view('productos.create', $this->viewBag );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request, Producto $producto )
    {
      $producto->fill($request->all());
      $producto->parametros = '{' . $request->input('parametros') . '}';
      $producto->save();
      return response()->json([ 'status' => true, 'redirect' => '/productos' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $producto = Producto::find($id);
      return view('productos.show',compact('producto')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $producto = Producto::find($id);

       $this->viewBag['producto'] = $producto;
       $this->viewBag['breadcrumbs'][] = ['name' => 'Editar producto']; 
       return view('productos.edit', $this->viewBag ); 
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
       $producto = Producto::find($id);
       $request->parametros  = '{' . $request->input('parametros') . '}' ;
       $producto->update($request->all());
       return response()->json([ 'status' => true, 'redirect'  => '/productos' ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $product = Producto::find($id);
       $product->eliminado = true;
       $product->save();
       return response()->json(['status' => true, 'refresh' => true]);
    }

    public function autocomplete(Request $request ){
      $query = $request->input('query');
      $list = Producto::search( $query )->selectRaw("producto.id, producto.nombre  as value , producto.precio_unidad " )->get();
     return response()->json($list); 
    }
}
