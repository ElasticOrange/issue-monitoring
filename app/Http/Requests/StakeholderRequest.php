<?php

namespace Issue\Http\Requests;

use Issue\Http\Requests\Request;

class StakeholderRequest extends Request
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
			'name' => 'required',
			'type' => 'string',
			'site' => 'link',
			'public_code' => 'link',
			'published' => 'boolean'
		];
	}
}
