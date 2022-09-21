<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle2($request, Closure $next, ...$guards) {
      if (Auth::guest()) {
        return response()->json(['message' => 'you shall not pass']);
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
