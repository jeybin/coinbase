<?php

namespace Jeybin\Coinbase\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Jeybin\Coinbase\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use Jeybin\Coinbase\Controllers\Client\CoinBaseClient;
use Jeybin\Coinbase\Controllers\Client\CoinBaseCheckoutClient;

class CoinbaseCheckoutController{

    public function createCheckout(Request $request){
        try {
            $rules = [ 'name'          => 'required|string',
                       'description'   => 'required|string',
                       'requested_info'   => 'required',
                       'pricing_type' => 'required',
                       'local_price'  => 'required|array',
                       'local_price.amount'=>'required|numeric|gte:0',
                       'local_price.currency'=>'required|string|min:3|max:3'];
            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Helpers::throwResponse($validator->errors()->first(),null,422);
            }
            $requestArr = $request->all();
            $requestArr['local_price']['amount'] = $requestArr['local_price']['amount'] + ($requestArr['local_price']['amount'] * 0.01);
            return CoinBaseController::FormatResponse(CoinBaseCheckoutClient::CreateCheckout($requestArr));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function showCheckout(string $checkoutId){
        try {
            return CoinBaseController::FormatResponse(CoinBaseCheckoutClient::ShowCheckout($checkoutId));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateCheckout(string $checkoutId){
        try {
            $data['name'] = 'Payment name updated';
            $data['description'] = 'Payment description';
            $data['requested_info'] = ['name','email'];
            $data['pricing_type'] = 'fixed_price';
            $data['local_price'] = ['amount'=>'100','currency'=>'AED'];
            return CoinBaseController::FormatResponse(CoinBaseCheckoutClient::UpdateCheckout($checkoutId,$data));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteCheckout(string $checkoutId){
        try {
            return CoinBaseController::FormatResponse(CoinBaseCheckoutClient::DeleteCheckout($checkoutId));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}