<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{

    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = null;

        try {

            $user = JWTAuth::parseToken()->authenticate();
            
            if( !$user ) throw new Exception('User Not Found');
            
        } catch (Exception $e) {
            
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
            
                return $this->onError('Token Invalid');
                
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                
                return $this->onError('Token Expired');
            
            }else {
     
            if( $e->getMessage() === 'User Not Found') {
                
                return $this->onError('User Not Found');
            
            }

            return $this->onError('Authorization Token not found');
                
            }
            
        }
            
        return $next($request);
            
    }
}
