<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class DonationRequestsRequest extends ApiFormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        //dd($this->request->all());
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return array();
                }
            case 'POST': {
                    //dd($this->id);
                    $rules = array(
                        'category' => 'required',
                        'bank' => 'required',
                        'currency' => 'required',
                        'amount' => 'required',
                    );
                    return $rules;
                }
            case 'PUT': {
                    return array(
                    );
                }

            case 'PATCH': {
                    //dd($this->id);
                    return array(
                    );
                }
        }
    }

}
