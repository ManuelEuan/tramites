<?php

namespace App\Http\Middleware;

use Closure;

class Permiso
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
        $auth = auth()->user();
        if($auth == null){
            return redirect('/logout');
        }
        
        $ruta = "/" .$request->route()->uri;

        foreach($auth->TRAM_CAT_ROL->TRAM_DET_PERMISOROL as $item){
            if($item->TRAM_CAT_PERMISO->PERMI_CRUTA == $ruta){
                return $next($request);
                break;
            }
        }

        return redirect('/logout');
    }
}
