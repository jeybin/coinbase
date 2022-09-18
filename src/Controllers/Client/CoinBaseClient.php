<?php

namespace Jeybin\Coinbase\Controllers\Client;

use Illuminate\Support\Facades\Http;
use Jeybin\Coinbase\Helpers\Helpers;

class CoinBaseClient{
    
    
    private const BASE_URL    = 'https://api.commerce.coinbase.com/{data}';
    private const API_VERSION = '{{coinbase-api-version}}';
    private const API_KEY     = '{{coinbase-api-key}}';

    private static function COINBASE_API($type=''):string{
        try {
            return str_replace('{data}',$type,SELF::BASE_URL);
        } catch (\Throwable $th) {
            throw $th;
        }    
    }


    private static function GET_HEADERS(array $additional_headers=[]):array{
        try {
            $headers = ['Accept'       => 'application/json',
                        'Content-Type' => 'application/json',
                        'X-CC-Version' => SELF::API_VERSION,
                        'X-CC-Api-Key' => SELF::API_KEY];
            
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


    private static function FORMAT_RESPONSE($response){
        try {
            $statusCode = $response->status();
            if($statusCode !== 200 && $statusCode !== 201){
                $message = ($statusCode == 404) ? 'Invalid coinbase api' : '';
                return Helpers::response($statusCode,$message);
            }
            return ['code'=>200,'error'=>false,'messge'=>'Coinbase response','data'=>$response->json()];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected static function Execute($TYPE,$API='',$REQUEST_BODY=[],$HEADERS=[]){
        try {
            $TYPE = strtolower($TYPE);
            if(!in_array($TYPE,['get','post','put','delete'])){
                return Helpers::response(422,'invalid request for api execute');
            }

            $API_URL     = SELF::COINBASE_API($API);
            $HTTP        = HTTP::withHeaders(SELF::GET_HEADERS($HEADERS));
            switch ($TYPE) {
                case 'post':
                    $response = SELF::POST_REQUEST($HTTP,$API_URL,$REQUEST_BODY);
                    break;
                case 'put':
                    $response = SELF::POST_REQUEST($HTTP,$API_URL,$REQUEST_BODY);
                    break;
                case 'delete':
                    $response = SELF::POST_REQUEST($HTTP,$API_URL,$REQUEST_BODY);
                    break;
                default:
                    # GET REQUEST
                    $response = SELF::GET_REQUEST($HTTP,$API_URL);
                    break;
            }
            
            return SELF::FORMAT_RESPONSE($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }




}