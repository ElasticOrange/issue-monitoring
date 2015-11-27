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

	public function issue()
	{
		return $this->belongsTo('Issue\Issue');
	}

	public function location()
	{
		return $this->belongsTo('Issue\Location', 'location_id');
	}

	public function flowsteps()
	{
		return $this->hasMany('Issue\FlowStep');
	}
}
