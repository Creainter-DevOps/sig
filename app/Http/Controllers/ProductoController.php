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
    public function index()
    {
      $listado = Producto::get();
      return view( 'productos.index', compact('listado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Producto $producto)
    {
        return view('productos.create', compact('producto'));
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
      return view('productos.edit',compact('producto')); 
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
        //
    }

    public function autocomplete(Request $request ){
      $query = $request->input('query');
      $list = Producto::search( $query )->selectRaw("producto.id, producto.nombre  as value , producto.precio_unidad " )->get();
     return response()->json($list); 
    }
}
