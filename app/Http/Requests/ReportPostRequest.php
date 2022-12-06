<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sql' => 'required|string'
        ];
    }

    public function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Input validation errors',
            'data' => $validator->errors()
        ]));
    }

    public function reportInputDTO(): array
    {
        return $this->all();
    }
}
