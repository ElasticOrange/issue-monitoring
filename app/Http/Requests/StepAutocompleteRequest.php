<?php

namespace Issue\Http\Requests;

use Issue\Http\Requests\Request;

class StepAutocompleteRequest extends Request
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
            'name' => 'required|unique:step_autocompletes,name|string|min:3'
        ];
    }
}
