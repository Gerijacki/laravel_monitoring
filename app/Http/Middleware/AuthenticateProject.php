<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Project;

class AuthenticateProject
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        $project = Project::where('api_token', $token)->first();

        if (!$project) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->setUserResolver(fn () => $project);
        $request->attributes->set('project', $project);

        return $next($request);
    }
}
