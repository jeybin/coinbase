<?php

namespace Jeybin\Coinbase\Controllers\Client;

use Throwable;
use Jeybin\Coinbase\Controllers\Client\CoinBaseClient;


/**
 * While creating a charge, coinbase generate payment address 
 * for each cryptocurrency that’s enabled. 
 * Coinbase provide with a hosted page to show the user
 *  to complete the payment. 
 */
class CheckoutClient extends CoinBaseClient{

    private static $API_PATH = 'checkouts';

    private static function API($path=''){
        return (!empty($path)) ? self::$API_PATH.'/'.$path : self::$API_PATH;
    }


    public static function CreateCheckout(array $request){
        try {
            return CoinBaseClient::Execute('POST',self::API(),$request);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public static function ShowCheckout(string $checkoutId){
        try {
            return CoinBaseClient::Execute('GET',self::API($checkoutId));
        } catch (Throwable $th) {
            throw $th;
        }
    }


    public static function UpdateCheckout(string $checkoutId,array $request){
        try {
            return CoinBaseClient::Execute('PUT',self::API($checkoutId),$request);
        } catch (Throwable $th) {
            throw $th;
        }
    }


    public static function DeleteCheckout(string $checkoutId){
        try {
            return CoinBaseClient::Execute('DELETE',self::API($checkoutId));
        } catch (Throwable $th) {
            throw $th;
        }
    }


}