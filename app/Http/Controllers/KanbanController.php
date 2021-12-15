<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;
use App\Bloque;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Builder;



class KanbanController extends Controller
{
  function index() {
//    $actividades = Bloque::with('item')->selectRaw('id, nombre as title') ->get();
    $actividades = [];
    return view('kanban.index');  
  }
  function actividades( Request $request ){
    $actividades = Bloque::with('item')->selectRaw('id, nombre as title')->where('eliminado',false)->get();
    foreach($actividades as $actividad ){

      foreach( $actividad->item as $item){
          $item->title =  isset($item->evento) ? $item->evento : '';
          $item->evento = isset($item->evento) ? $item->evento : '';
          $item->texto =  isset($item->texto) ? $item->texto : ''; 
          $item->asignado = $item->usuario();
          $item->asignado_id = isset($item->asignado_id) ? $item->asignado_id : '';
          $item->border = isset( $item->color) ? $item->color : 'success'; 

          if(isset($item->fecha_limite)){
            $item->duedate = Helper::fecha( $item->fecha_limite );
            $item->duedate_format = date( 'Y-m-d', strtotime( $item->fecha_limite ));
          }
          if( isset($item->fecha_comienzo)){
            $item->fecha_comienzo = date( 'Y-m-d', strtotime( $item->fecha_comienzo )); 
          }
          $item->users = [
            "images/portrait/small/avatar-s-11.jpg",
            "images/portrait/small/avatar-s-12.jpg"
          ];
       }  
    } 
    return response()->json(['status' => true, 'list' => $actividades ]); 
  }
  
}
