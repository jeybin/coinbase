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
class InvoiceClient extends CoinBaseClient{

    private static $API_PATH = 'invoices';

    private static function API($path=''){
        return (!empty($path)) ? self::$API_PATH.'/'.$path : self::$API_PATH;
    }

    public static function ListInvoices(){
        try {
            return CoinBaseClient::Execute('GET',self::API());
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public static function InvoiceById($invoiceId){
        try {
            return CoinBaseClient::Execute('GET',self::API($invoiceId));
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public static function CreateInvoice(array $request){
        try {
            return CoinBaseClient::Execute('POST',self::API(),$request);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public static function VoidInvoice(string $invoiceId){
        try {
            return CoinBaseClient::Execute('PUT',self::API("$invoiceId/void"));
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public static function ResolveInvoice(string $invoiceId){
        try {
            return CoinBaseClient::Execute('PUT',self::API("$invoiceId/resolve"));
        } catch (Throwable $th) {
            throw $th;
        }
    }


    

   

}