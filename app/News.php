<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	use \Dimsav\Translatable\Translatable;

	protected $guarded = ['id'];

	protected $fillable = [
		'title',
		'description',
	];

	public $dates = ['date','init_at'];

	public $translatedAttributes = ['title', 'description'];

	public function createPublicCode() {
		do {
			$public_code = str_random(40);
		} while ($this->where('public_code', $public_code)->count() > 0);

		return $public_code;
	}

	public function setAll($request)
	{
		$this->date = $request->get('date');
		$this->link = $request->get('link');
		$this->published = $request->get('published') == true;
		if ( ! $this->public_code) {
			$this->public_code = $this->createPublicCode();
		}

		foreach(\Config::get('app.all_locales') as $locale){
			$this->translateOrNew($locale)->title = $request->get('title')[$locale];
			$this->translateOrNew($locale)->description = $request->get('description')[$locale];
		}

		$this->save();
	}

	public static function getByPublicCode($code) {
		$instance = new static;

		return $instance->where('public_code', $code)->firstOrFail();
	}
}