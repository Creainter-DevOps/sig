<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UsuarioEmpresa;

class UsuarioController extends Controller
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
        ["link" => "/usuarios", "name" => "Usuarios" ]
      ];
    }

    public function index()
    {
      $this->viewBag['listado'] = User::paginate(15);      
      return view('usuarios.index',$this->viewBag );     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('usuarios.create', $this->viewBag );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $user = User::find($id); 
       $perfiles = UsuarioEmpresa::perfiles_usuario($id);
      return view('usuarios.show', compact('user','perfiles')); 
    }
    public function crear_perfil(UsuarioEmpresa $perfil, Request $request ){
      $perfil->usuario_id = $request->usuario_id;  
      return view('usuarios.perfil', compact('usuario_id' ,'perfil'));
    }
    public function editar_perfil( UsuarioEmpresa $perfil ){
        return view('usuarios.perfil',compact('perfil'));
    }
    public function update_perfil(UsuarioEmpresa $perfil,  Request $request ){
        $perfil->fill($request->all());
        $perfil->save();  
    }
    public function eliminar_perfil( UsuarioEmpresa $perfil){
       // dd($perfil);
       $perfil->update(['eliminado' => true]);
       return response()->json(['status' => true, 'refresh' => true ]);
    } 
    public function perfil_store(Request $request ){
        if(empty($request->perfil_id) ){
            $usuario = new UsuarioEmpresa();
            $usuario->fill($request->all());
            $usuario->save();
            return response()->json(['status' => true, 'refresh' => true ]);
        }else{
            $usuario = UsuarioEmpresa::find($request->perfil_id);
            $usuario->update($request->all());
            return response()->json(['status' => true, 'refresh' => true ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $user )
    {
        $usuario = User::find($user);
        $this->viewBag['breadcrumbs'] [] = ['name' => "Editar usuario" ] ;
        $this->viewBag['usuario'] = $usuario;
        return view ( 'usuarios.edit', $this->viewBag );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function autocomplete(Request  $request ){
      $query = $request->input('query');
      $data =  User::search($query)->select('id', 'usuario as value')->get();
      return response()->json( $data ); 
    }
}
