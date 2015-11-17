<?php

namespace Issue\Http\Requests;

use Issue\Http\Requests\Request;

class IssueRequest extends Request
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
			'name.ro' => 'required|string|max:1000',
			'name.en' => 'string|max:1000',
			'description' => 'array',
			'description.ro' => 'string|max:1000',
			'description.en' => 'string|max:1000',
			'impact' => 'array',
			'impact.ro' => 'string',
			'impact.en' => 'string',
			'status' => 'array',
			'status.ro' => 'string',
			'status.en' => 'string'
		];
	}
}
