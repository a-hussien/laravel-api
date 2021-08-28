<?php

namespace App\Http\Controllers\Api\Admin;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use GeneralTrait;
    
    public function __construct()
    {
        $this->middleware('auth.guard:admin-api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        
        $requests = $request->only(['email', 'password']);
        try {
            // Validation
            $rules = [
                'email' => 'required|email|exists:admins,email',
                'password' => 'required|between:8,20',
            ];
    
            $validator = Validator::make($requests, $rules);
    
            if($validator->fails())
            {   
                $code = $this->returnValidationErrorCode($validator);
                return $this->returnValidationError($code, $validator);
            }

            // Login
            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('admin-api')->attempt($credentials);

            // on Failure
            if(!$token) 
            {
                return $this->onError('Invalid Credentials');
            }
            
            // on Success
            $admin_data = Auth::guard('admin-api')->user();
            $admin_data->api_token = $token;

            return $this->onSuccess('data', $admin_data);
            
        } catch (\Exception $ex) {
            return $this->onError($ex->getMessage());
        }
        
    }

    public function logout(Request $request)
    {
        $token = $request->header('authorization');

        if(!$token)
        {
            return $this->onError('Something went Wrong');
        }
        else 
        {
            try 
            {
                JWTAuth::setToken($token)->invalidate();

            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $th) {

                return $this->onError('Something went Wrong');
            }

            return $this->onSuccess('logout','Logout Successfully');
        }
    }

    public function profile()
    {
        return Auth::user();
    }
}
