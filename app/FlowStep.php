<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class FlowStep extends Model
{
	use \Dimsav\Translatable\Translatable;

	protected $guarded = ['id'];

	public $translatedAttributes = ['observatii'];

	public $dates = ['start_date', 'end_date'];

	protected $fillable = [
		'flow_name',
		'estimated_duration',
		'location_step_id',
		'flowstep_order',
		'start_date',
		'end_date'
	];

	public function flowstepsInLocation()
	{
		return $this->belongsTo('Issue\locationStep', 'location_step_id');
	}

	public function issueStep()
	{
		return $this->belongsTo('Issue\Issue');
	}
}
