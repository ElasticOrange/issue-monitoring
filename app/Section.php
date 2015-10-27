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

    public function setSections($request)
    {
        foreach (\Config::get('app.all_locales') as $locale)
        {
            $this->translateOrNew($locale)->title = $request->get('title')[$locale];
            $this->translateOrNew($locale)->description = $request->get('description')[$locale];
        }
            dd($this);
        $this->save();
    }
}
