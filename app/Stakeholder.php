<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $fillable = [
    	'name',
    	'type',
    	'site',
    	'public_code',
    ];

    public $translatedAttributes = ['contact','profile','position'];

    protected $guarded = ['id'];

    public function setAll($request)
    {
    	$this->name = $request->get('name');
    	$this->type = $request->get('type');
    	$this->site = $request->get('site');
    	$this->public_code = $request->get('public_code');
        $this->published = $request->get('published') == true;

        foreach (\Config::get('app.all_locales') as $locale)
        {
            $this->translateOrNew($locale)->contact = $request->get('contact')[$locale];
            $this->translateOrNew($locale)->profile = $request->get('profile')[$locale];
            $this->translateOrNew($locale)->position = $request->get('position')[$locale];
        }

        $this->save();
    }

    public function sections()
    {
        return $this->hasMany('Issue\Section');
    }

    public function syncSections($sections)
    {
        $currentSections = $this->sections()->get();

        if ( ! is_array($sections)) {
            $sections = [];
        }

        foreach($currentSections as $currentSection)
        {
            if( ! array_key_exists($currentSection->id, $sections))
            {
                $currentSection->delete();
                continue;
            }

            $currentSection->setSection($sections[$currentSection->id]);
            $currentSection->save();
            unset($sections[$currentSection->id]);
        }

        foreach ($sections as $sectionData) {
            $newSection = new Section;
            $newSection->setSection($sectionData);
            $this->sections()->save($newSection);
        }

        return true;
    }

}
