<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

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
			$this->translateOrNew($locale)->contact = $request->get('contact')[$locale];
			$this->translateOrNew($locale)->profile = $request->get('profile')[$locale];
			$this->translateOrNew($locale)->position = $request->get('position')[$locale];
		}

		$this->save();

		if (count($request->get('stakeholders_connected'))) {
			$this->stakeholdersConnected()->sync($request->get('stakeholders_connected'));
		}
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

	public function stakeholdersConnected()
	{
		return $one_way = $this->belongsToMany(
			'Issue\Stakeholder',
			'stakeholders_connected',
			'stakeholder_id',
			'stakeholder_connected_id'
		);
	}
}
