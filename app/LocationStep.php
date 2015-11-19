<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class LocationStep extends Model
{
	protected $guarded = ['id'];

	public function connectedIssueFlux()
	{
		$this->belongsToMany(
		'Issue\Issue',
		'location_steps',
		'location_id',
		'issue_id'
		);
	}
}
