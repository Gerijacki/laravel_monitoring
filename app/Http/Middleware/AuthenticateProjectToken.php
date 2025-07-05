<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;

class AuthenticateProjectToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        $project = Project::where('api_token', $token)->first();

        if (!$project) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->merge(['project' => $project]);

        return $next($request);
    }
}
