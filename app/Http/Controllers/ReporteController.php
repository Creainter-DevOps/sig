<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;
use App\Reporte;
use App\Empresa;
use App\Helpers\Helper;
use App\User;

class ReporteController extends Controller
{
    protected $viewBag; 

    public function __construct()
    {
      //$this->middleware('auth');
      $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
      $this->viewBag['breadcrumbs'] = [
        ["link" => "/dashboard", "name" => "Home" ],
        ["link" => "/reportes", "name" => "Reportes" ]
      ];
    }
    
    public function index(){
      return view('reportes.index' ,$this->viewBag);
    }
    public function licitacion_participaciones() {
      $empresas = Empresa::propias();
      $listado  = Reporte::participaciones();
      $listado  = Helper::array_group_by($listado, [
        ['key' => 'id', 'only' => array('id','aprobado_el','aprobado_por','codigo','rotulo','institucion','fecha_participacion_hasta','fecha_propuesta_hasta','fecha_buena_hasta')],
        ['key' => 'empresa', 'only' => array('empresa','participacion_el','participacion_por','propuesta_el','propuesta_por','monto','ganadores')]
      ]);
      return Helper::pdf('reportes.licitacion_participaciones', compact('empresas','listado'))->stream('exportado.pdf');
    }
    public function avance_mensual() {
      $listado  = Reporte::mensual();
      return Helper::pdf('reportes.avance_mensual', compact('listado'))->stream('exportado.pdf');
    }
    public function usuarios(){
     $licitacion = Helper::array_group_by( Actividad::aprobadas_desaprobadas()->toArray(), ['key'=> 'tipo'] ) ;
     $apro = [];#Helper::array_group_by( $licitacion['LICITACION/APROBAR'] , ['key'=> 'created_on'] ) ;

     $desapro = Helper::array_group_by( $licitacion['LICITACION/RECHAZAR'] , ['key'=> 'created_on'] ) ;

     $dias = [];
     $data_apro = [];
     $data_desapro = [];
     for($i = 0 ; $i < 6 ;  $i++ ){
       $dias[] =date('Y-m-d', strtotime( '-' . $i . ' day', strtotime(date('r'))));  
     }
     $dias = array_reverse( ($dias) );   
     foreach($dias as $dia ){
       $data_apro[] = isset($apro[$dia]) ? $apro[$dia][0]['acciones'] :  0;

     }
     
     foreach( $dias as $dia ){
       $data_desapro[] = isset($desapro[$dia]) ? $desapro[$dia][0]['acciones'] :  0;
     }
     $data_chart['series'] = [
       [ 'name' =>  'Aprobar',
         'data' => $data_apro
       ],
       [ 'name' =>  'Rechazar',
         'data' => $data_desapro
       ],
     ];
     $data_chart = (json_encode($data_chart['series']));
     $data_categorias = json_encode($dias, true ) ; 
     $actividades = Actividad::cantidad_actividades();
     
     $data_pie = [];

     foreach ($actividades as $actividad ){
       $data_pie['series'][] = $actividad->acciones;
       $data_pie['labels'][] = $actividad->tipo;
     }
     $data_pie = json_encode($data_pie); 
     //dd($data_pie) ;
     return view( 'reportes.usuarios', compact( 'data_chart', 'data_categorias', 'data_pie'));

    }

    public function descargar_reporte( Request $request){

     $tipo = $request->get('usuario'); 

     $fecha_desde = $request->get('fecha_desde');
     $fecha_hasta = $request->get('fecha_hasta');

     $formato = $request->get('pdf');

     $usuarios = (Actividad::actividad_usuario($fecha_desde, $fecha_hasta ))->toArray();
     
     $actividades = Helper::array_group_by( $usuarios, ["key" => "usuario" ]);
    
     $actividades = array_map( function ($fecha) {
       return array_map(function($actividad ){
         return [ 'created_on' => Helper::fecha( $actividad['created_on'] ),
                  'usuario'  => $actividad['usuario'],
                  'tipo'  => $actividad['tipo'],
                  'acciones' => $actividad['acciones']
                ];
       }, $fecha );
      }, $actividades );
      return Helper::pdf('reportes.usuario',compact('actividades') ,'P')->stream('exportado.pdf');
    }

    /* Actividades */

    public function pdf_actividad_listado(Request $request) {
      $usuario_id  = $request->input('usuario_id');
      $empresa_id  = $request->input('empresa_id');
      $fecha_desde = $request->input('fecha_desde');
      $fecha_hasta = $request->input('fecha_hasta');
      $usuario = User::find($usuario_id);
      $empresa = Empresa::find($empresa_id);
      $pendientes = Actividad::pendientes($usuario_id, $fecha_desde, $fecha_hasta);
      return Helper::pdf('reportes.actividad.pdf_listado', compact('usuario','empresa','pendientes', 'fecha_desde','fecha_hasta'), 'P')->stream('CuadroDeActividades.pdf');
    }



}
