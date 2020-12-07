<?php

namespace Iamxcd\LaravelCRUD\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HasOverrideFailedValidation
{

    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->first();
        throw new HttpResponseException(response()->json(['message' => $error, 'code' => 1], 422));
    }
}