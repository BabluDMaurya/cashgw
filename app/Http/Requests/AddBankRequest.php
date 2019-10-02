<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBankRequest extends FormRequest
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
            'bank' => 'required',
            'branch' => 'required',
            'bankcode' => 'required',
            'ifsccode' => 'required',
            'currency' => 'required|alpha|string',
            'acno' => 'required|digits_between:11,12',
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'bankaddress'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'bank.required' => 'Bank Name Required',
            'branch.required' => 'Branch Name Required',
            'bankcode.required' => 'Bank Code Required',
            'ifsccode.required' => 'BANK IFSC Code Required',
            'currency.required' => 'Currency Required.',
            'currency.alpha'=> 'Only Alphabate allowed.(Like: USD, EUR, etc)',
            'currency.string' => 'Currency Should Be String',
            'acno.required' => 'Account No. Required',
            'acno.digits_between'=> 'Account No. should be between 11 to 12 digits.',
            'name.required' => 'Account Holder Name Required',
            'name.regex'=>'Alpha and space allow',
            'bankaddress.required'=>'Bank Address Required',
        ];
    }
}
