<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phonenumber' => 'required|max:11',
//            'emailaddress' => 'required|emailformate',
        ];
    }
    public function messages()
    {
        return [
            'phonenumber.required' => 'Phone Number Required',
            'phonenumber.max' => 'Phone Number Should be 11 digits',            
//            'emailaddress.required' => 'Eamil Address Required',
        ];
    }
}
