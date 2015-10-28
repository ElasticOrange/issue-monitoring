<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;
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
}
