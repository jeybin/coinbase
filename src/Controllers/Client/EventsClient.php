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
class EventsClient extends CoinBaseClient{


    private static $API_PATH = 'events';

    private static function API($path=''){
        return (!empty($path)) ? self::$API_PATH.'/'.$path : self::$API_PATH;
    }

    public static function ListEvents(){
        try {
            return CoinBaseClient::Execute('GET',self::API());
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public static function eventById($eventId){
        try {
            return CoinBaseClient::Execute('GET',self::API($eventId));
        } catch (Throwable $th) {
            throw $th;
        }
    }
   

}