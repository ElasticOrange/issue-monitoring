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

}
