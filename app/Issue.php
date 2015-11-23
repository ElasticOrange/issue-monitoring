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
		'impact',
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
		$this->published = $request->get('published') == true;
		$this->archived = $request->get('archived') == true;

		if (! $this->public_code) {
			$this->public_code = $this->createPublicCode();
		}

		foreach (\Config::get('app.all_locales') as $locale) {
			$this->translateOrNew($locale)->name = $request->get('name')[$locale];
			$this->translateOrNew($locale)->description = $request->get('description')[$locale];
			$this->translateOrNew($locale)->impact = $request->get('impact')[$locale];
			$this->translateOrNew($locale)->status = $request->get('status')[$locale];
		}

		$this->save();

		if (!$request->get('domains_connected')) {
			$domains_connected = [];
		} else {
			$domains_connected = $request->get('domains_connected');
		}

		$this->connectedDomains()->sync($domains_connected);

		if (!$request->get('stakeholders_connected')) {
			$stakeholders_connected = [];
		} else {
			$stakeholders_connected = $request->get('stakeholders_connected');
		}

		$this->connectedStakeholders()->sync($stakeholders_connected);

		if (!$request->get('news_connected')) {
			$news_connected = [];
		} else {
			$news_connected = $request->get('news_connected');
		}

		$this->connectedNews()->sync($news_connected);

		if (!$request->get('issues_connected')) {
			$issues_connected = [];
		} else {
			$issues_connected = $request->get('issues_connected');
		}

		foreach ($this->issuesConnectedOfThem as $icof) {
			$this->issuesConnectedOfThem()->detach($icof->id);
		}

		$this->issuesConnectedOfMine()->sync($issues_connected);

		if (!$request->get('initiators_connected')) {
			$initiators_connected = [];
		} else {
			$initiators_connected = $request->get('initiators_connected');
		}

		$this->connectedInitiatorsStakeholders()->sync($initiators_connected);
	}


	public function syncLocations($locations)
	{
		// dd($locations);
		$currentLocations = $this->locationSteps()->get();
		if (! is_array($locations)) {
			$locations = [];
		}

		$index = 0;
		foreach ($locations as $id => $location) {
			$index++;
			$locations[$id]['step_order'] = $index;
		}

		foreach ($currentLocations as $currentLocation) {
			if (! array_key_exists($currentLocation->id, $locations)) {
				$currentLocation->delete();
				continue;
			}
			$currentLocation->fill($locations[$currentLocation->id]);
			$currentLocation->save();
			unset($locations[$currentLocation->id]);
		}

		foreach ($locations as $locationData) {
			$newLocation = new LocationStep;
			$newLocation->fill($locationData);
			$this->locationSteps()->save($newLocation);
		}

		return true;
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

	public function issuesConnectedOfMine()
	{
		return $this->belongsToMany(
			'Issue\Issue',
			'issues_connected',
			'issue_id',
			'issue_connected_id'
		);
	}

	public function issuesConnectedOfThem()
	{
		return $this->belongsToMany(
			'Issue\Issue',
			'issues_connected',
			'issue_connected_id',
			'issue_id'
		);
	}

	public function getIssuesConnectedAttribute()
	{
		if (! array_key_exists('issues_connected', $this->relations)) {
			$this->loadIssuesConnected();
		}

		return $this->getRelation('issues_connected');
	}

	protected function loadIssuesConnected()
	{
		if (! array_key_exists('issues_connected', $this->relations)) {
			$issues_connected = $this->mergeIssuesConnected();

			$this->setRelation('issues_connected', $issues_connected);
		}
	}

	protected function mergeIssuesConnected()
	{
		return $this->issuesConnectedOfMine->merge($this->issuesConnectedOfThem);
	}

	public function connectedInitiatorsStakeholders()
	{
		return $this->belongsToMany(
		'Issue\Stakeholder',
		'initiator_issue',
		'issue_id',
		'initiator_id'
		);
	}

	public function locationSteps()
	{
		return $this->hasMany('Issue\LocationStep');
	}
}
