<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class LegalNews extends Model
{
    use \Dimsav\Translatable\Translatable;

	protected $guarded = ['id'];

    protected $fillable = ['published', 'issue_id'];

    protected $translatedAttributes = ['title', 'content'];
}
