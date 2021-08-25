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


}