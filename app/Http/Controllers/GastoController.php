<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gasto;
use App\Entregable;
use Auth;
class GastoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
         $search = $request->input('search');
        if(!empty($search)) {
            $listado = Gasto::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Gasto::orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
        }
        return view('gasto.index', ['listado' => $listado]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
      $proyecto_id = $request->input('proyecto_id');
      $gasto = new Gasto;
      $gasto->fecha = date('Y-m-d');
      $gasto->monto = 0;
      if(!empty($proyecto_id)) {
        $gasto->proyecto_id = $proyecto_id;
      }
      return view($request->ajax() ? 'gasto.fast' : 'gasto.create', compact('gasto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();
      if(!empty($data['auto_cantidad']) && !empty($data['auto_gasto'])) {
        Entregable::registrar($data);
      } else {
        Gasto::registrar($data);
      }
      return response()->json(['status' => true , 'refresh' => true ]);
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
    public function edit(Request $request, Gasto $gasto)
    {
        return view($request->ajax() ? 'gasto.fast_edit' : 'gasto.edit', compact('gasto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gasto $gasto)
    {
      $data = $request->all();
    if(!empty($data['_update'])) {
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }

      $gasto->update($data);
      return response()->json(['status' => true , 'refresh' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gasto $gasto)
    {
      $gasto->delete();
      return response()->json(['status' => true , 'refresh' => true ]);
    }

    public function autocomplete(Request  $request  ) {
      $query = strtolower($request->input('query'));
      $data = Gasto::search($query)
        ->selectRaw("osce.gasto.id, CONCAT('GASTO ', osce.gasto.numero) as value");
      if($request->input('proyecto_id') != null) {
        $data->where('proyecto_id', '=', $request->input('proyecto_id'));
      }
      return response()->json($data->get());
    }
}
