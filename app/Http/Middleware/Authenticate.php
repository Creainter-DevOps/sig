<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\User;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, \Closure $next, ...$guards) {
      if(!empty($_REQUEST['access_token']) && $_REQUEST['access_token'] == config('app.access_token')) {
        $user = User::find(1);
        $user->tenant_id = $_REQUEST['tenant_id'];
        \Auth::login($user);
        return $next($request);
      }
      return parent::handle($request, $next, $guards);
    }
    protected function redirectTo($request)
    {
      $excepts = ['oportunidades/*'];
      foreach($excepts as $e) {
        if(request()->is($e)) {
          return true;
        }
      }
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
