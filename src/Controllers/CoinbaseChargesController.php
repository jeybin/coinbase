<?php

namespace Jeybin\Coinbase\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Jeybin\Coinbase\Requests\PaymentLinkValidator;
use Jeybin\Coinbase\Controllers\Client\CoinBaseClient;
use Jeybin\Coinbase\Controllers\Client\CoinBaseChargeClient;

class CoinbaseChargesController{
    
    /**
     * To get paid in cryptocurrency, you need to create a charge object and 
     * provide the user with a cryptocurrency address to which they must send cryptocurrency. 
     * Once a charge is created a customer must broadcast a payment to 
     * the blockchain before the charge expires.
     */
    public function paymentLink(PaymentLinkValidator $request){
        try {
            /**
             * Validated request array
             */
            $requestArr  = $request->validated();

            $pricing_type = (empty($requestArr['pricing_type']) || !in_array($requestArr['pricing_type'],['fixed_price','no_price'])) ? 'fixed_price' : $requestArr['pricing_type'];

            if($pricing_type == 'fixed_price'){
                /**
                 * In the no_price price-type no need to mention the amount
                 * for the fixed price we need to pass the amount
                 */
                if(empty($requestArr['currency'])){
                    return CoinBaseController::validationMessage(422,'Currency is required');
                }
                if(empty($requestArr['amount'])){
                    return CoinBaseController::validationMessage(422,'Amount is required');
                }else {
                    if($requestArr['amount'] <= 0){
                        return CoinBaseController::validationMessage(422,'Amount must be greater than 0');
                    }
                }

                /**
                 * 1% fees applicable for all transactions with coinbase
                 * Adding that 1% to the amount;
                 */
               $requestArr['amount'] = $requestArr['amount'] + ($requestArr['amount'] * 0.01);

                $chargerequestArr['local_price']  = ['amount'   => $requestArr['amount'],
                                                  'currency' => $requestArr['currency']]; 
            }
            

            
            $chargerequestArr['name']         = $requestArr['name']; 
            $chargerequestArr['description']  = $requestArr['description']; 
            $chargerequestArr['pricing_type'] = $pricing_type; 
            $chargerequestArr['metadata']['customer_id'] = $requestArr['customer_id'];
            $chargerequestArr['metadata']['customer_name'] = $requestArr['customer_name'];
            $chargerequestArr['redirect_url'] = $requestArr['redirect_url'];
            $chargerequestArr['cancel_url'] = $requestArr['cancel_url'];

            return CoinBaseController::FormatResponse(CoinBaseChargeClient::CreateCharge($chargeRequest));

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




    public static function CHARGES_LIST(){
        try {
            return CoinBaseController::FormatResponse(CoinBaseChargeClient::ChargesList());
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function GENERATE_PAYMENT_LINK(array $request){
        try {

        } catch (Throwable $th) {
            throw $th;
        }
    }


}