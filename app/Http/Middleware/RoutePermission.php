<?php

namespace App\Http\Middleware;

use App\Facades\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;

class RoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $redirect = false;

        if (in_array(Auth::user()->group_id, [1, 2])) {
            $redirect = true;
        }
        else {
            foreach (Permission::permissions() as $route) {

                if ($route['action_name'] == 'view') {

                    if ($route['permission_name'] == 'all') {
                        $redirect = true;
                    }
                    elseif (strpos($_SERVER['REQUEST_URI'], $route['permission_name']) !== false) {
                        $redirect = true;
                        break;
                    }
                    elseif (strpos($_SERVER['REQUEST_URI'], explode(':', $route['permission_name'])[1]) !== false) {
                        $redirect = false;
                        break;
                    }
                }
            }
        }


        if ($redirect) {
            return $next($request);
        }
        else {
            abort(403);
        }

    }
}
