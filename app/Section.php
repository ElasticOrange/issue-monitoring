<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $fillable = [
    	'title',
    	'description'
    ];

    public $translatedAttributes = ['title', 'description'];

    public function stakeholder()
    {
    	return $this->belongsTo('Issue\Stakeholder');
    }

    public function setSections($request, $stakeholder, $sec)
    {
        $this->stakeholder_id = $stakeholder->id;
        foreach (\Config::get('app.all_locales') as $locale)
        {
            $this->translateOrNew($locale)->title = $sec['title'][$locale];
            $this->translateOrNew($locale)->description = $sec['description'][$locale];
        }
        $this->save();
    }
}
