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
			'title.en' => 'required|string|max:1000',
			'description' => 'array',
			'description.ro' => 'string|max:1000',
			'description.en' => 'string|max:1000',
			'date_init' => 'date',
			'link' => 'url',
			'published' => 'boolean'
		];
	}
}
