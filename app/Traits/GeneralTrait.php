<?php

namespace App\Traits;

Trait GeneralTrait  
{
    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function onError($msg = 'Request Failed')
    {
        return response()->json([
            'code' => 401,
            'status' => false,
            'msg' => $msg
        ]);
    }

    public function onSuccess($key, $value, $msg = 'Request Success')
    {
        return response()->json([
            'code' => 200,
            'status' => true,
            'msg' => $msg,
            $key => $value,
        ]);
    }

    public function returnValidationError($code, $validator)
    {
        return response()->json([
            'code' => $code,
            'status' => false,
            'msg' => $validator->errors()->first()
        ]);
    }

    public function returnValidationErrorCode($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);

        return $code;
    }

    public function getErrorCode($input)
    {
        if($input == 'name')
        {
            return 'F001';
        }elseif ($input == 'email') {
            return 'F002';
        }elseif ($input == 'password') {
            return 'F003';
        }else{
            return 'U005';
        }
        
    }


}