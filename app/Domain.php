<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
	use \Dimsav\Translatable\Translatable;

	public $translatedAttributes = ['name'];

	protected $guarded = ['id'];
	protected $fillable = ['parent_id', 'name', 'public'];

	public function connectedNews()
	{
		return $this->belongsToMany('Issue\News');
	}

	public function parent()
	{
		return $this->belongsTo('Issue\Domain', 'parent_id');
	}

	public function connectedIssues()
	{
		return $this->belongsToMany('Issue\Issue');
	}

	public function scopeIsPublic($query)
	{
		return $query->where('public', 1);
	}
}
