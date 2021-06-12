<?php

namespace Mawuekom\ApiFormRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Mawuekom\FormRequest\Http\FormRequest;

/**
 * Abstract Class ApiFormRequest
 * 
 * @package Mawuekom\ApiFormRequest
 */
abstract class ApiFormRequest extends FormRequest
{
    /**
     * ValidateResolved
     *
     * @return void
     */
    public function validateResolved()
    {
        parent::validateResolved();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $laravel = app();
        $version = $laravel::VERSION;

        if (substr($version, 0, 3) == '5.4') {
            $errors = $validator->messages()->messages();
        } 
        
        else {
            $errors = (new ValidationException($validator))->errors();
        }
        
        $transformed = [];

        foreach ($errors as $field => $message) {
            $transformed[] = [
                'field' => $field,
                'message' => $message[0]
            ];
        }

        if ($this->statusCode == 400) {
            $statusResponse = JsonResponse::HTTP_BAD_REQUEST;
        } 
        
        else {
            $statusResponse = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        }

        throw new HttpResponseException(response()->json([
            'status' => 'failed', 
            'errors' => $transformed
        ], $statusResponse));
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\UnauthorizedException
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json(['status' => 'failed', 'errors' => 'Unauthorized'], 401));
    }
}
