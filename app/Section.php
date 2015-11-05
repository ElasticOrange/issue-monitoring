<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	use \Dimsav\Translatable\Translatable;

	protected $fillable = [
		'title',
		'description'
	];

	public $translatedAttributes = ['title', 'description'];

	public function stakeholder()
	{
		return $this->belongsTo('Issue\Stakeholder');
	}

	public function setSection($section_data)
	{
		foreach (\Config::get('app.all_locales') as $locale)
		{
			$this->translateOrNew($locale)->title = $section_data['title'][$locale];
			$this->translateOrNew($locale)->description = $section_data['description'][$locale];
		}
		return true;
	}
}
