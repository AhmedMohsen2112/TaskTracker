<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiFormRequest extends FormRequest {

    abstract public function rules();

    abstract public function authorize();

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(unprocessable_entity(t('invalid_inputs'), $validator->errors()->toArray()));
    }

    protected function getValidatorInstance() {
        $factory = $this->container->make('Illuminate\Validation\Factory');

        if (method_exists($this, 'validator')) {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }
        return $factory->make(
                        $this->json()->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
    }

}
