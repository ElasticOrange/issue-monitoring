<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class FlowStep extends Model
{
	use \Dimsav\Translatable\Translatable;

	protected $with = ['flowstepsInLocation'];

	protected $guarded = ['id'];

	public $translatedAttributes = ['observatii'];

	public $dates = ['start_date', 'end_date'];

	protected $fillable = [
		'flow_name',
		'estimated_duration',
		'location_step_id',
		'flowstep_order',
		'start_date',
		'end_date',
		'observatii',
		'finalizat'
	];

	public function flowstepsInLocation()
	{
		return $this->belongsTo('Issue\LocationStep', 'location_step_id');
	}

	public function issueStep()
	{
		return $this->belongsTo('Issue\Issue');
	}

	public function documents()
	{
		return $this->belongsToMany(
			'Issue\Document',
			'document_flow_step',
			'flow_step_id',
			'document_id'
		);
	}

	public function syncStepDocuments($documents)
	{

		$this->documents()->sync($documents);

		return true;
	}

	public function alerts()
	{
		return $this->morphMany(Alert::class, 'alertable');
	}
}
