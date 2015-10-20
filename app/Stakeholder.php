<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['contact','	profile','position'];

    protected $guarded = ['id'];
}