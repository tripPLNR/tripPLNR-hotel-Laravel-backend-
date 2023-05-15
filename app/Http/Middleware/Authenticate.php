<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->is('api/*')) {
            $response = [];
            $response['success'] = FALSE;
            $response['message'] = UNAUTHENTICATED;
            $response['status'] = STATUS_UNAUTHORIZED;
            abort(response()->json($response, $response['status']));
        }
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
