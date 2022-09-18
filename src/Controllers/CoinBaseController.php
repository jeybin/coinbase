<?php
namespace Jeybin\Coinbase\Controllers;

use Illuminate\Http\Request;

class CoinBaseController{

    public static function validationMessage($code,$message){
        $error = ($code == 200 || $code == 201) ? true : false;
        return ['code'=>$code,'error'=>$error,'message'=>$message];
    }

    public static function FormatResponse($response,$message='success')
    {
        if(!empty($response['code']) && !empty($response['data'])){
            if(($response['code'] == 201) || ($response['code'] == 200)){
                $data = (isset($response['data'])) ? $response['data'] : $response;
                return ['code'=>$response['code'],
                        'error'=>false,
                        'message'=>$message,
                        'data'=>((isset($data['data'])) ? $data['data'] : $data)];
            }
        }
        return $response;
    }

}