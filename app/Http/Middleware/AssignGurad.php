<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AssignGurad extends BaseMiddleware
{

    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {

        if($guard != null)
        {
            auth()->shouldUse($guard);
            $token = $request->header('authorization');
            $request->headers->set('authorization', (string)$token, true);
            $request->headers->set('Authorization', 'Bearer'.$token, true);
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (TokenExpiredException $e) {
                return $this->onError('Token Expired');
            }
        }
            
        return $next($request);

        // $user = null;

        // try {

        //     $user = JWTAuth::parseToken()->authenticate();
            
        //     if( !$user ) throw new Exception('User Not Found');
            
        // } catch (Exception $e) {
            
        //     if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
            
        //         return $this->onError('Token Invalid');
                
        //     }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                
        //         return $this->onError('Token Expired');
            
        //     }else {
     
        //     if( $e->getMessage() === 'User Not Found') {
                
        //         return $this->onError('User Not Found');
            
        //     }

        //     return $this->onError('Authorization Token not found');
                
        //     }
            
        // }
            
       
            
    }
}
