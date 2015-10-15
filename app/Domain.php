<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];

    protected $guarded = ['id'];
}
