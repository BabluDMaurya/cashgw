<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|string|emailformate',
            'subject' => 'required',
            'comment' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'Name is required',
            'email.email' => 'Please enter a valid email address',
            'email.required' => 'Email address is required',
            'subject.required' => 'Subject is required',
            'comment.required' => 'Message is required',
        ];
    }
}
