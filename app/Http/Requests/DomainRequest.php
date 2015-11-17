<?php

namespace Issue\Http\Requests;

use Issue\Http\Requests\Request;

class DomainRequest extends Request
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
			'name.ro' => ['regex:/^[a-z0-9 -]*$/i','required','string','unique:domain_translations,name,'.$this->id.',domain_id'],
			'name.en' => ['regex:/^[a-z0-9 -]*$/i','string','unique:domain_translations,name,'.$this->id.',domain_id'],
			'parent_id' => 'required|integer'
		];
	}
}
