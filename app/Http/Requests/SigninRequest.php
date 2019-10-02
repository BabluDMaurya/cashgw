<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
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
            'email'=>'required|email|string|emailformate',
            'password'=>'required|string|min:8',            
        ];
    }
    public function messages()
    {
        return [            
            'email.email' => 'Please enter a valid email address',
            'email.required' => 'Email is required',            
            'password.required'=>'Password is required',
            'password.min'=>'minimum 8 charecter is required',            
        ];
    }
}
