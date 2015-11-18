<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	use \Dimsav\Translatable\Translatable;

	public $translatedAttributes = ['name'];

	protected $guarded = ['id'];
	protected $fillable = ['parent_id'];

	public function parent()
	{
		return $this->belongsTo('Issue\Location', 'parent_id');
	}
}
