<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }
    public function index() {
      echo 123;
exit;
    }

    /*public function login()
    {
        $credenciales = $this->validate(request(),[
                            'username'=>'required|string',
                            'password'=>'required|string'
                        ]);

        if(Auth::attempt($credenciales)){
            return redirect()->route('dashboard');
        }

        return back()
        ->withErrors(['username'=>'Datos de acceso invalidos!'])
        ->withInput(request(['username']));
    }*/

protected function validateLogin(Request $request){
    $this->validate($request, [
        $this->username() => 'required',
        'new_password_name' => 'required',
    ]);
}
protected function credentials(Request $request)
{
    return $request->only($this->username(), 'new_password_name');
}
protected function authenticated(Request $request, $user)
{
    return response([
        'demo' => 123,
    ]);
}
public function username()
{
    return 'new_username';//or new email name if you changed
}
public function login(Request $request) {
  return view('auth.login');
}
    public function login_check(Request $request)
    {
        $usuario = $request->input('username');
        $clave   = $request->input('password');


        $credenciales = $this->validate(request(),[
                            'username'=>'required|string',
                            'password'=>'required|string'
                          ]);
        $credenciales = array(
          'usuario' => $credenciales['username'],
          'clave'   => $credenciales['password'],
        );
        if(Auth::attempt($credenciales)) {
          Auth::user()->refreshLastSesion();
          return redirect()->route('dashboard');
//        } else {
//          return back()
//            ->withErrors(['username'=>'Datos de acceso invalidos!'])
//            ->withInput(request(['username']));
        }
        exit('aqui-no-llega');
        $login = DB::select("
  SELECT u.id, u.usuario, u.clave, string_agg(g.id::TEXT, ',') AS id_grupo, string_agg(g.nombre, ',') AS grupo
    FROM public.usuario u
    JOIN public.acl_usuario_grupo ug ON ug.usuario_id = u.id
    JOIN public.acl_grupo g ON g.id = ug.grupo_id
   WHERE u.usuario = ? AND u.clave = ?
GROUP BY u.id, u.usuario, u.clave", [$usuario,$clave]);

if(count($login)==1){
  $datos = DB::select("SELECT x.*, array_to_string(x.permisos2, ',') permisos FROM(
	SELECT c.link, array_agg(array_to_string(gp.permisos, ',')) AS permisos2
                                 FROM public.acl_controlador c
                                 JOIN public.acl_grupo_permiso gp ON gp.controlador_id = c.id
                                 WHERE c.eliminado = 0 AND gp.eliminado = 0 AND gp.grupo_id::TEXT = ANY(string_to_array('" . $login[0]->id_grupo . "', ','))
                                 GROUP BY c.link) x;");

            $modulos = array('dashboard');
            $permisos = array('dashboard' => ['show']);

            foreach ($datos as $value) {
                array_push($modulos, $value->link);
                $permisos[$value->link] = explode(",", $value->permisos);
            }

            session()->put('user_id', $login[0]->id);
            session()->put('usuario', $login[0]->usuario);
            session()->put('id_grupo', $login[0]->id_grupo);
            session()->put('grupo', $login[0]->grupo);
            session()->put('modulos', $modulos);
            session()->put('permisos', $permisos);

//            ptv_log("Iniciando session: usuario [" . $login[0]->usuario . "]");

            return redirect()->route('dashboard');

            /*if(Auth::attempt(['usuario'=>$usuario,'clave'=>$clave])){
                return redirect()->route('dashboard');
            }*/
        }else{
            return back()
            ->withErrors(['username'=>'Datos de acceso invalidos!'])
            ->withInput(request(['username']));
        }

    }
    // Login
    public function showLoginForm(){
      $pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image'];
  
        return view('/auth/login', [
            'pageConfigs' => $pageConfigs
      ]);
    }

     /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/identificacion');
    }
}
