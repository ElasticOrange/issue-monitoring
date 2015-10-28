<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Storage;
use File;

class UploadedFile extends Model
{
    public function storeFile($directory, $uploadedFile)
    {
        Storage::makeDirectory($directory);

        if(! $uploadedFile)
        {
            return false;
        }

        while(UploadedFile::where('file_name', $this->file_name = str_random(40))->count() > 0)
        {
            $this->file_name = str_random(40);
        }

        $this->original_file_name = $uploadedFile->getClientOriginalName();
        $uploadedFile->move(storage_path().$directory, $this->file_name);
        $this->mime_type = File::mimeType(storage_path().$directory.$this->file_name);
        $this->save();

        return true;
    }

    public function document()
    {
        return $this->hasOne('Issue\Document');
    }
}