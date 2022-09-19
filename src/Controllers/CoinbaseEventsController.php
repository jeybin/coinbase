<?php

namespace Jeybin\Coinbase\Controllers;

use Throwable;
use Jeybin\Coinbase\Controllers\CoinBaseController;
use Jeybin\Coinbase\Controllers\Client\EventsClient;

class CoinbaseEventsController{


    public function listEvents(){
        try {
            return CoinBaseController::FormatResponse(EventsClient::ListEvents());
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function eventById($eventId){
        try {
            return CoinBaseController::FormatResponse(EventsClient::eventById($eventId));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}