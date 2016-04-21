<?php

namespace Issue\Http\Controllers;

use Issue\UploadedFile;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Issue\Http\Controllers\Controller;

class UploadedFileController extends Controller
{
	public function downloadFile($fileName)
	{
		$entry = UploadedFile::where('file_name', $fileName)->firstOrFail();

		return response()->download(storage_path() . $entry->folder . $entry->file_name, $entry->original_file_name);
	}
}
