<?php

namespace OutamaOthmane\AuthApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        	'email'	=> [
        		'required',
        		'string',
                'email',
                'unique:users,email',
                'max:200',
        	],
            'name'      => [
                'required',
                'string',
                'min:3',
                'max:200',
            ],
        	'password'	=> [
        		'required',
        		'string',
                'min:8',
                'different:email',
        	],
        ];
    }
}