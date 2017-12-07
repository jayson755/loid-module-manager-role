<?php

namespace Loid\Module\Manager\Role\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use LogicRole;

class Permission{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        
        echo 33333333;die;
        
        if (false === LogicRole::checkUserPermissions($request, \Auth::user())) {
            if ($request->ajax()) {
                return response()->json(['code'=>0, 'msg'=>'无操作权限']);
            } else {
                echo '无操作权限';die;
            }
        }
        
        return $next($request);
    }
}
