<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;
use App\Helpers\Helper;
class ReporteController extends Controller
{
    protected $viewBag; 

    public function __construct()
    {
      $this->middleware('auth');
      $this->viewBag['pageConfigs'] = ['pageHeader' => true ];
      $this->viewBag['breadcrumbs'] = [
        ["link" => "/dashboard", "name" => "Home" ],
        ["link" => "/reportes", "name" => "Reportes" ]
      ];
    }
    
    public function index(){
      return view('reportes.index' ,$this->viewBag);
    }

    public function usuarios(){
      return view('reportes.usuarios');
    }

    public function descargar_reporte( Request $request){

      $tipo = $request->get('usuario'); 

      $fecha_desde = $request->get('fecha_desde');
      $fecha_hasta = $request->get('fecha_hasta');

      $formato = $request->get('pdf');

      $usuarios = (Actividad::actividad_usuario($fecha_desde, $fecha_hasta ))->toArray();

      $actividades = Helper::array_group_by( $usuarios, ["key" => "usuario" ]);
    
      // dd( $actividades );

       $actividades = array_map( function ($fecha) {
         return array_map(function($actividad ){
           return [ 'created_on' => Helper::fecha( $actividad['created_on'] ),
                    'usuario'  => $actividad['usuario'],
                    'tipo'  => $actividad['tipo'],
                    'acciones' => $actividad['acciones']
                  ];
         }, $fecha );
        }, $actividades );
      return Helper::pdf('reportes.usuario',compact('actividades') ,'P', "Reportes.pdf" );
    }

    function reporte_usuarios_actividades(){
        
    }


}
