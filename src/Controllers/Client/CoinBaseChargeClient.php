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
class CoinBaseChargeClient extends CoinBaseClient{
    

    /**
     * Create a charge for the payment
     *
     * @param array $request
     * @return void
     */
    public static function CreateCharge(array $request){
        try {
            return CoinBaseClient::Execute('POST','charges',$request);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Listing all created charges
     *
     */
    public static function ChargesList(){
        try {
            return CoinBaseClient::Execute('GET','charges');
        } catch (Throwable $th) {
            throw $th;
        }
    }
    

    /**
     * Show charge
     *
     */
    public static function ChargeById($chargeId){
        try {
            return CoinBaseClient::Execute("GET","charges/$chargeId");
        } catch (Throwable $th) {
            throw $th;
        }
    }
    
    /**
     * Show charge
     *
     */
    public static function CancelCharge($chargeId){
        try {
            return CoinBaseClient::Execute("POST","charges/$chargeId/cancel");
        } catch (Throwable $th) {
            throw $th;
        }
    }
    
   
}