<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orden;
use App\Entregable;
use Auth;
class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function tablefy(Request $request) {
    $listado = Orden::pagination()
    ->appends(request()->input())
    ->map(function($row) {
      return [
        'codigo'      => "javascript:status_wdir('GASTO-' + row.proyecto_id + '-' + row.id, '" . $row->folder(true) . "')",
        'usuario'   =>  $row->usuario,
        'proyecto'    =>  $row->proyecto_rotulo,
        'fecha'       => 'javascript:status_date_vencimiento(row.fecha, row.estado)',
        'numero'      => $row->numero,
        'descripcion' => $row->descripcion,
        'monto'       => 'javascript:status_monto(row.moneda_id, row.monto)',
        'moneda_id'   => 'javascript:status_moneda(row.moneda_id)',
        'estado_id'   => 'javascript:status_select_estado(row.estado_id)',
        'fecha_deposito'   => 'javascript:status_date_vencimiento(row.fecha_deposito, 1)',
        'monto_depositado' => $row->monto_depositado,
        'monto_detraccion' => $row->monto_detraccion,
        'monto_penalidad'  => $row->monto_penalidad,
        'factura_codigo'   => $row->factura_codigo,
      ];
    })
    ->get();
    return $listado->response();
  }
    public function index(Request $request )
    {
        return view('orden.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
      $proyecto_id = $request->input('proyecto_id');
      $orden = new Orden;
      $orden->fecha = date('Y-m-d');
      $orden->monto = 0;
      if(!empty($proyecto_id)) {
        $orden->proyecto_id = $proyecto_id;
      }
      return view($request->ajax() ? 'orden.fast' : 'orden.create', compact('orden'));
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
      if(!empty($data['auto_cantidad']) && !empty($data['auto_orden'])) {
        Entregable::registrar($data);
      } else {
        Orden::registrar($data);
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
    public function edit(Request $request, Orden $orden)
    {
        return view($request->ajax() ? 'orden.fast_edit' : 'orden.edit', compact('orden'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orden $orden)
    {
      $data = $request->all();
    if(!empty($data['_update'])) {
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }

      $orden->update($data);
      return response()->json(['status' => true , 'refresh' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Orden $orden)
    {
      $orden->delete();
      return response()->json(['status' => true , 'refresh' => true ]);
    }

    public function autocomplete(Request  $request  ) {
      $query = strtolower($request->input('query'));
      $data = Orden::search($query)
        ->selectRaw("osce.orden.id, CONCAT('GASTO ', osce.orden.numero) as value");
      if($request->input('proyecto_id') != null) {
        $data->where('proyecto_id', '=', $request->input('proyecto_id'));
      }
      return response()->json($data->get());
    }
}
