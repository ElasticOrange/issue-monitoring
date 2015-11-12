<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
	use \Dimsav\Translatable\Translatable;

	protected $guarded = ['id'];

	protected $fillable = [
		'name',
		'description',
		'imapct',
		'status'
	];

	public $translatedAttributes = ['name', 'description', 'impact', 'status'];

	public function createPublicCode()
	{
		do {
			$public_code = str_random(40);
		} while ($this->where('public_code', $public_code)->count() > 0);

		return $public_code;
	}

	public function setAll($request)
	{
		if (! $this->public_code) {
			$this->public_code = $this->createPublicCode();
		}

		foreach (\Config::get('app.all_locales') as $locale) {
			$this->translateOrNew($locale)->name = $request->get('name')[$locale];
			$this->translateOrNew($locale)->description = $request->get('description')[$locale];
			$this->translateOrNew($locale)->impact = $request->get('impact')[$locale];
			$this->translateOrNew($locale)->status = $request->get('status')[$locale];
		}

		if (!$request->get('domains_connected')) {
			$domains_connected = [];
		} else {
			$domains_connected = $request->get('domains_connected');
		}

		if (!$request->get('stakeholders_connected')) {
			$stakeholders_connected = [];
		} else {
			$stakeholders_connected = $request->get('stakeholders_connected');
		}

		if (!$request->get('news_connected')) {
			$news_connected = [];
		} else {
			$news_connected = $request->get('news_connected');
		}

		$this->save();

		$this->connectedDomains()->sync($domains_connected);
		$this->connectedStakeholders()->sync($stakeholders_connected);
		$this->connectedNews()->sync($news_connected);
	}

	public static function getByPublicCode($code)
	{
		$instance = new static;

		return $instance->where('public_code', $code)->firstOrFail();
	}

	public function connectedDomains()
	{
		return $this->belongsToMany('Issue\Domain');
	}

	public function connectedStakeholders()
	{
		return $this->belongsToMany('Issue\Stakeholder');
	}

	public function connectedNews()
	{
		return $this->belongsToMany('Issue\News');
	}
}
