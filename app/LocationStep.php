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
		return $this->belongsTo('Issue\Location');
	}

	public function flowsteps()
	{
		return $this->hasMany('Issue\FlowStep');
	}

	public function syncSteps($steps)
	{
		$currentSteps = $this->flowsteps()->get();

		if (! is_array($steps)) {
			$steps = [];
		}

		$index = 0;
		foreach ($steps as $id => $step) {
			$index++;
			$steps[$id]['flowstep_order'] = $index;
		}
		foreach ($currentSteps as $currentStep) {
			if (! array_key_exists($currentStep->id, $steps)) {
				$currentStep->delete();
				continue;
			}

			$currentStep->fill($steps[$currentStep->id]);

			if (array_key_exists('observatii', $steps[$currentStep->id])) {
				foreach (\Config::get('app.all_locales') as $locale) {
					$currentStep->translateOrNew($locale)->observatii = $steps[$currentStep->id]['observatii'][$locale];
				}
			}

			$this->flowsteps()->save($currentStep);
			if (!array_key_exists('document_id', $steps[$currentStep->id])) {
				$steps[$currentStep->id]['document_id'] = [];
			}
			$currentStep->syncStepDocuments($steps[$currentStep->id]['document_id']);
			unset($steps[$currentStep->id]);
		}

		foreach ($steps as $stepData) {
			$newFlowStep = new FlowStep;
			$newFlowStep->fill($stepData);

			if (array_key_exists('observatii', $stepData)) {
				foreach (\Config::get('app.all_locales') as $locale) {
					$newFlowStep->translateOrNew($locale)->observatii = $stepData['observatii'][$locale];
				}
			}
			$this->flowsteps()->save($newFlowStep);

			if (!array_key_exists('document_id', $stepData)) {
				$stepData['document_id'] = [];
			}
			$newFlowStep->syncStepDocuments($stepData['document_id']);
		}

		return true;
	}
}
