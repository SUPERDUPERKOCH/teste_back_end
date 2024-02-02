<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\RedirectLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {

        // $user = Auth::user();
        
        $log = new RedirectLog([
            'id' => $request->route('id'),
            'ip_request' => $request->ip(),
            'user_request' => 1,
            'header_referer' => $request->url(),
            'query_params' => json_encode($request->query()),
            'data_hora_acesso' => Carbon::now(),
        ]);
        $log->save();

        return $next($request);
    }
}
