<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;
use Auth;
use App\Facades\DB;
use App\Helpers\Helper;
use App\Empresa;
use App\Contacto;
use App\Llamada;
use App\Caller;

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
      $proyecto_id    = $request->input('proyecto_id');
      $oportunidad_id = $request->input('oportunidad_id');
      $tipo_id        = $request->input('tipo_id');

      $tipo_id        = !empty($tipo_id) ? $tipo_id : 4;

      $actividad = new Actividad;
      $actividad->fecha = date('Y-m-d');
      $actividad->realizado = false;
      $actividad->importancia = 1;
      $actividad->tipo_id = $tipo_id;

      if(!empty($proyecto_id)) {
        $actividad->proyecto_id = $proyecto_id;
      }
      if(!empty($oportunidad_id)) {
        $actividad->oportunidad_id = $oportunidad_id;
      }
      if($tipo_id == 'LLAMADA') {
        $actividad->direccion = 'SALIDA';
        $actividad->tiempo_estimado = '00:05:00';

      } elseif($tipo_id == 'NOTA') {
        $actividad->estado = 3;
        $actividad->hora = date('H:i:s');
      }
      return view($request->ajax() ? 'actividad.fast' : 'actividad.add', compact('tipo_id','actividad'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Actividad $actividad)
    {
      $data = $request->all();
      $data['tenant_id'] = Auth::user()->tenant_id;
      $data['tipo_id'] = !empty($data['tipo_id']) ? $data['tipo_id'] : 4;
      if(!empty($data['fecha_desde'])) {
        $data['fecha'] = date('Y-m-d', strtotime($data['fecha_desde']));
        $data['hora']  = date('H:i:s', strtotime($data['fecha_desde']));
        unset($data['fecha_desde']);
      }
      $actividad->fill($data);
      if(!empty($data['asignado_id'])) {
        $actividad->asignado_id = '{ ' . $data['asignado_id'] .  '}';
      }
      $actividad->save();
//      exec("/usr/bin/php /var/www/html/interno.creainter.com.pe/util/seace/lanzar_llamadas.php");
      return response()->json([
        'status' => true,
        'refresh' => true,
        'redirect' => '/actividades'
      ]);
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
    public function edit(Request $request, Actividad $actividad)
    {
      $tipo = $actividad->tipo;
      return view($request->ajax() ? 'actividad.fast' : 'actividad.add', compact('tipo','actividad'));
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
      if(!empty($data['fecha_desde'])) {
        $data['fecha'] = date('Y-m-d', strtotime($data['fecha_desde']));
        $data['hora']  = date('H:i:s', strtotime($data['fecha_desde']));
        unset($data['fecha_desde']);
      }
      if(!empty($data['asignado_id'])) {
        $data['asignado_id'] = '{' . trim(trim($data['asignado_id'], '{'), '}') . '}';
      }
      $actividad->update($data);
      if($request->ajax()) {
        return response()->json(['status' => true , 'refresh' => true , 'redirect' => '/actividades', 'data' => $data]);
        return response()->json(['status' => true , 'data' => $data ]);
      } else {
        return response()->json(['status' => true , 'data' => $data ]);
      }
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
    public function timeline(Request $request) {
      $data = $request->all();
      $timeline = Actividad::timeline($data);
      $timeline = array_map(function($n) {
        $n['contenido'] = (!empty($n['contenido']) ? $n['contenido'] : '');
        $n['texto']     = $n['tipo'];
        $n['tiempo']    = $n['fecha'] . ' ' . $n['hora']; 
        return $n;
      }, $timeline);
      return response()->json($timeline);
    }
    public function kanban()
    {
      return view('actividad.kanban');
    }

    public function kanban_data() {
      $data = Actividad::kanban();
      $data = array_map(function($n) {
        return [
          'id'        => $n->id,
          'title'     => $n->texto,
          'fecha'     => Helper::fecha($n->fecha),
          'dueDate'   => Helper::fecha($n->fecha_limite),
          'status'    => $n->estado,
          'is_linked' => $n->vinculado,
          'link'      => $n->link,
          'completed' => ($n->estado == 3),
          'users'     => $n->asignado_a,
        ];
      }, $data);
      return response()->json(['status' => true , 'data' => $data]);
    }
    public function kanban_create(Request $request) {

      return response()->json(['status' => true , 'data' => $ls]);
    }
    public function calendario() {
      return view('actividad.calendario');
    }
    public function calendario_proyectos(Request $request) {
      $desde = $request->input('desde');
      $hasta = $request->input('hasta');
      $user  = Auth::user()->id;#$request->input('user_id');
      $data  = Actividad::calendario_proyectos($user, $desde, $hasta);
      return response()->json(['status' => true , 'data' => $data]);
    }
    public function calendario_data(Request $request) {
      $desde = $request->input('desde');
      $hasta = $request->input('hasta');
      $user  = Auth::user()->id;#$request->input('user_id');
      $data  = Actividad::calendario($user, $desde, $hasta);
      return response()->json(['status' => true , 'data' => $data]);
    }
    public function listado_ajax(Request $request) {
      $data = Actividad::por_fecha_usuario($request->fecha, $request->usuario_id);
      if(!empty($data)) {
        $data = array_map(function($n) {
//            $n->momento = Helper::tiempo_transcurrido($n->fecha . ' ' . $n->hora);
            $n->momento = Helper::fecha($n->fecha . ' ' . $n->hora, true);
            return $n;
        }, $data);
      }
      return response()->json($data);
    }
    public function proxy_calls(Request $request) {
      $numero       = $request->input('numero');
      $mensaje      = $request->input('mensaje');
      $contacto_id  = $request->input('contacto_id');
      $caller_id    = $request->input('caller_id');
      $desde_id     = $request->input('desde_id');
      $actividad_id = $request->input('actividad_id');

      if(!empty($actividad_id)) {
        $actividad = Actividad::find($actividad_id);
        if(empty($actividad)) {
          return response()->json([
            'status' => false,
          ]);
        }
        $actividad->update([
          'texto' => $mensaje,
        ]);
        
        return response()->json([
        'status' => true,
        'data'   => [
          'action' => 'save',
          'id' => $actividad_id,
          ],
        ]);
      }

      $caller = Contacto::find($caller_id);
      $desde  = Contacto::find($desde_id);
      if(empty($caller) || empty($desde)) {
        return response()->json([
          'status' => false,
        ]);
      }
      if(empty($contacto_id)) {
        $contacto = Contacto::where('celular', $numero)->first();
        if(empty($contacto)) {
          $contacto = Contacto::create([
            'nombres'    => 'Llamado el ' . Helper::fecha('now', true),
            'celular'    => $numero,
            'tenant_id'  => Auth::user()->tenant_id,
            'created_by' => Auth::user()->id,
          ]);
        }
      } else {
        $contacto  = Contacto::find($contacto_id);
        if(empty($contacto)) {
          return response()->json([
            'status' => false,
          ]);
        }
      }
      $llamada = Llamada::create([
        'tenant_id'          => Auth::user()->tenant_id,
        'created_by'         => Auth::user()->id,
        'caller_numero'      => $caller->celular,
        'caller_contacto_id' => $caller->id,
        'desde_numero'       => $desde->celular,
        'desde_contacto_id'  => $desde->id,
        'hasta_numero'       => $contacto->celular,
        'hasta_contacto_id'  => $contacto->id,
        'estado'             => 0,
        'fecha'              => DB::raw('now()'),
        'direccion'          => 'out',
        'speech_before'      => $mensaje,
      ]);

      $actividad = Actividad::create([
        'tenant_id'   => Auth::user()->tenant_id,
        'created_by'  => Auth::user()->id,
        'llamada_id'  => $llamada->id,
        'tipo_id'     => 2,
        'fecha'       => DB::raw('now()'),
        'hora'        => DB::raw('now()'),
        'estado'      => 1,
        'asignado_id' => '{' . Auth::user()->id . '}',
        'texto'       => $mensaje,
      ]);
      exec("/usr/bin/php /var/www/html/interno.creainter.com.pe/util/seace/lanzar_llamadas.php");

      return response()->json([
        'status' => true,
        'data'   => [
          'action' => 'call',
          'id' => $actividad->id,
        ]
      ]);
    }
}
