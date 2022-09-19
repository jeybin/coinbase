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
class CoinBaseCheckoutClient extends CoinBaseClient{

    public static function CreateCheckout(array $request){
        try {
            return CoinBaseClient::Execute('POST','checkouts',$request);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public static function ShowCheckout(string $checkoutId){
        try {
            return CoinBaseClient::Execute('GET','checkouts/'.$checkoutId);
        } catch (Throwable $th) {
            throw $th;
        }
    }


    public static function UpdateCheckout(string $checkoutId,array $request){
        try {
            return CoinBaseClient::Execute('PUT',"checkouts/$checkoutId",$request);
        } catch (Throwable $th) {
            throw $th;
        }
    }


    public static function DeleteCheckout(string $checkoutId){
        try {
            return CoinBaseClient::Execute('DELETE',"checkouts/$checkoutId");
        } catch (Throwable $th) {
            throw $th;
        }
    }


}