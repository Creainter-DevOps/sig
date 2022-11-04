<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carta;
use App\Documento;
use Auth;
use Illuminate\Support\Facades\DB;

class CartaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {
      $proyecto_id = $request->input('proyecto_id');
      $carta = new Carta;
      if (!empty($proyecto_id )){
        $carta->proyecto_id = $proyecto_id;
      } 
      return view( $request->ajax() ? 'carta.fast' : 'carta.create', compact('carta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Carta $carta)
    {
      $carta->fill($request->all());
      $carta->orden($carta->proyecto_id);
      $carta->save();
      return response()->json(['status' => true, 'refresh'  => true  ]);
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
    public function edit(Request $request, Carta  $carta)
    {
      return view( $request->ajax() ? 'carta.fast_edit' : 'carta.create', compact('carta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carta $carta )
    {
      $data = $request->all();
    if(!empty($data['_update'])) {
      $data[$data['_update']] = $data['value'];
      unset($data['value']);
      unset($data['_update']);
    }

      $carta->update($data);
      return response()->json( [ 'status' => true, 'refresh' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Carta $carta )
    {
      $carta->eliminado = true; 
      return response()->json( [ 'status' => true, 'refresh' => true ]);
    }
  public function expediente(Request $request, Carta $carta) {
      if(empty($carta->documento_id)) {
        $documento = Documento::nuevo([
          'cotizacion_id'   => $carta->proyecto()->cotizacion_id,
          'oportunidad_id'  => $carta->proyecto()->oportunidad_id,
          'licitacion_id'   => $carta->proyecto()->oportunidad()->licitacion_id,
          'es_plantilla'    => false,
          'es_ordenable'    => false,
          'es_reusable'     => false,
          'tipo'            => 'EXPEDIENTE',
          'folio'           => 0,
          'rotulo'          => 'Carta: ' . $carta->numero,
          'filename'        => 'Carta.pdf',
          'formato'         => 'PDF',
          'directorio'      => trim($carta->folder(true), '/'),
          'filesize'        => 0,
          'es_mesa'         => true,
          'elaborado_por'   => Auth::user()->id,
          'elaborado_desde' => DB::raw('now()'),
          'respaldado_el'   => null,
          'archivo'         => 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf'),
          'original'        => 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf')
        ]);
        $carta->documento_id = $documento->id;
        $carta->save();

        return redirect('/documentos/'. $documento->id . '/expediente/inicio');
      } else {
        return redirect('/documentos/'. $carta->documento_id . '/expediente/inicio');
      }
  }
}
