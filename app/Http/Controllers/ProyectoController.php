<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\Contacto;
use App\Empresa;
use App\Cliente;
use App\Pago;
use App\Orden;
use App\Ubigeo;
use App\Carta;
use App\Entregable;
use App\Helpers\Helper;
use Auth;

class ProyectoController extends Controller {
 
  protected $viewBag; 

  public function __construct()
  {
    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
    $this->viewBag['breadcrumbs'] = [
      ["link" => "/dashboard", "name" => "Home" ],
      ["link" => "/proyectos", "name" => "Proyectos" ]
    ];
  }
  public function tablefy(Request $request) {
    $listado = Proyecto::pagination()
    ->appends(request()->input())
    ->map(function($row) {
      return [
        //'codigo' =>  '<span style="border-bottom: 5px solid ' . $row->color . ';">' . $row->codigo . '</span>',
        'codigo'      => "javascript:status_wdir(row.codigo, '" . $row->folder(true) . "')",
        'tipo'   =>  $row->tipo,
        'proveedor' =>  $row->proveedor_rotulo,
        'cliente' => $row->cliente_rotulo,
        'rotulo' => '<a href="/proyectos/' . $row->id . '">' . $row->rotulo . '</a>',
        'monto'       => 'javascript:status_monto(row.moneda_id, row.monto)',
        'fecha_buenapro'  => 'javascript:status_date(row.fecha_buenapro)',
        'fecha_consentimiento' => 'javascript:status_date(row.fecha_consentimiento)',
        'fecha_firma' => 'javascript:status_date_vencimiento(row.fecha_perfeccionamiento, row.estado_perfeccionamiento)',
        'fecha_hasta' => 'javascript:status_date_vencimiento(row.fecha_termino, row.estado_termino)',
        'estado_id'   => 'javascript:status_contrato_estado(row.estado_id)',
        'pagos' => '<div style="width: 10px;height: 10px;border-radius: 30px;margin: 0 auto;background: ' . $row->estado_color . ';"></div>AL DÍA',
      ];
    })
    ->get();
    return $listado->response();
  }
  public function tablefy_cartas(Request $request, Proyecto $proyecto) {
    $listado = Carta::paginationPorProyecto($proyecto)
    ->appends(request()->input())
    ->map(function($row) {
      return [
        'codigo' => "javascript:status_wdir('CTT-' + row.proyecto_id + '-' + row.id, '" . $row->folder(true) . "')",
        'fecha'  => "javascript:status_date_vencimiento(row.fecha, row.estado)",
        'numero' =>  $row->numero,
        'nomenclatura' => $row->nomenclatura,
        'rotulo' => $row->rotulo,
        'hojas'  => $row->hojas,
        'estado_id' => 'javascript:status_select_estado(row.estado_id)',
        'cuenta' => $row->cuenta_id,
        'folder' => "javascript:status_wdir('" . $row->folder(true) . "', '" . $row->folder(true) . "')",
      ];
    })
    ->get();
    return $listado->response();
  }
  public function tablefy_entregables(Request $request, Proyecto $proyecto) {
    $listado = Entregable::paginationPorProyecto($proyecto)
    ->appends(request()->input())
    ->map(function($row) {
      return [
        'codigo' => "javascript:status_wdir('ENTT-' + row.proyecto_id + '-' + row.id, '" . $row->folder(true) . "')",
        'fecha'  => "javascript:status_date_vencimiento(row.fecha, row.estado)",
        'numero' =>  $row->numero,
        'descripcion' => $row->descripcion,
        'folder' => "javascript:status_wdir('" . $row->folder(true) . "', '" . $row->folder(true) . "')",
        'monto'       => 'javascript:status_monto(row.moneda_id, row.monto)',
        'estado_id' => 'javascript:status_select_estado(row.estado_id)',
      ];
    })->get();
    return $listado->response();
  }
  public function tablefy_pagos(Request $request, Proyecto $proyecto) {
    $listado = Pago::paginationPorProyecto($proyecto)
    ->appends(request()->input())
    ->map(function($row) {
      return [
        'codigo'      => "javascript:status_wdir('PAGO-' + row.proyecto_id + '-' + row.id, '" . $row->folder(true) . "')",
        'usuario'   =>  $row->usuario,
        'fecha'       => 'javascript:status_date_vencimiento(row.fecha, row.estado)',
        'numero'      => $row->numero,
        'descripcion' => $row->descripcion,
        'monto'       => 'javascript:status_monto(row.moneda_id, row.monto)',
        'moneda_id'   => 'javascript:status_moneda(row.moneda_id)',
        'codigo_siaf' => $row->codigo_siaf,
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
  public function tablefy_gastos(Request $request, Proyecto $proyecto) {
    $listado = Orden::paginationPorProyecto($proyecto)
    ->appends(request()->input())
    ->map(function($row) {
      return [
        'codigo'      => "javascript:status_wdir('GASTO-' + row.proyecto_id + '-' + row.id, '" . $row->folder(true) . "')",
        'usuario'   =>  $row->usuario,
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
  public function index(Request $request)
  {
      return view('proyectos.index',  $this->viewBag);
  }
  public function porCliente(Request $request, Cliente $cliente)
  {
      $listado = Proyecto::list()->where('cliente_id','=', $cliente->id)->paginate(15)->appends(request()->query());
      $this->viewBag['listado'] = $listado;
      return view('proyectos.index',  $this->viewBag );
  }
  public function create(Request $request, proyecto $proyecto)
  {
      $this->viewBag['proyecto'] = $proyecto;
      $this->viewBag['breadcrumbs'][] = [ 'name' => "Nuevo Proyecto" ];  
      return view($request->ajax() ? 'proyectos.fast' : 'proyectos.create', $this->viewBag );      
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\lain  $lain
   * @return \Illuminate\Http\Response
   */
    public function store(Request $request, Proyecto $proyecto )
    {
        $proyecto->fill($request->all());
        $proyecto->codigo = Proyecto::generarCodigo();
        $proyecto->save();
        $proyecto->log("creado");
        return response()->json(['status'=> "success", 'redirect' => "/proyectos" ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
      $cliente = Cliente::find($proyecto->cliente_id);
      $contacto = Contacto::find($proyecto->contacto_id); 
      return view('proyectos.show', compact('proyecto', 'contacto', 'cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto)
    {
      $this->viewBag['proyecto'] = $proyecto; 
      return view('proyectos.edit', compact('proyecto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto )
    {
      $data = $request->all();
      if(!empty($data['_update'])) {
        $data[$data['_update']] = $data['value'];
        unset($data['value']);
        unset($data['_update']);
      }
      $data['updated_by'] = Auth::user()->id;
      $proyecto->update($data);
      #$proyecto->log("editado");
      return response()->json(['status'=> 'success' ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lain  $lain
     * @param  \DummyFullModelClass  $DummyModelVariable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
      /* Proceso para eliminar */
        $proyecto->eliminado = true;
        $proyecto->save();
        $proyecto->log("eliminado");
        return response()->json(['status'=> true , 'refresh' => true ]);
    }
    public function autocomplete(Request $request)
    {
        $query = strtolower($request->input('query'));
        $data = Proyecto::search( $query )->selectRaw("id, CONCAT_WS(':', codigo,nombre) as value")->get();
        return response()->json($data);
    }
     public function addRepresentante(Request $request, Proyecto $cliente)
     {
        $persona = Persona::updateOrCreate([
            'tipo_documento_id' => $request->input('tipo_documento_id'),
            'numero_documento' => $request->input('numero_documento'),
        ], [
            'nombres' => $request->input('nombres'),
            'apellidos' => $request->input('apellidos'),
            'correo_electronico' => $request->input('correo_electronico'),
            'telefono' => $request->input('telefono'),
        ]);

        $contacto = Contacto::updateOrCreate([
            'cliente_id' => $cliente->id,
            'persona_id' => $persona->id,
        ], [
            'cliente_id' => $cliente->id,
            'persona_id' => $persona->id,
            'correo_electronico' => $request->input('correo_electronico'),
            'telefono' => $request->input('telefono'),
        ]);
        return back();
     }
     public function delRepresentante(Request $request, Proyecto $cliente, Contacto $contacto)
     {
        $contacto->delete();
     // Session::flash('message_success', 'Se ha eliminado correctamente.');
        return back();
     }

     public function observacion(Request $request, Proyecto $proyecto) {
         $proyecto->log('texto',$request->input('texto'));
         return back();
     }
     public function financiero(Request $request, Proyecto $proyecto) {
       $empresa = $proyecto->cotizacion()->empresa();
       return Helper::pdf('proyectos.financiero', compact('proyecto','empresa'), 'L')->stream('demo.pdf');
     }
     public function pdf_situacion(Request $request, Proyecto $proyecto) {
       $empresa = $proyecto->cotizacion()->empresa();
       return Helper::pdf('proyectos.pdf_situacion', compact('proyecto','empresa'), 'L')->stream('demo.pdf');
     }
}
