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
			'name' => 'required|string',
			'type' => 'in:persoana,organizatie',
			'contact[ro]' => 'required|string',
			'contact[en]' => 'required|string',
			'profile[ro]' => 'required|string',
			'profile[en]' => 'required|string',
			'position[ro]' => 'required|string',
			'position[en]' => 'required|string',
			'site' => 'required|link',
			'public_code' => 'required|link',
			'published' => 'boolean'
		];
	}
}
