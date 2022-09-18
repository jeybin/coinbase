<?php
namespace Jeybin\Coinbase\Helpers;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

Class Helpers {


    public static function response($responseCode,$message=''){
        switch ($responseCode) {
            case 200:
                $status = ['code'=>200, 'message'=>($message)?$message:'SUCCESS', 'error'=>FALSE];
                break;
            case 204:
                $status = ['code'=>204,  'message'=>($message)?$message:'NO CONTENT', 'error'=>TRUE];
                break;
            case 400:
                $status = ['code'=>400,  'message'=>($message)?$message:'BAD REQUEST', 'error'=>TRUE];
                break;
            case 401:
                $status = ['code'=>401,  'message'=>($message)?$message:'Unauthorized user', 'error'=>TRUE];
                break;
            case 403:
                $status = ['code'=>403,  'message'=>($message)?$message:'Forbidden', 'error'=>TRUE];
                break;
            case 404:
                $status = ['code'=>404,  'message'=>($message)?$message:'Page not found!', 'error'=>TRUE];
                break;
            case 405:
                $status = ['code'=>405,  'message'=>($message)?$message:'Method Not Allowed', 'error'=>TRUE];
                break;
            case 406:
                $status = ['code'=>406,  'message'=>($message)?$message:'Not Acceptable', 'error'=>TRUE];
                break;
            case 422:
                $status = ['code'=>422,  'message'=>($message)?$message:'Unprocessable Entity', 'error'=>TRUE];
                break;
            case 500:
                $status = ['code'=>500,  'message'=>($message)?$message:'Internal Server Error', 'error'=>TRUE];
                break;
            default:
                $status = ['code'=>500,  'message'=>($message)?$message:'Internal Server Error', 'error'=>TRUE];
                break;
        }
        return $status;
    }




    public static function throwResponse($message='Exceptions',$data=[],$statusCode=500){
        if ((gettype($message) !== 'string') && ($message instanceof \Exception)) {
            if($message->getMessage()){
                $data      = (!empty($message->getTrace()))   ? $message->getTrace()   : [];
                $message   = (!empty($message->getMessage())) ? $message->getMessage() : "Something went wrong";
                $data      = $data?:[$message];
                $statusCode = 500;
            }else{
                throw new HttpResponseException($message->getResponse());
            }
        }
        $errStatus = (in_array($statusCode,[200,201])) ? false : true;
        $response = ['code'=>(int)$statusCode,'error'=>$errStatus,"message"=>$message];
        if(!empty($data)){
            $response['data'] = $data;
        }
        if($statusCode == 200 && $data == "empty"){
            $response['data'] = [];
        }           
        throw new HttpResponseException(response()->json($response,$statusCode));
    }
}