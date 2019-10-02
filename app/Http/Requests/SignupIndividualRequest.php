<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupIndividualRequest extends FormRequest
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
            'email'=>'required|email|string|emailformate|unique:users,email',
            'password'=>'required|string|min:8',
            'reenterpassword'=>'same:password',
            'agree'=>'required'
        ];
    }
    public function messages()
    {
        return [            
            'email.email' => 'Please enter a valid email address',
            'email.required' => 'Email is required',
            'email.unique'=>'Email id not available',
            'password.required'=>'Password is required',
            'password.min'=>'minimum 8 charecter is required',
            'reenterpassword.same'=>'Password should be same as above',
            'agree.required'=>'Agree terms and conditions'
        ];
    }
}
