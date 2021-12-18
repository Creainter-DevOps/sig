<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;
use Auth;
class ActividadController extends Controller
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
            $listado = Actividad::search($search)->paginate(15)->appends(request()->query());
        } else {
            $listado = Actividad::orderBy('created_on', 'desc')->paginate(15)->appends(request()->query());
        }
        return view('actividad.index', ['listado' => $listado]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
      $proyecto_id = $request->input('proyecto_id');
      $actividad = new Actividad;
      $actividad->fecha = date('Y-m-d');
      if(!empty($proyecto_id)) {
        $actividad->proyecto_id = $proyecto_id;
      }
      return view($request->ajax() ? 'actividad.fast' : 'actividad.add', compact('actividad'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Actividad $actividad)
    {
      $actividad->fill($request->all());
      $actividad->asignado_id = '{ ' . $request->input('asignado_id') .  '}';
      $actividad->save();
      return response()->json(['status' => true , 'refresh' => true , 'redirect' => '/actividades' ]);
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

    public function kanban()
    {
      return view('actividad.kanban');
    }

    public function kanban_data() {
      $data = Actividad::kanban();
      $data = array_map(function($n) {
        return [
          'id' => $n->id,
          'title' => $n->texto,
          'dueDate' => $n->fecha_limite,
          'status' => $n->estado,
          'is_linked' => $n->vinculado,
          'link' => $n->link,
        ];
      }, $data);
      return response()->json(['status' => true , 'data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Actividad $actividad)
    {
        return view($request->ajax() ? 'actividad.fast_edit' : 'actividad.edit', compact('actividad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actividad $actividad)
    {
      $data = $request->all();
      if(!empty($data['_update'])) {
        $data[$data['_update']] = $data['value'];
        unset($data['value']);
        unset($data['_update']);
      }
      $actividad->update($data);
      return response()->json(['status' => true , 'data' => $data ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Actividad  $actividad)
    {
      $actividad->eliminado = true;
      return response()->json(['status' => true,'refresh' => true ]);  
    }

    public function autocomplete(Request  $request  ) {
      $query = strtolower($request->input('query'));
      $data = Actividad::search($query)
        ->selectRaw("osce.actividad.id, CONCAT('ENTREGABLE ', osce.actividad.numero) as value");
      if($request->input('proyecto_id') != null) {
        $data->where('proyecto_id', '=', $request->input('proyecto_id'));
      }
      return response()->json($data->get());
    }
}
