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
			'name.ro' => 'required|string',
			'name.en' => 'required|string',
			'description' => 'array',
			'description.ro' => 'string',
			'description.en' => 'string',
			'impact' => 'array',
			'impact.ro' => 'string',
			'impact.en' => 'string',
			'status' => 'array',
			'status.ro' => 'string',
			'status.en' => 'string'
		];
	}
}
