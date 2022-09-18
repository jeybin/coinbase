<?php

namespace Jeybin\Coinbase\Requests;

use Jeybin\Coinbase\Helpers\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class PaymentLinkValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'             => 'required|string',
            'description' => 'required|string',
            'customer_id' => 'required',
            'customer_name' => 'required',
            'redirect_url' => 'required|string',
            'cancel_url' => 'required|string',
        ];
    }

    public function withValidator($validator){
        if($validator->fails()){
            Helpers::throwResponse($validator->errors()->first(),null,422);
        }
    }
}
