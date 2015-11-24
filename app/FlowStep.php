<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class FlowStep extends Model
{
	protected $guarded = ['id'];

	public $dates = ['start_date', 'end_date'];

	protected $fillable = ['flow_name'];

	public function locations()
	{
		return $this->belongsTo('Issue\locationStep', 'location_step_id');
	}
}
