<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadedFile extends Model
{
	public function storeFile($directory, $uploadedFile)
	{
		Storage::makeDirectory($directory);

		if (! $uploadedFile) {
			return false;
		}

		do {
			$this->file_name = str_random(40);
		} while (UploadedFile::where('file_name', $this->file_name)->count() > 0);

		$this->folder = $directory;
		$this->original_file_name = $uploadedFile->getClientOriginalName();
		$uploadedFile->move(storage_path().$directory, $this->file_name);
		$this->mime_type = File::mimeType(storage_path().$directory.$this->file_name);
		$this->save();

		return true;
	}

	public function delete()
	{
		File::delete(storage_path() . $this->folder . $this->file_name);
		parent::delete();
	}

	public function document()
	{
		return $this->hasOne('Issue\Document');
	}

	public function stakeholder()
	{
		return $this->hasOne('Issue\Stakeholder');
	}

	public function news()
	{
		return $this->hasOne('Issue\News');
	}
}
