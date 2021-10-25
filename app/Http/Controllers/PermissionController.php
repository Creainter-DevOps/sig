<?php

namespace App\Http\Controllers;

use App\ACLControlador;
use App\ACLGrupo;
use App\ACLGrupoPermiso;
use App\ACLUsuario;
use App\ACLUsuarioGrupo;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Redirect;
use stdClass;

class PermissionController extends Controller
{
    public function __construct()
    {
//        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\lain  $lain
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usuarios = Permission::usuarios();
        $modulos  = Permission::modulos();
        $grupos  = Permission::grupos();
        return view('permissions.index', compact('usuarios', 'modulos', 'grupos'));
    }
    public function UsuarioPermisos(Request $request, ACLUsuario $aclusuario)
    {
        if ($request->isMethod('post')) {
            $accion = $request->input('accion');
            ACLUsuarioGrupo::where('usuario_id', $aclusuario->id)->update(['eliminado' => 1]);
            if(!empty($accion)) {
                foreach ($accion as $grupo_id => $acciones) {
                    ACLUsuarioGrupo::updateOrCreate(
                        [
                            'usuario_id' => $aclusuario->id,
                            'grupo_id'   => $grupo_id
                        ],
                        [
                            'eliminado' => 0
                        ]
                    );
                }
            }
            return response()->json([
                'status'  => 'success',
                'message' => 'Se ha realizado registro con éxito.',
                'data' => [
                ],
            ]);
        } else {
            $permisos = $aclusuario->permisos();
            $p2 = array_map(function($n) {
                return $n->grupo_id;
            }, $permisos);
            $listado = Permission::grupos();
            $listado = array_map(function ($grupo) use ($p2) {
                $grupo->checked = in_array($grupo->id, $p2);
                return $grupo;
            }, $listado);
            return view('permissions.usuario_permisos', compact('aclusuario', 'listado'));
        }
    }
    public function GrupoPermisos(Request $request, ACLGrupo $aclgrupo)
    {
        if ($request->isMethod('post')) {
            $accion = $request->input('accion');
            ACLGrupoPermiso::where('grupo_id', $aclgrupo->id)->update(['eliminado' => 1]);
            if(!empty($accion)) {
                foreach ($accion as $controlador_id => $acciones) {
                    $acciones = array_keys($acciones);
                    ACLGrupoPermiso::updateOrCreate(
                        [
                            'grupo_id' => $aclgrupo->id,
                            'controlador_id' => $controlador_id
                        ],
                        [
                            'permisos'  => '{"' . implode('","', $acciones) . '"}',
                            'eliminado' => 0
                        ]
                    );
                }
            }
            return response()->json([
                'status'  => 'success',
                'message' => 'Se ha realizado registro con éxito.',
                'data' => [
                ],
            ]);
        } else {
            $permisos = $aclgrupo->permisos();
            $p2 = [];
            foreach ($permisos as $p) {
                $p2[$p->controlador_id] = explode(',', $p->permisos);
            }
            $listado = Permission::modulos();
            $listado = array_map(function ($controlador) use ($p2) {
                $controlador->permisos = explode(',', $controlador->permisos);
                $controlador->permisos = array_map(function ($accion) use ($controlador, $p2) {
                    $checked = false;
                    if (isset($p2[$controlador->id])) {
                        if (in_array($accion, $p2[$controlador->id])) {
                            $checked = true;
                        }
                    }
                    return (object) [
                        'checked' => $checked,
                        'accion'  => $accion,
                    ];
                }, $controlador->permisos);
                return $controlador;
            }, $listado);
            return view('permissions.grupo_permisos', compact('aclgrupo', 'listado'));
        }
    }
    public function crearGrupo(Request $request)
    {
        if ($request->isMethod('post')) {
            $nombre = $request->input('nombre');
            $descripcion = $request->input('descripcion');

            if (empty($nombre) || empty($descripcion)) {
                exit('se requieren más campos');
            }
            $e = new ACLGrupo;
            $e->nombre      = $nombre;
            $e->descripcion = $descripcion;
            $e->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Con exito',
                'refresh' => true,
                'data'    => [
                    'id'    => $e->id,
                    'value' => $nombre,
                ],
            ]);
        } else {
            return view('permissions.grupo');
        }
    }
    public function GrupoEdit(Request $request, ACLGrupo $grupo)
    {
        if ($request->isMethod('post')) {
            $nombre = $request->input('nombre');
            $descripcion = $request->input('descripcion');
            $permisos = $request->input('permisos');
            $grupo->update([
                'nombre'      => $nombre,
                'descripcion' => $descripcion,
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Con exito',
                'refresh' => true,
                'data'    => [
                ],
            ]);
        } else {
            return view('permissions.grupo', compact('grupo'));
        }
    }
    public function ControladorEdit(Request $request, ACLControlador $controlador)
    {
        if ($request->isMethod('post')) {
            $rotulo = $request->input('rotulo');
            $link = $request->input('link');
            $permisos = $request->input('permisos');
            $controlador_padre_id = $request->input('controlador_padre_id');

            $controlador->update([
                'rotulo' => $rotulo,
                'link'   => $link,
                'permisos' => '{"' . $permisos . '"}',
                'controlador_padre_id' => $controlador_padre_id,
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Con exito',
                'refresh' => true,
                'data'    => [
                ],
            ]);
        } else {
            $controlador->permisos = preg_replace('/[\}\{]/', "", $controlador->permisos);
            return view('permissions.controlador', compact('controlador'));
        }
    }
    public function crearControlador(Request $request)
    {
        if ($request->isMethod('post')) {
            $rotulo = $request->input('rotulo');
            $link = $request->input('link');
            $permisos = $request->input('permisos');
            $controlador_padre_id = $request->input('controlador_padre_id');

            if (empty($rotulo) || empty($link) || empty($permisos)) {
                exit('se requieren más campos');
            }
            $permisos = explode(',', $permisos);
            $permisos = array_map(function ($n) {
                return strtolower(trim($n));
            }, $permisos);

            $e = new ACLControlador;
            $e->rotulo   = $rotulo;
            $e->link     = $link;
            $e->controlador_padre_id = $controlador_padre_id;
            $e->permisos = '{"' . implode('","', $permisos) . '"}';
            $e->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Con exito',
                'refresh' => true,
                'data'    => [
                    'id'    => $e->id,
                    'value' => $rotulo,
                ],
            ]);
        } else {
            return view('permissions.controlador');
        }
    }
    public function autocomplete_modulo(Request $request)
    {
        $query = strtolower($request->input('query'));
        $data = ACLControlador::select("rotulo as value",'id')
        ->whereRaw("LOWER(rotulo) LIKE ?",["%{$query}%"])
        ->get();
        return response()->json($data);
    }
}

