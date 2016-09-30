<?php

namespace Issue\Http\Requests;

use Issue\Http\Requests\Request;

class NewsRequest extends Request
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
            'title' => 'array',
            'title.ro' => 'required|string|max:1000',
            'title.en' => 'string|max:1000',
            'description' => 'array',
            'description.ro' => 'string',
            'description.en' => 'string',
            'date_init' => 'date',
            'link' => 'url',
            'published' => 'boolean'
        ];
    }
}
