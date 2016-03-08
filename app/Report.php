<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

const REPORT_LOCATION = '/reports/';

class Report extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $guarded = ['id'];
    
    protected $with = ['domains'];

    protected $fillable = [
        'date',
        'report_type',
        'public'
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

    public function scopeReportTypeGeneral($query)
    {
        return $query->where('report_type', 1);
    }

    public function file()
    {
        return $this->belongsTo(UploadedFile::class, 'uploaded_file_id');
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
        
        if ($request->get('report_type') === "") {
            $this->report_type = 0;
        }
        
        $this->report_type = $request->get('report_type');

        if (! $this->public_code) {
            $this->public_code = $this->createPublicCode();
        }

        if ($request->file('document_file')) {
            if ($this->file) {
                $this->file()->delete();
            }

            $DocumentFile = new UploadedFile;
            $DocumentFile->storeFile(REPORT_LOCATION, $request->file('document_file'));
            $this->file()->associate($DocumentFile);
        }

        foreach (\Config::get('app.all_locales') as $locale) {
            $this->translateOrNew($locale)->title = $request->get('title')[$locale];
            $this->translateOrNew($locale)->description = $request->get('description')[$locale];
        }

        $this->public = $request->public == true;

        $this->save();

        if (!$request->get('domains_connected')) {
            $domains_connected = [];
        } else {
            $domains_connected = $request->get('domains_connected');
        }

        $this->domains()->sync($domains_connected);
    }
}
