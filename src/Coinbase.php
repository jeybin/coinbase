<?php

namespace Jeybin\Coinbase;

use Jeybin\Coinbase\Controllers\CoinbaseCheckoutController;
use Jeybin\Coinbase\Controllers\CoinbaseChargesController;
use Illuminate\Http\Request;

class Coinbase {


    /**
     * Create charge
     *
     * @param Request $request
     * @return void
     */
    public function CreateCharge(Request $request){
        try {
            return CoinbaseChargesController::createCharge($request);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get details of an existing charge
     *
     * @param [string] $chargeId
     * @return void
     */
    public function Charges(string $chargeId=''){
        try {
            return (!empty($chargeId)) ? CoinbaseChargesController::chargeDetails($chargeId)
                                       : CoinbaseChargesController::chargeList();
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Get details of an existing charge
     *
     * @param [string] $chargeId
     * @return void
     */
    public function cancelCharge(string $chargeId){
        try {
            $checkStatus = self::chargeStatus($chargeId);
            if(empty($checkStatus['code']) || empty($checkStatus['data'])){
                return ['code'=>422,'message'=>'Invalid charge id'];
            }
            if($checkStatus['code'] !== 200){
                return $checkStatus;
            }
            if($status !== 'NEW'){
                return ['code'=>405,'message'=>'Cannot cancel the charge, the current status of charge is '.$status,'error'=>true];
            }
            
            return CoinbaseChargesController::cancelCharge($chargeId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private function chargeStatus($chargeId){
        try {
            $chargeDetails = self::Charges($chargeId);
            if(empty($chargeDetails['code'])){
                return ['code'=>500,'message'=>'unknown error','error'=>true];
            }

            if($chargeDetails['code'] !== 200){
                return $chargeDetails;
            }

            if(empty($chargeDetails['data']['timeline'])){
                return ['code'=>422,'message'=>'invalid charge id','error'=>true];
            }

            return ['code'=>200,'data'=>end($chargeDetails['data']['timeline'])['status'],'message'=>'status'];
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function createCheckout(Request $request){
        try {
            return CoinbaseCheckoutController::createCheckout($request);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function showCheckout(string $checkoutId){
        try {
            return CoinbaseCheckoutController::showCheckout($checkoutId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateCheckout(string $checkoutId){
        try {
            return CoinbaseCheckoutController::updateCheckout($checkoutId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function deleteCheckout(string $checkoutId){
        try {
            return CoinbaseCheckoutController::deleteCheckout($checkoutId);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}