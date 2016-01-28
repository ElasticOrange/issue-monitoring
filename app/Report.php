<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

const DOCUMENT_LOCATION = '/reports/';

class Report extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $guarded = ['id'];

    protected $fillable = [
        'date',
    ];

    public $dates = ['date'];

    public $translatedAttributes = ['title', 'description'];

    public function createPublicCode()
    {
        do {
            $public_code = str_random(40);
        } while ($this->where('public_code', $public_code)->count() > 0);

        return $public_code;
    }

    public function alerts()
    {
        return $this->morphMany(Alert::class, 'alertable');
    }

    public function file()
    {
        return $this->belongsTo('Issue\UploadedFile', 'uploaded_file_id');
    }

    public function domains()
    {
        return $this->belongsToMany(Domain::class);
    }

    public static function getByPublicCode($code)
    {
        $instance = new static;

        return $instance->where('public_code', $code)->firstOrFail();
    }

    public function setAll($request)
    {
        $this->date = $request->get('date');

        if (! $this->public_code) {
            $this->public_code = $this->createPublicCode();
        }

        if ($request->file('document_file')) {
            if ($this->file) {
                $this->file()->delete();
            }

            $DocumentFile = new UploadedFile;
            $DocumentFile->storeFile(DOCUMENT_LOCATION, $request->file('document_file'));
            $this->file()->associate($DocumentFile);
        }

        foreach (\Config::get('app.all_locales') as $locale) {
            $this->translateOrNew($locale)->title = $request->get('title')[$locale];
            $this->translateOrNew($locale)->description = $request->get('description')[$locale];
        }

        $this->save();

        if (!$request->get('domains_connected')) {
            $domains_connected = [];
        } else {
            $domains_connected = $request->get('domains_connected');
        }

        $this->domains()->sync($domains_connected);
    }
}
