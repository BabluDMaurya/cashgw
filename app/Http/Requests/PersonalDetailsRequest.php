<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalDetailsRequest extends FormRequest
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
            'fname' => 'required|alpha',
            'mname' => 'alpha',
            'lname' => 'alpha',   
            'lang' => 'required',         
            'country' => 'required',            
        ];
    }
    public function messages()
    {
        return [
            'fname.required' => 'First Name Required',
            'fname.alpha' => 'Only Alphabates allow',
            'mname.alpha' => 'Only Alphabates allow',
            'lname.required' => 'Last Name Required',
            'lname.alpha' => 'Only Alphabates allow',
            'country.required'=>'Country Required',    
            'lang.required'=>'language Required',    
        ];
    }
}
