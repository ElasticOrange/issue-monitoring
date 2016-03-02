<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;
use Storage;

const DOCUMENTS_LOCATION = '/documents/';

class Document extends Model
{
	use \Dimsav\Translatable\Translatable;

	protected $with = ['file'];

	public $translatedAttributes = ['title'];

	public $dates = ['init_at'];

	protected $guarded = ['id'];

	public function file()
	{
		return $this->belongsTo('Issue\UploadedFile', 'uploaded_file_id');
	}

	public function createPublicCode()
	{
		do {
			$public_code = str_random(40);
		} while ($this->where('public_code', $public_code)->count() > 0);

		return $public_code;
	}

	public static function getByPublicCode($code)
	{
		$instance = new static;

		return $instance->where('public_code', $code)->firstOrFail();
	}

	public function fillDocument($request)
	{
		Storage::makeDirectory(DOCUMENTS_LOCATION);

		$this->init_at = $request->get('date');

		if (! $this->public_code) {
			$this->public_code = $this->createPublicCode();
		}
		$this->public = true;

		if ($request->file('file')) {
			if ($this->file) {
				$this->file->delete();
			}

			$file = new UploadedFile;
			$file->storeFile(DOCUMENTS_LOCATION, $request->file('file'));
			$this->file()->associate($file);
		}

		foreach (\Config::get('app.all_locales') as $locale) {
			$this->translateOrNew($locale)->title = $request->get('title')[$locale];
		}

		$this->save();
	}

	public function connectedDocumentIssues()
	{
		return $this->belongsToMany('Issue\Issue');
	}

	public function steps()
	{
		return $this->belongsToMany('Issue\FlowStep');
	}
}
