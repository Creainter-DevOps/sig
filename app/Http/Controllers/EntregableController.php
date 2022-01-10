<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entregable;
use Auth;
class EntregableController extends Controller
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
            $listado = Entregable::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Entregable::orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
        }
        return view('entregable.index', ['listado' => $listado]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
      $proyecto_id = $request->input('proyecto_id');
      $entregable = new Entregable;
      $entregable->fecha = date('Y-m-d');
      if(!empty($proyecto_id)) {
        $entregable->proyecto_id = $proyecto_id;
      }
      return view($request->ajax() ? 'entregable.fast' : 'entregable.create', compact('entregable'));
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
      Entregable::registrar($data);
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
    public function edit(Request $request, Entregable $entregable)
    {
        return view($request->ajax() ? 'entregable.fast_edit' : 'entregable.edit', compact('entregable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entregable $entregable)
    {
      $data = $request->all();
      $entregable->update($data);
      return response()->json(['status' => true , 'refresh' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entregable $entregable)
    {
      $entregable->delete();
      return response()->json(['status' => true , 'refresh' => true ]);
    }

    public function autocomplete(Request  $request  ) {
      $query = strtolower($request->input('query'));
      $data = Entregable::search($query)
        ->selectRaw("osce.entregable.id, CONCAT('ENTREGABLE ', osce.entregable.numero) as value");
      if($request->input('proyecto_id') != null) {
        $data->where('proyecto_id', '=', $request->input('proyecto_id'));
      }
      return response()->json($data->get());
    }
}
