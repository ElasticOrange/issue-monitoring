<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('Issue\UploadedFile', 'uploaded_document_id');
    }

    public function domains()
    {
        return $this->belongsToMany(Domain::class);
    }
}
