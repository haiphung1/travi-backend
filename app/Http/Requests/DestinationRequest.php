<?php

namespace App\Http\Requests;

use AndreasPabst\RequestValidation\RequestAbstract;

class DestinationRequest extends RequestAbstract
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
            'title' => 'required',
            'expected_time' => 'required|after:yesterday',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
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
            'title.required' => 'REQUIRED',
            'expected_time.after' => 'YESTERDAY',
            'expected_time.required' => 'REQUIRED',
            'planning_to.after' => 'YESTERDAY',
            'address.required' => 'REQUIRED',
            'lat.required' => 'REQUIRED',
            'long.required' => 'REQUIRED',
        ];
    }
}
