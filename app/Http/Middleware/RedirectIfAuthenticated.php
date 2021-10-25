<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
/*    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }*/
    public function handle($request, Closure $next, $guard = null)
    {

        /*if (Auth::guard($guard)->check()) {
            return redirect('/dashboard');
        }
        return $next($request);*/
        //echo "<pre>"; print_r(session()); echo "</pre>"; exit;

        //echo "SESION:".session()->get('user_id');
        //exit;

        if (!session()->has('user_id')) {
            return redirect('/');
        }
        else {
            $modulos = session()->get('modulos');

            if(!$this->estaPermitido($request, $modulos)) {
                Session::flash('message_error', "Módulo " . $request->path() . " no permitido!");
                return redirect('/dashboard/');
            }
        }

        return $next($request);
    }

    private function estaPermitido($request, $modulos)
    {
      $modulo = $request->path();

      if(in_array($modulo, $modulos) || $request->ajax()) {
          return true;
      }
      if(!empty($modulos)) {
          foreach($modulos as $m) {
            if(strpos($modulo, $m . "/") === 0) {
                return true;
            }
          }
      }
      return false;
    }
}
