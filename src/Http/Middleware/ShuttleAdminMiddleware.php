<?php

namespace Sina\Shuttle\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ShuttleAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Auth::shouldUse('shuttle_api');

        $is_api = in_array('api', $request->route()->middleware());
        if($is_api){
            Auth::shouldUse('shuttle_api');
        }else{
            Auth::shouldUse('shuttle');
        }

        if (!Auth::guest()) {
        //     $user = Auth::user();
        //     app()->setLocale($user->locale ?? app()->getLocale());
            return $next($request);

        //     return $user->hasPermission('browse_admin') ? $next($request) : redirect('/');
        }

        // $urlLogin = route('voyager.login');

        if($is_api)
        {
            return response()->json(['unautorized' => 'unautorized'],401);
        }

        // return redirect()->guest($urlLogin);

        return $next($request);

    }
}