<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class LocationStep extends Model
{
	protected $guarded = ['id'];

	protected $fillable = [
		'location_id',
		'issue_id',
		'step_order'
	];

	public function issueFlux()
	{
		return $this->belongsTo('Issue\Issue');
	}

	public function locationFlux()
	{
		return $this->belongsTo('Issue\Location');
	}
}
