<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoIndividualRequest extends FormRequest
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
            'fname' => 'required|regex:/[a-zA-Z0-9\s]+/',
            'lname' => 'required|regex:/[a-zA-Z0-9\s]+/',
            'dob' => 'date_format:d/m/Y|required',
            'passno'=>'required|digits_between:3,10|regex:/^[\w-]*$/',
            'passcountry'=>'required',
            'passexpdt'=>'date_format:d/m/Y|required',
            'passfile'=>'required',
            'addlone'=>'required',         
            'towncity'=>'required|alpha',
            'zip'=>'required',
            'state'=>'required|alpha',
            'country'=>'required',            
            'proofaddress'=>'required',
            'currency'=>'required',
            'uploadphoto'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'fname.required' => 'First Name Required',
            'fname.regex' => 'Only Alphauumeric and space allow',
            'lname.required' => 'Last Name Required',
            'lname.regex' => 'Only Alphauumeric and space allow',
            'dob.required' => 'Date of Birth Required',
            'dob.date' => 'Please enter a valid date(DD/MM/YYYY)',
            'passno.required'=>'Passport Number Required',
            'passno.regex'=>'Only Alpha numeric charecter allow. ',
            'passno.digits_between'=>'Charecter length should be in between 3 to 10',
            'passcountry.required'=>'Passport Country Required',            
            'passexpdt.required'=>'Passport Expiry Date Required',
            'passexpdt.date'=>'Please enter a valid date(DD/MM/YYYY)',            
            'passfile.required'=>'Passport File Required',            
            'passfile.mimes'=>'Only image type jpg/png/jpeg is allowed',
            'addlone.required'=>'Address Line 1 Required',            
            'towncity.required'=>'Town/ City Required',
            'towncity.alpha'=>'Only Alphabate allow',
            'zip.required'=>'Please provide a valid zipcode.',
            'state.required'=>'State Required',
            'state.alpha'=>'Only Alphabate allow',
            'country.required'=>'Country Required',
            'proofaddress.required'=>'Proof of address Required',
            'proofaddress.mimes'=>'Only image type jpg/png/jpeg is allowedg',
            'currency.required'=>'Currency Required',
            'uploadphoto.required'=>'Upload Photo Required',
//            'uploadphoto.mimes'=>'Only image type jpg/png/jpeg is allowed',            
        ];
    }
}
