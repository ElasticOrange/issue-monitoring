<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

const DOCUMENT_LOCATION = '/news/';

class News extends Model
{
	use \Dimsav\Translatable\Translatable;

	protected $guarded = ['id'];

	protected $fillable = [
		'date',
		'link',
		'published',
	];

	public $dates = ['date','init_at'];

	public $translatedAttributes = ['title', 'description'];

	public function createPublicCode()
	{
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
		if (! $this->public_code) {
			$this->public_code = $this->createPublicCode();
		}

		if ($request->file('document_file')) {
			if ($this->fileDocument) {
				$this->fileDocument()->delete();
			}

			$DocumentFile = new UploadedFile;
			$DocumentFile->storeFile(DOCUMENT_LOCATION, $request->file('document_file'));
			$this->fileDocument()->associate($DocumentFile);
		}

		foreach (\Config::get('app.all_locales') as $locale) {
			$this->translateOrNew($locale)->title = $request->get('title')[$locale];
			$this->translateOrNew($locale)->description = $request->get('description')[$locale];
		}

		if (!$request->get('stakeholders_connected')) {
			$stakeholders_connected = [];
		} else {
			$stakeholders_connected = $request->get('stakeholders_connected');
		}

		$this->connectedStakeholders()->sync($stakeholders_connected);

		if (!$request->get('domains_connected')) {
			$domains_connected = [];
		} else {
			$domains_connected = $request->get('domains_connected');
		}
		$this->save();

		$this->connectedDomains()->sync($domains_connected);

		if (!$request->get('tags_connected')) {
			$tags_connected = [];
		} else {
			$tags_connected = $request->get('tags_connected');
		}

		$this->connectedTags()->sync($tags_connected);
	}

	public static function getByPublicCode($code)
	{
		$instance = new static;

		return $instance->where('public_code', $code)->firstOrFail();
	}

	public function fileDocument()
	{
		return $this->belongsTo('Issue\UploadedFile', 'uploaded_document_id');
	}

	public function connectedStakeholders()
	{
		return $this->belongsToMany('Issue\Stakeholder');
	}

	public function connectedDomains()
	{
		return $this->belongsToMany('Issue\Domain');
	}

	public function connectedIssues()
	{
		return $this->belongsToMany('Issue\Issue');
	}

	public function connectedTags()
	{
		return $this->belongsToMany('Issue\Tag');
	}
}
