<?php

namespace Jeybin\Coinbase\Controllers\Client;

use Illuminate\Support\Facades\Http;
use Jeybin\Coinbase\Helpers\Helpers;

class CoinBaseClient{
    
    
    private const BASE_URL    = 'https://api.commerce.coinbase.com/{data}';

    private static function COINBASE_API($type=''):string{
        try {
            return str_replace('{data}',$type,SELF::BASE_URL);
        } catch (\Throwable $th) {
            throw $th;
        }    
    }


    private static function GET_HEADERS(array $additional_headers=[]){
        try {
            $headers = ['Accept'       => 'application/json',
                        'Content-Type' => 'application/json',
                        'X-CC-Version' => config('coinbase.COINBASE_API_VERSION'),
                        'X-CC-Api-Key' => config('coinbase.COINBASE_API_KEY')];

            return array_merge($headers,$additional_headers);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private static function GET_REQUEST($HTTP,string $API){
        try {
            return $HTTP->get($API);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private static function POST_REQUEST($HTTP, $API, $BODY=[]){
        try {
            return $HTTP->post($API,$BODY);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private static function PUT_REQUEST($HTTP, $API, $BODY=[]){
        try {
            return $HTTP->put($API,$BODY);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private static function DELETE_REQUEST($HTTP, $API, $BODY=[]){
        try {
            return $HTTP->delete($API,$BODY);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private static function FORMAT_RESPONSE($response){
        try {
            $statusCode = $response->status();
            if($statusCode !== 200 && $statusCode !== 201){
                $message = ($statusCode == 404) ? 'Not found' : (!empty($response->getReasonPhrase()) ? 'Coinbase : '.$response->getReasonPhrase() : '');
                return Helpers::response($statusCode,$message);
            }
            return ['code'=>200,'error'=>false,'messge'=>'Coinbase response','data'=>$response->json()];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected static function Execute($TYPE,$API='',$REQUEST_BODY=[],$HEADERS=[]){
        try {

            $API_URL     = SELF::COINBASE_API($API);
            $HTTP        = HTTP::withHeaders(SELF::GET_HEADERS($HEADERS));
            switch (strtoupper($TYPE)) {
                case 'GET':
                    $response = SELF::GET_REQUEST($HTTP,$API_URL);
                    break;
                case 'POST':
                    $response = SELF::POST_REQUEST($HTTP,$API_URL,$REQUEST_BODY);
                    break;
                case 'PUT':
                    $response = SELF::PUT_REQUEST($HTTP,$API_URL,$REQUEST_BODY);
                    break;
                case 'DELETE':
                    $response = SELF::DELETE_REQUEST($HTTP,$API_URL,$REQUEST_BODY);
                    break;
                default:
                    return Helpers::response(422,'invalid request for api execute');
            }
            
            return SELF::FORMAT_RESPONSE($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }




}