<?php

namespace Issue\Http\Requests;

use Issue\Http\Requests\Request;

class LocationRequest extends Request
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
            'name' => 'array',
            'name.ro' => 'required|string|unique:location_translations,name',
            'name.en' => 'required|string|unique:location_translations,name',
            'parent_id' => 'required|integer'
        ];
    }
}
