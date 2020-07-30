<?php

namespace App\Http\Requests;

use AndreasPabst\RequestValidation\RequestAbstract;

class UserRequest extends RequestAbstract
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
            'username' => 'required|min:4|max:32',
            'first_name' => 'string|min:4|max:32',
            'last_name' => 'string|min:4|max:32',
            'gender' => 'string',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'phone_number' => 'regex:/^([+0][389][0-9\s\-\+\(\)\(.)\/]*)$/|max:11',

        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'username.min' => 'min_4',
            'username.max' => 'max_32',
            'username.required' => 'required',
            'first_name.min' =>  'min_4',
            'first_name.max' => 'max_32',
            'last_name.min' =>  'min_4',
            'last_name.max' => 'max_32',
            'gender.string' => 'string',
            'avatar.image' => 'format_invalid',
            'avatar.mimes' => 'extension_invalid',
            'avatar.max' => 'size_invalid',
            'phone_number.regex' => 'regex',
            'phone_number.max' => 'max_11',

        ];

        foreach ($messages as $key => $val) {
            $key = "$val";
        }
        return $messages;

    }
}
