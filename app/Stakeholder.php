<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;
use Issue\Stakeholder;

const CV_LOCATION = '/cv/';
const POZA_LOCATION = '/poza/';

class Stakeholder extends Model
{
	use \Dimsav\Translatable\Translatable;

	protected $fillable = [
		'name',
		'type',
		'site'
	];

	public $translatedAttributes = ['contact','profile','position'];

	protected $guarded = ['id'];

	public function createPublicCode()
	{
		do {
			$public_code = str_random(40);
		} while ($this->where('public_code', $public_code)->count() > 0);

		return $public_code;
	}

	public function setAll($request)
	{
		$this->name = $request->get('name');
		$this->type = $request->get('type');
		$this->site = $request->get('site');
		$this->email = $request->get('email');
		$this->telephone = $request->get('telephone');
		$this->published = $request->get('published') == true;

		if (! $this->public_code) {
			$this->public_code = $this->createPublicCode();
		}

		if ($request->file('cv_file')) {
			if ($this->fileCv) {
				$this->fileCv()->delete();
			}

			$cvFile = new UploadedFile;
			$cvFile->storeFile(CV_LOCATION, $request->file('cv_file'));
			$this->fileCv()->associate($cvFile);
		}

		if ($request->file('poza_file')) {
			if ($this->filePoza) {
				$this->filePoza()->delete();
			}

			$pozaFile = new UploadedFile;
			$pozaFile->storeFile(POZA_LOCATION, $request->file('poza_file'));
			$this->filePoza()->associate($pozaFile);
		}

		foreach (\Config::get('app.all_locales') as $locale) {
			$this->translateOrNew($locale)->address = $request->get('address')[$locale];
			$this->translateOrNew($locale)->other_details = $request->get('other_details')[$locale];
			$this->translateOrNew($locale)->profile = $request->get('profile')[$locale];
			$this->translateOrNew($locale)->position = $request->get('position')[$locale];
		}

		$this->save();

		// Refresh connected stakeholders
		if (!$request->get('stakeholders_connected')) {
			$stakeholders_connected = [];
		} else {
			$stakeholders_connected = $request->get('stakeholders_connected');
		}

		// Detach connected stakeholders
		foreach ($this->stakeholdersConnectedOfThem as $scof) {
			$this->stakeholdersConnectedOfThem()->detach($scof->id);
		}
		$this->stakeholdersConnectedOfMine()->sync($stakeholders_connected);
	}

	public function sections()
	{
		return $this->hasMany('Issue\Section');
	}

	public function syncSections($sections)
	{
		$currentSections = $this->sections()->get();

		if (! is_array($sections)) {
			$sections = [];
		}

		foreach ($currentSections as $currentSection) {
			if (! array_key_exists($currentSection->id, $sections)) {
				$currentSection->delete();
				continue;
			}

			$currentSection->setSection($sections[$currentSection->id]);
			$currentSection->save();
			unset($sections[$currentSection->id]);
		}

		foreach ($sections as $sectionData) {
			$newSection = new Section;
			$newSection->setSection($sectionData);
			$this->sections()->save($newSection);
		}

		return true;
	}

	public function fileCv()
	{
		return $this->belongsTo('Issue\UploadedFile', 'uploaded_cv_id');
	}

	public function filePoza()
	{
		return $this->belongsTo('Issue\UploadedFile', 'uploaded_poza_id');
	}

	public static function getByPublicCode($code)
	{
		$instance = new static;

		return $instance->where('public_code', $code)->firstOrFail();
	}

	public function stakeholdersConnectedOfMine()
	{
		return $this->belongsToMany(
			'Issue\Stakeholder',
			'stakeholders_connected',
			'stakeholder_id',
			'stakeholder_connected_id'
		);
	}

	public function stakeholdersConnectedOfThem()
	{
		return $this->belongsToMany(
			'Issue\Stakeholder',
			'stakeholders_connected',
			'stakeholder_connected_id',
			'stakeholder_id'
		);
	}

	public function getStakeholdersConnectedAttribute()
	{
		if (! array_key_exists('stakeholders_connected', $this->relations)) {
			$this->loadStakeholdersConnected();
		}

		return $this->getRelation('stakeholders_connected');
	}

	protected function loadStakeholdersConnected()
	{
		if (! array_key_exists('stakeholders_connected', $this->relations)) {
			$stakeholders_connected = $this->mergeStakeholdersConnected();

			$this->setRelation('stakeholders_connected', $stakeholders_connected);
		}
	}

	protected function mergeStakeholdersConnected()
	{
		return $this->stakeholdersConnectedOfMine->merge($this->stakeholdersConnectedOfThem);
	}

	public function connectedNews()
	{
		return $this->belongsToMany(
			'Issue\Stakeholder',
			'news_stakeholder',
			'news_id'
		);
	}
}
