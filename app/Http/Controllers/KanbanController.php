<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;
use App\Bloque;

class KanbanController extends Controller
{
  function index() {
    $actividades = Bloque::with('item')->selectRaw('id, nombre as title') ->get();
    return view('kanban.index');  
  }
  function actividades( Request $request ){
    $actividades = Bloque::with('item')->selectRaw('id, nombre as title')->get();
    foreach($actividades as $actividad ){
      $actividad->id = "kanban-board-" . $actividad->id;

      foreach( $actividad->item as $item){
          $item->title = $item->evento;
          $item->border = "success";
          $item->comment = 5;
          if(isset($item->fecha_limite)){
            $item->dueDate = $item->fecha_limite;
          }
          $item->users =  [
            "images/portrait/small/avatar-s-11.jpg",
            "images/portrait/small/avatar-s-12.jpg"
          ];
       }  
    } 
    return response()->json(['status' => true, 'list' => $actividades ]); 
  }
  
}
