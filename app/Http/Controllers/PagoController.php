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
  public function tablefy(Request $request) {
    $listado = Pago::pagination()
    ->appends(request()->input())
    ->map(function($row) {
      return [
        'codigo'      => "javascript:status_wdir('PAGO-' + row.proyecto_id + '-' + row.id, '" . $row->folder(true) . "')",
        'usuario'     =>  $row->usuario,
        'proyecto'    =>  $row->proyecto_rotulo,
        'fecha'       => 'javascript:status_date_vencimiento(row.fecha, row.estado)',
        'numero'      => $row->numero,
        'descripcion' => $row->descripcion,
        'monto'       => 'javascript:status_monto(row.moneda_id, row.monto)',
        'moneda_id'   => 'javascript:status_moneda(row.moneda_id)',
        'estado_id'   => 'javascript:status_select_estado(row.estado_id)',
        'fecha_deposito'    => 'javascript:status_date_vencimiento(row.fecha_deposito, 1)',
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
        return view('pago.index');
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
