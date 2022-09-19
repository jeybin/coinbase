<?php

namespace Jeybin\Coinbase\Controllers;

use Throwable;
use Illuminate\Http\Request;
// use Jeybin\Coinbase\Requests\PaymentLinkValidator;
use Jeybin\Coinbase\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use Jeybin\Coinbase\Controllers\Client\CoinBaseClient;
use Jeybin\Coinbase\Controllers\Client\CoinBaseChargeClient;

class CoinbaseChargesController{
    
    /**
     * To get paid in cryptocurrency, you need to create a charge object and 
     * provide the user with a cryptocurrency address to which they must send cryptocurrency. 
     * Once a charge is created a customer must broadcast a payment to 
     * the blockchain before the charge expires.
     */
    public function createCharge(Request $request){
        try {
            $rules = [ 'name'          => 'required|string',
                       'description'   => 'required|string',
                       'customer_id'   => 'required',
                       'customer_name' => 'required',
                       'redirect_url'  => 'required|string',
                       'cancel_url'    => 'required|string',
                       'pricing_type'  => 'required|string|in:fixed_price,no_price',
                       'currency'      => 'required_if:pricing_type,fixed_price|min:3|max:3',
                       'amount'        => 'required_if:pricing_type,fixed_price|numeric|gte:0'];
            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Helpers::throwResponse($validator->errors()->first(),null,422);
            }

            /**
             * Validated request array
             */
            $requestArr  = $validator->validated();
            $pricing_type = (empty($requestArr['pricing_type']) || !in_array($requestArr['pricing_type'],['fixed_price','no_price'])) ? 'fixed_price' : $requestArr['pricing_type'];

            if($pricing_type == 'fixed_price'){
                /**
                 * 1% fees applicable for all transactions with coinbase
                 * Adding that 1% to the amount;
                 */
               $requestArr['amount'] = $requestArr['amount'] + ($requestArr['amount'] * 0.01);

                $chargerequestArr['local_price']  = ['amount'   => $requestArr['amount'],
                                                  'currency' => $requestArr['currency']]; 
            }
            

            
            $chargerequestArr['name']                       = $requestArr['name']; 
            $chargerequestArr['description']                = $requestArr['description']; 
            $chargerequestArr['pricing_type']               = $pricing_type; 
            $chargerequestArr['metadata']['customer_id']    = $requestArr['customer_id'];
            $chargerequestArr['metadata']['customer_name']  = $requestArr['customer_name'];
            $chargerequestArr['redirect_url']               = $requestArr['redirect_url'];
            $chargerequestArr['cancel_url']                 = $requestArr['cancel_url'];

            return CoinBaseController::FormatResponse(CoinBaseChargeClient::CreateCharge($chargerequestArr));

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Retrieves the details of a charge that has been previously created. 
     * Supply the unique charge code that was returned when the charge was created. 
     * This information is also returned when a charge is first created.
     */
     public function chargeDetails(string $chargeId){
        try {
            return CoinBaseController::FormatResponse(CoinBaseChargeClient::ChargeById($chargeId));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Cancels a charge that has been previously created. 
     * Supply the unique charge code that was returned when the charge was created.
     * Note: Only new charges can be successfully canceled. 
     * Once payment is detected, charge can no longer be canceled.
     */
    public function cancelCharge(string $chargeId){
        try {
            return CoinBaseController::FormatResponse(CoinBaseChargeClient::CancelCharge($chargeId));
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    public static function chargeList(){
        try {
            return CoinBaseController::FormatResponse(CoinBaseChargeClient::ChargesList());
        } catch (Throwable $th) {
            throw $th;
        }
    }


}