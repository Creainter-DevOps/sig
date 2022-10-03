<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use App\Entregable;
use Auth;

class PagoController extends Controller
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
            $listado = Pago::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Pago::orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
        }
        return view('pago.index', ['listado' => $listado]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
      $proyecto_id = $request->input('proyecto_id');
      $pago = new Pago;
      $pago->fecha = date('Y-m-d');
      $pago->monto = 0;
      if(!empty($proyecto_id)) {
        $pago->proyecto_id = $proyecto_id;
      }
      return view($request->ajax() ? 'pago.fast' : 'pago.create', compact('pago'));
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
      if(!empty($data['auto_cantidad']) && !empty($data['auto_pago'])) {
        Entregable::registrar($data);
      } else {
        Pago::registrar($data);
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
    public function edit(Request $request, Pago $pago)
    {
        return view($request->ajax() ? 'pago.fast_edit' : 'pago.edit', compact('pago'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pago $pago)
    {
      $data = $request->all();
    if(!empty($data['_update'])) {
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }
      $data['updated_by'] = Auth::user()->id;
      $pago->update($data);
      return response()->json(['status' => true , 'refresh' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pago $pago)
    {
      $pago->delete();
      return response()->json(['status' => true , 'refresh' => true ]);
    }

    public function autocomplete(Request  $request  ) {
      $query = strtolower($request->input('query'));
      $data = Pago::search($query)
        ->selectRaw("osce.pago.id, CONCAT('PAGO ', osce.pago.numero) as value");
      if($request->input('proyecto_id') != null) {
        $data->where('proyecto_id', '=', $request->input('proyecto_id'));
      }
      return response()->json($data->get());
    }
}
