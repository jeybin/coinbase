<?php

namespace Jeybin\Coinbase\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Jeybin\Coinbase\Helpers\Helpers;
use Jeybin\Coinbase\Controllers\CoinBaseController;
use Jeybin\Coinbase\Controllers\Client\EventsClient;
use Jeybin\Coinbase\Controllers\Client\InvoiceClient;

class CoinbaseInvoiceController{

    public function CreateInvoice(Request $request){
        try {
            return CoinBaseController::FormatResponse(InvoiceClient::CreateInvoice($request->all()));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function invoices($invoiceId = ''){
        try {
            $response = (!empty($invoiceId)) ? InvoiceClient::ListInvoices() 
                                             : InvoiceClient::InvoiceById($invoiceId);

            return CoinBaseController::FormatResponse($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function changeInvoiceStatus(string $invoiceId,string $type){
        try {
            if($type !== 'void' && $type !== 'resolve'){
                return Helpers::throwResponse('Invalid status type',null,422);
            }

            $response = ($type == 'void') ? InvoiceClient::VoidInvoice($invoiceId)
                                          : InvoiceClient::ResolveInvoice($invoiceId);
            return CoinBaseController::FormatResponse($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



}