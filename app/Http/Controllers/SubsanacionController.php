<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subsanacion;
use App\Empresa;
use App\Documento;
use Auth;


class SubsanacionController extends Controller
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
        ["link" => "/proyectos", "name" => "Subsanaciones" ]
      ];
    }

    public function expediente(Request $request, Subsanacion $subsanacion) {
      if(empty($subsanacion->documento_id)) {
        $documento = Documento::nuevo([
          'cotizacion_id'   => $subsanacion->cotizacion_id,
          'oportunidad_id'  => $subsanacion->cotizacion()->oportunidad_id,
          'licitacion_id'   => $subsanacion->oportunidad()->licitacion_id,
          'es_plantilla'    => false,
          'es_ordenable'    => false,
          'es_reusable'     => false,
          'tipo'            => 'SUBSANACION',
          'folio'           => 0,
          'rotulo'          => $subsanacion->oportunidad()->codigo,
          'filename'        => 'Subsanacion_Propuesta_Seace.pdf',
          'formato'         => 'PDF',
          'directorio'      => trim($subsanacion->folder(true), '/'),
          'filesize'        => 0,
          'es_mesa'         => true,
          'elaborado_por'   => Auth::user()->id,
          'respaldado_el'   => null,
          'archivo'         => 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf'),
          'original'        => 'tenant-' . Auth::user()->tenant_id . '/' . gs_file('pdf')
        ]);
        $subsanacion->documento_id = $documento->id;
        $subsanacion->save();

        return redirect('/documentos/'. $documento->id . '/expediente/inicio');
      } else {
        return redirect('/documentos/'. $subsanacion->documento_id . '/expediente/inicio');
      }
  }
}
