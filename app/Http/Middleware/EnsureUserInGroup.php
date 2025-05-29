<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserInGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     //TODO проверку на активного пользователяы
    public function handle(Request $request, Closure $next): Response
    {
        $group = $request->route('group');
        if (!$group->users->contains(Auth::id())) {
            abort(403, 'У вас нет доступа к данной странице');
        }
        
        return $next($request);
    }
}
