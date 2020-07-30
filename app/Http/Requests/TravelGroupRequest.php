<?php

namespace App\Http\Requests;

use AndreasPabst\RequestValidation\RequestAbstract;

class TravelGroupRequest extends RequestAbstract
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
            'planning_from' => 'required|after:yesterday',
            'planning_to' => 'required|after:yesterday',
            'travel_time_from' => 'required|after:yesterday',
            'travel_time_to' => 'required|after:yesterday',
            'max_member' => 'required',
            'title' => 'required',
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
            'planning_from.required' => 'REQUIRED',
            'planning_from.after' => 'YESTERDAY',
            'planning_to.required' => 'REQUIRED',
            'planning_to.after' => 'YESTERDAY',
            'travel_time_from.required' => 'REQUIRED',
            'travel_time_from.after' => 'YESTERDAY',
            'travel_time_to.required' => 'REQUIRED',
            'travel_time_to.after' => 'YESTERDAY',
            'max_member.required' => 'REQUIRED',
            'title.required' => 'REQUIRED',
        ];
    }
}
