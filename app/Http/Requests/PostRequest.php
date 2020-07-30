<?php

namespace App\Http\Requests;

use AndreasPabst\RequestValidation\RequestAbstract;

class PostRequest extends RequestAbstract
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
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'content.required' => 'required',
            'image.image' => 'image',
            'image.mimes' => 'jpeg,png,jpg,gif',
            'image.max' => '1024 KB'
        ];
    }
}
