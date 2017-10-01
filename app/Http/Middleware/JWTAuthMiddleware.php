<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTAuthMiddleware extends BaseMiddleware
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
        if ( ! $token = $this->auth->setRequest($request)->getToken()) {
            return response()->error(['Token not provided'], 400);
        }
        try {
            $user = $this->auth->authenticate($token);
        }
        catch (TokenExpiredException $e){
            return response()->error(['Token expired.'], 444);
        }
        catch (JWTException $e){
            return response()->error(['User not found.'], 404);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);

    }
}
