<?php

namespace App\Http\Middleware;

use Closure;
use Input;
use Route;
use Session;

class RedirectMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $_redirect = Input::get('__rdt');
        if (!empty($_redirect) && is_array($_redirect) && !empty($_redirect['name'] && !empty($_redirect['route']))) {
            $redirectTable = Session::has('_redirectTable') ? Session::get('_redirectTable') : [];
            $redirectTable[$_redirect['name']] = [
                'ttl'   => max((int)(isset($_redirect['ttl']) ? $_redirect['ttl'] : 0), 3),
                'route' => $_redirect['route'],
                'query' => empty($_redirect['query']) ? [] : $_redirect['query'],
            ];
            Session::put('_redirectTable', $redirectTable);
        }

        $response = $next($request);

        $redirectTable = Session::has('_redirectTable') ? Session::get('_redirectTable') : [];

        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            $currentRouteName = Route::currentRouteName();
            if (! empty($redirectTable[$currentRouteName]) ) {
                $response = redirect() -> route($redirectTable[$currentRouteName]['route'], $redirectTable[$currentRouteName]['query']);
                unset($redirectTable[$_redirect['name']]);
            }
        }

        if (!empty($redirectTable)) {
            foreach ($redirectTable as $name => $table) {
                if (--$table['ttl'] <= 0) {
                    unset($redirectTable[$name]);
                } else {
                    $redirectTable[$name] = $table;
                }
            }
        }

        Session::put('_redirectTable', $redirectTable);

        return $response;

    }

}
