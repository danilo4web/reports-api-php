<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportExportPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'dateStart' => 'date_format:Y-m-d|before_or_equal:today',
            'dateEnd' => 'date_format:Y-m-d|after_or_equal:dateStart',
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
}
