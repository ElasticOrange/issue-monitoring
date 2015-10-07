<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['description'];

    protected $guarded = ['id'];
}
