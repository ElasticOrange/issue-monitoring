<?php

namespace Issue\Http\Requests;

use Issue\Http\Requests\Request;

class DocumentRequest extends Request
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
            'description' => 'array',
            'description.ro' => 'required|string',
            'description.en' => 'required|string',
            'init_at' => 'date',
            'file' => 'required|max:10000'
        ];
    }
}
