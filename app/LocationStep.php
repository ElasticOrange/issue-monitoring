<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class LocationStep extends Model
{
	protected $guarded = ['id'];

	public function issueFlux()
	{
		return $this->belongsTo('Issue\Issue');
	}

	public function locationFlux()
	{
		return $this->belongsTo('Issue\Location');
	}
}
