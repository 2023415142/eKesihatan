<?php
 
namespace App\Http\Middleware;
 
use Illuminate\Http\Request;
 
class EnsureRole
{
    public function handle(Request $request, \Closure $next, ...$roles)
    {
        $user = $request->user();
 
        if (!$user) {
            abort(403);
        }
 
        if (!empty($roles) && !in_array($user->role, $roles, true)) {
            abort(403);
        }
 
        return $next($request);
    }
}