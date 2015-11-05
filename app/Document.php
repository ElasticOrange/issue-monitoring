<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;
use Storage;

const DOCUMENTS_LOCATION = '/documents/';

class Document extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['description'];

    public $dates = ['init_at'];

    protected $guarded = ['id'];

    public function file()
    {
        return $this->belongsTo('Issue\UploadedFile', 'uploaded_file_id');
    }

    public function createPublicCode() {
        do {
            $public_code = str_random(40);
        } while ($this->where('public_code', $public_code)->count() > 0);

        return $public_code;
    }

    public static function getByPublicCode($code) {
        $instance = new static;

        return $instance->where('public_code', $code)->firstOrFail();
    }

    public function fillDocument($document, $request) {
        $input = $request->all();
        Storage::makeDirectory(DOCUMENTS_LOCATION);

        $document->init_at = $input['date'];
        if (! $document->public_code) {
            $document->public_code = $document->createPublicCode();
        }
        $document->public = true;

        if ($request->file('file')){
            if ($document->file) {
                $document->file->delete();
            }

            $file = new UploadedFile;
            $file->storeFile(DOCUMENTS_LOCATION, $request->file('file'));
            $file->document()->save($document);
        }

        foreach (['ro', 'en'] as $locale)
        {
            $document->translateOrNew($locale)->description = $input['description'][$locale];
        }

        $this->save();
    }

}
