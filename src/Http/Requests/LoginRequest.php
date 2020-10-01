<?php

namespace OutamaOthmane\AuthApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OutamaOthmane\AuthApi\Facades\AuthApi;

class LoginRequest extends FormRequest
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
        	AuthApi::username()	=> [
        		'required',
        		'string',
        	],
        	'password'	=> [
        		'required',
        		'string',
        	],
        ];
    }
}