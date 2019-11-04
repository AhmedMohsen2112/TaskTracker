<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiFormRequest extends FormRequest {

    
    abstract public function rules();

    abstract public function authorize();

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(unprocessable_entity(t('invalid_inputs'), $validator->errors()->toArray()));
    }

}
