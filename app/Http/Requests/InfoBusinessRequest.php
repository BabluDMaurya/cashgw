<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
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
            'bname' => 'required|regex:/[a-zA-Z0-9 \s]+/',
            'btype'=> 'required|regex:/[a-zA-Z0-9 \s]+/',
            'memorandum' => 'required',
            'memorandum' => 'required',
            'bcirtificate' => 'required',
//            'csrf_token' => 'required',
            'fname' => 'required|regex:/[a-zA-Z0-9 \s]+/',
//            'mname' => 'alpha',
            'lname' => 'required|regex:/[a-zA-Z0-9 \s]+/',
            'dob' => 'date_format:d/m/Y|required',
            'passno'=>'required|digits_between:3,10|regex:/^[\w-]*$/',
            'passcountry'=>'required',
            'passexpdt'=>'date_format:d/m/Y|required',
            'passfile'=>'required',
            'addlone'=>'required',
//            
            'towncity'=>'required|regex:/[a-zA-Z0-9 \s]+/',
            'zip'=>'required',
            'state'=>'required|regex:/[a-zA-Z0-9 \s]+/',
            'country'=>'regex:/[a-zA-Z0-9 \s]+/',
            'proofaddress'=>'required',
            'uploadphoto'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'bname.required' => 'Business Name Required',
            'bname.regex' => 'Only Alphauumeric and space allow',
            
            'btype.required' => 'Buisness Type Required',
            'btype.regex' => 'Only Alphauumeric and space allow',
            
            'memorandum.required' => 'Memorandum Required',
            'memorandum.mimes'=>'Only image type pdf is allowed',
            
            'bcirtificate.required'=>'Business Cirtificate Required',            
            'bcirtificate.mimes'=>'Only image type jpg/png/jpeg/pdf/xls is allowed',
            
            
//            'csrf_token.required' => 'Form token required',
            'fname.required' => 'First Name Required',
            'fname.regex' => 'Only Alphauumeric and space allow',
//            'mname.alpha' => 'Only Alphabate allow',
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
            'towncity.regex' => 'Only Alphauumeric and space allow',
            'zip.required'=>'Please provide a valid zipcode.',
            'state.required'=>'State Required',
            'state.regex' => 'Only Alphauumeric and space allow',
            'country.regex' => 'Only Alphauumeric and space allow',
            'proofaddress.required'=>'Proof of address Required',
            'proofaddress.mimes'=>'Only image type jpg/png/jpeg is allowedg',
            'uploadphoto.required'=>'Upload Photo Required',
//            'uploadphoto.mimes'=>'Only image type jpg/png/jpeg is allowed',            
        ];
    }
}
